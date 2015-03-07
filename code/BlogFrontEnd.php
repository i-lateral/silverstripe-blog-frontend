<?php

/**
 * Class that contains our config data for the front end module
 * 
 * @author ilateral (www.ilateral.co.uk)
 * @package blog-frontend
 */
class BlogFrontEnd extends Object {
   
   /**
    * Do we want to allow wysiwyg editing in the front end? Enabling
    * this adds a HTMLEditor field to the blog front end form.
    * 
    * @var Boolean
    * @config
    */
    private static $allow_wysiwyg_editing = true;
    
}
