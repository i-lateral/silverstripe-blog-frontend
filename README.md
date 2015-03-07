Silverstripe Blog Front End Module
==================================

Module that adds a front end editing form to the blog module, allowing
users who have the correct permissions to write and edit blog posts
without logging into the admin interface.

## Dependancies

* [SilverStripe Framework 3.1.x](https://github.com/silverstripe/silverstripe-framework)
* [SilverStripe CMS 3.1.x](https://github.com/silverstripe/silverstripe-cms)
* [SilverStripe Blog](https://github.com/silverstripe/silverstripe-blog)

## Via composer

The default way to do this is to use composer. If you are doing this
you need to add:

    "i-lateral/silverstripe-blog-frontend":"*"

To your project's composer.json.

At the moment this module is still in heavy development. Once this cycle
stabalises we will look into adding stable releases.

## From source / manuallly

You can download this module either direct from the Silverstripe addons
directory or Github.

If you do, then follow this process:

* Download a Zip or Tarball of this module
* Extract the module into a directory callled "blog-frontend" in your project
* Run http://www.yoursite.com/dev/build?flush=all

## The management widget

This module includes a management widget. You will need to install the
Widgets module for this to work, but when installed will allow you to
add a widget to your sidebar that adds links for creting and editing
posts and moderating comments.
