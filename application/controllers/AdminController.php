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
    
    public function visitorsettingsAction()
    {
        // Redirect users without proper access
        if (!$this->_user->authenticate() || !$this->_user->isAdmin())
        {
            $this->redirect('/blog/overview');
        }
        
        $userId = $this->getParam('userId', -1);
        $mode = $this->getParam('mode', -1);
        
        $page = $this->getParam('page', 0);
        
        if (($userId != 0) && ($mode != -1))
        {
            $visitorWriter = new GamingBlog_Database_User_Visitor_Writer($this->_db->write());
            switch($mode)
            {
                case 'activate':
                    $visitorWriter->setActiveState(1)
                                  ->setActiveOnceState(1);
                    $visitorWriter->updateData($userId);
                    break;
                case 'deactivate':
                    $visitorWriter->setActiveState(0);
                    $visitorWriter->updateData($userId);
                    break;
                case 'delete':
                    $visitorWriter->deleteData($userId);
                    break;
            }
        }
        
        $userFetcher = new GamingBlog_Database_User_Visitor_AccountSettings_Fetcher($this->_db->read());
        
        $this->_view->visitorList = $userFetcher->getResult();
        
        //Debug::p($userFetcher->getCount());
        $this->_view->navActive = 'accountrequests';
        
        $this->_view->render('admin/visitorsettings.tpl');
    }
}

