<?php

class UserController extends GamingBlog_Controller_Action
{
    protected $_defaultController = 'Blog';
    protected $_defaultAction = 'overview';
    
    /* Main-Action offering the register of a new user */
    public function registerAction()
    {
        
        $this->_view->render("blog/overview.tpl");
    }
    
    public function loginAction()
    {
        
    }
}

