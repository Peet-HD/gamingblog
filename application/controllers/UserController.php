<?php

class UserController extends GamingBlog_Controller_Action
{
    protected $_defaultController = 'Blog';
    protected $_defaultAction = 'overview';
    
    /* 
     * Main-Action offering the registration of a new visitor-user 
     * 
     * @author TH<>
     */
    public function registerAction()
    {
        $registerFinish = $this->_getParam("register", 0);
        
        if ($registerFinish == 1)
        {
            $userData = array(
                'name' => $this->_getParam("userName", ""),
                'email' => $this->_getParam("email", ""),
                'password' => $this->_getParam("password", "")
            );
            
            $errorData = GamingBlog_User::tryRegister($this->_db, $userData);
            
            if (empty($errorData))
            {
                $this->redirect('user/registerdone');
            } else {
                $this->_view->errorData = $errorData;
                
                $this->_view->inputData = $userData;
            }
        }
        
        $this->_view->render("user/register.tpl");
    }
    
    /* 
     * Registration-end-action shows a proper message, if registered correctly
     * 
     * @author TH<>
     */
    public function registerdoneAction()
    {
        $this->_view->render("user/register_done.tpl");
    }
    
    /**
     * The login-action for the visitor-user
     * 
     * @author TH<>
     */
    public function loginAction()
    {
        if ($this->_user->authenticate())
        {
            $this->redirect('/blog/overview');
        } else {

            if ($this->hasParam('submit'))
            {
                $userData = array(
                    'login' => $this->_getParam("userName"),
                    'password' => $this->_getParam("password")
                );

                $loginErrorData = $this->_user->tryVisitorLogin($this->_db->write(), $userData);

                if (!empty($loginErrorData))
                {
                    $this->_view->loginErrorData = $loginErrorData;
                    $this->_view->loginUserData = $userData;
                } else 
                {
                    $this->redirect("/blog/overview");
                }
            }
        }
        
        $this->_view->render("user/login.tpl");
    }
    
    /**
     * The logout-action for the visitor-user
     * 
     * @author TH<>
     */
    public function logoutAction()
    {
        $this->_user->logout();
        
        $this->redirect('/blog/overview');
    }
}

