<?php

if(class_exists('Widget')) {

	/**
	 * Blog Management Widget
	 * 
	 * @package blog
	 */
	class BlogManagementWidget extends Widget {

		private static $title = "Blog Management";
		
		private static $cmsTitle = "Blog Management";
		
		private static $description = "Provide links for administering the blog.";

		public function CommentText() {
			if(!class_exists('Comment')) return false;
            
            $unmoderated = Comment::get()
                ->filter("Moderated", 1)
                ->count();
            
			if($unmoderated == 1) {
				return _t("BlogFrontEnd.Unmoderated1", "You have 1 unmoderated comment");
			} else if($unmoderated > 1) {
				return sprintf(_t("BlogFrontEnd.UNMM", "You have %i unmoderated comments"), $unmoderatedcount);
			} else {
				return _t("BlogFrontEnd.CommentAdmin", "Comment administration");
			}
		}

		public function CommentLink() {
			if(!Permission::check('BLOG_FRONTENDMANAGEMENT') || !class_exists('Comment')) return false;
			
            $unmoderated = Comment::get()
                ->filter("Moderated", 1)
                ->count();

			if($unmoderated > 0)
				return "admin/comments/unmoderated";
			else
				return "admin/comments";
		}

	}

	class BlogManagementWidget_Controller extends Widget_Controller { 
		
		function WidgetHolder() { 
			if(Permission::check("BLOG_FRONTENDMANAGEMENT")) { 
				return $this->renderWith("WidgetHolder"); 
			} 
		}
		
		function PostLink() {
			$container = Controller::curr();
            
			return ($container && $container->ClassName == "Blog") ? $container->Link('post') : false; 
		}
	}

}
