<?php

/**
 * The Admin-Controller offering management-actions for the admin
 * 
 * @author TH<>
 */
class AdminController extends GamingBlog_Controller_Action
{
    protected $_defaultController = 'Blog';
    protected $_defaultAction = 'overview';
    
    /**
     * Main-Action offering the register of a new user
     * 
     * @author TH<>
     */
    public function createpwAction()
    {
        $userPw = $this->_getParam("pw", 0);
        
        $pwHash = GamingBlog_User::createAdminPw($userPw);
        
        Debug::p($pwHash);
    }
    
    /**
     * The login-action for admins (can only be accessed by directly call the controller/action
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
    
    /**
     * The visitor-settings-page, offering the possibility to activate / deactivate /deleting visitor-accounts
     * 
     * @author TH<>
     */
    public function visitorsettingsAction()
    {
        // Redirect users without proper access
        if (!$this->_user->authenticate() || !$this->_user->isAdmin())
        {
            $this->redirect('/blog/overview');
        }
        
        $userId = $this->getParam('userId', -1);
        $mode = $this->getParam('mode', -1);
        
        $page = max(array(0, $this->getParam('page', 0)));
        
        // if a user-id and a proper mode are given, change the appropriate data, depending on the mode
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
        
        $userCount = $userFetcher->getCount();
        
        $elementsPerPage = 10;
        
        $maxPage = ceil(floatval($userCount) / $elementsPerPage) - 1;
        
        // limit the page-value to a proper range
        $page = min(array($page, $maxPage));
        
        $userFetcher->setLimit($page, $elementsPerPage);
        
        $this->_view->visitorList = $userFetcher->getResult();
        
        $this->_view->page = $page;
        $this->_view->elementsPerPage = $elementsPerPage;
        $this->_view->maxPage = $maxPage;
        
        $this->_view->render('admin/visitorsettings.tpl');
    }
    
    /**
     * The general-content-action offers the admin the possibility to change the content of the general-content-pages
     * 
     * @author TH<>
     */
    public function generalcontentAction()
    {
        // Redirect users without proper access
        if (!$this->_user->authenticate() || !$this->_user->isAdmin())
        {
            $this->redirect('/blog/overview');
        }
        
        // Fetch and add if available, success- or error-data
        if ($this->hasParam('saved'))
        {
            $this->_view->saved = $this->getParam('saved');
        } else {
            $this->_view->saved = '';
        }
        
        if ($this->hasParam('err'))
        {
            $this->_view->err = $this->getParam('err');
        } else {
            $this->_view->err = '';
        }
        
        
        $contentFetcher = new GamingBlog_Database_PageContent_Fetcher($this->_db->read());
        
        $pageContent = $contentFetcher->getResult();
        
        $contentIdReferences = $this->_config->get('content')->toArray();
        
        $this->_view->contentIdData = $contentIdReferences;
        
        if ($this->hasParam('editId'))
        {
            $this->_view->editId = $this->getParam('editId');
        }
        
        $this->_view->gameHtmlContent = isset($pageContent[$contentIdReferences['game']]) ? $pageContent[$contentIdReferences['game']] : '';
        $this->_view->companyHtmlContent = isset($pageContent[$contentIdReferences['company']]) ? $pageContent[$contentIdReferences['company']] : '';
        $this->_view->aboutHtmlContent = isset($pageContent[$contentIdReferences['about']]) ? $pageContent[$contentIdReferences['about']] : '';
        $this->_view->privacyHtmlContent = isset($pageContent[$contentIdReferences['privacy']]) ? $pageContent[$contentIdReferences['privacy']] : '';
        
        $this->_view->render('admin/generalcontent.tpl');
    }
    
    /**
     * The save-content-action saves the general content depeding on the given pageId-param
     * 
     * @author TH<>
     */
    public function savecontentAction()
    {
        // Redirect users without proper access
        if (!$this->_user->authenticate() || !$this->_user->isAdmin())
        {
            $this->redirect('/blog/overview');
        }
        
        if ($this->hasParam('pageId'))
        {
            $pageId = $this->getParam('pageId');
            
            $htmlContent = $this->getParam('htmlText' . $pageId);
        
            // Prepare a valid id-key-array
            $contentIdReferences = $this->_config->get('content')->toArray();
            $validPageIds = array_values($contentIdReferences);

            // Check if the page-id is valid
            if (in_array($pageId, $validPageIds))
            {
                $contentWriter = new GamingBlog_Database_PageContent_Writer($this->_db->write());

                $contentWriter->setHtmlContent($htmlContent);
                
                $contentByKeys = array_flip($contentIdReferences);

                if ($contentWriter->updateData($pageId) > 0)
                {
                    $this->redirect('/admin/generalcontent?saved=' . $contentByKeys[$pageId] . '#' . $contentByKeys[$pageId]);
                } else {
                    $this->redirect('/admin/generalcontent?err=' . $contentByKeys[$pageId] . '#' . $contentByKeys[$pageId]);
                }
            } else {
                $this->redirect('/admin/generalcontent?err=invalidId' . '&editId=' . '#' . $contentByKeys[$pageId]);
            }
        }
        
        $this->redirect('/admin/generalcontent');
    }
}

