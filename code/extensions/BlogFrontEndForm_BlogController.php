<?php

class BlogFrontEndForm_BlogController extends Extension implements PermissionProvider
{
    
    private static $allowed_actions = array(
        "post",
        "doSavePost"        => "BLOG_FRONTENDMANAGEMENT",
        "FrontEndPostForm"  => "BLOG_FRONTENDMANAGEMENT"
    );
    
    /**
     * Create a new blog post
     */
    public function post()
    {
        if (!Permission::check('BLOG_FRONTENDMANAGEMENT')) {
            return Security::permissionFailure();
        }
        
        Requirements::css("blog-frontend/css/BlogFrontEnd.css");
        
        $this->owner->customise(array(
            "Title" => _t("BlogFrontend.PostTitle", "New Blog Post"),
            "MetaTitle" => _t("BlogFrontend.PostMetaTitle", "New Blog Post"),
            "Form" => $this->FrontEndPostForm()
        ));
        
        $this->owner->extend("onBeforePost");
        
        return $this
            ->owner
            ->renderWith(array(
                "Blog_post",
                "Page"
            ));
    }
    
    /**
     * A simple form for creating blog entries
     */
    public function FrontEndPostForm()
    {
        if ($this->owner->request->latestParam('ID')) {
            $id = (int) $this->owner->request->latestParam('ID');
        } else {
            $id = 0;
        }

        $membername = Member::currentUser() ? Member::currentUser()->getName() : "";
        
        // Set image upload
        $uploadfield = UploadField::create(
            'FeaturedImage',
            _t('BlogFrontEnd.ShareImage', "Share an image")
        );
        
        $uploadfield->setCanAttachExisting(false);
        $uploadfield->setCanPreviewFolder(false);
        $uploadfield->setAllowedFileCategories('image');
        $uploadfield->relationAutoSetting = false;
        
        if (BlogFrontEnd::config()->allow_wysiwyg_editing) {
            $content_field = TrumbowygHTMLEditorField::create(
                "Content",
                _t("BlogFrontEnd.Content")
            );
        } else {
            $content_field = TextareaField::create(
                "Content",
                _t("BlogFrontEnd.Content")
            );
        }
        
        $form = new Form(
            $this->owner,
            'FrontEndPostForm',
            $fields = new FieldList(
                HiddenField::create("ID", "ID"),
                TextField::create("Title", _t('BlogFrontEnd.Title', "Title")),
                $uploadfield,
                $content_field
            ),
            $actions = new FieldList(
                FormAction::create(
                'doSavePost',
                _t('BlogFrontEnd.PostEntry', 'Post Entry'))
            ),
            new RequiredFields('Title')
        );
        
        $uploadfield->setForm($form);
        
        if ($this->owner->Categories()->exists()) {
            $fields->add(CheckboxsetField::create(
                "Categories",
                _t("BlogFrontEnd.PostUnderCategories", "Post this in a category? (optional)"),
                $this->owner->Categories()->map()
            ));
        }
        
        if ($this->owner->Tags()->exists()) {
            $fields->add(CheckboxsetField::create(
                "Categories",
                _t("BlogFrontEnd.AddTags", "Add a tag? (optional)"),
                $this->owner->Tags()->map()
            ));
        }

        if ($id && $post = BlogPost::get()->byID($id)) {
            $form->loadDataFrom($post);
        }

        $this->owner->extend("updateFrontEndPostForm", $form);

        return $form;
    }

    public function doSavePost($data, $form)
    {
        $post = false;

        if (isset($data['ID']) && $data['ID']) {
            $post = BlogPost::get()->byID($data['ID']);
        }

        if (!$post) {
            $post = BlogPost::create();
        }

        $form->saveInto($post);
        $post->ParentID = $this->owner->ID;

        $this->owner->extend("onBeforeSavePost", $blogentry);

        $oldMode = Versioned::get_reading_mode();
        Versioned::reading_stage('Stage');
        $post->write();
        $post->publish("Stage", "Live");
        Versioned::set_reading_mode($oldMode);

        $this->owner->extend("onAfterSavePost", $post);

        $this->owner->redirect($this->owner->Link());
    }
    
    public function providePermissions()
    {
        return array(
            "BLOG_FRONTENDMANAGEMENT" => array(
                'name' => 'Frontend Blog Management',
                'help' => 'Manage blog posts via the front end of the site',
                'category' => 'Blog',
                'sort' => 50
            )
        );
    }
}
