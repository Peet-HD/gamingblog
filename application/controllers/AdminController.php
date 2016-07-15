<?php

class AdminController extends GamingBlog_Controller_Action
{
    protected $_defaultController = 'Blog';
    protected $_defaultAction = 'overview';
    
    /* Main-Action offering the register of a new user */
    public function createpwAction()
    {
        $userPw = $this->_getParam("pw", 0);
        
        $pwHash = GamingBlog_User::createAdminPw($userPw);
        
        Debug::p($pwHash);
    }
    
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

                $loginErrorData = $this->_user->tryAdminLogin($this->_db->write(), $userData);

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
       
        $this->_view->adminLogin = 1;
        $this->_view->render("user/login.tpl");
    }
    
    public function accountrequestsAction()
    {
        // Redirect users without proper access
        if (!$this->_user->authenticate() || !$this->_user->isAdmin())
        {
            $this->redirect('/blog/overview');
        }
        
        $userFetcher = new GamingBlog_Database_User_Visitor_Fetcher($this->_db->read());
        $userFetcher->setActiveFilter(0);
        
        $res = $userFetcher->getResult();
        
        Debug::p($res);
    }
}

