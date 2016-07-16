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
        
        $page = max(array(0, $this->getParam('page', 0)));
        
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
        
        $page = min(array($page, $maxPage));
        
        $userFetcher->setLimit($page, $elementsPerPage);
        
        $this->_view->visitorList = $userFetcher->getResult();
        
        $this->_view->page = $page;
        $this->_view->elementsPerPage = $elementsPerPage;
        $this->_view->maxPage = $maxPage;
        
        $this->_view->render('admin/visitorsettings.tpl');
    }
    
    public function generalcontentAction()
    {
        // Redirect users without proper access
        if (!$this->_user->authenticate() || !$this->_user->isAdmin())
        {
            $this->redirect('/blog/overview');
        }
        
        if ($this->hasParam('saved'))
        {
            $this->_view->saved = $this->getParam('saved');
        } else if ($this->hasParam('err'))
        {
            $this->_view->err = $this->getParam('err');
        }
        
        $contentFetcher = new GamingBlog_Database_PageContent_Fetcher($this->_db->read());
        
        $pageContent = $contentFetcher->getResult();
        
        $contentIdReferences = $this->_config->get('content')->toArray();
        
        $this->_view->contentIdData = $contentIdReferences;
        
        $this->_view->gameHtmlContent = isset($pageContent[$contentIdReferences['game']]) ? $pageContent[$contentIdReferences['game']]['htmlContent'] : '';
        $this->_view->companyHtmlContent = isset($pageContent[$contentIdReferences['company']]) ? $pageContent[$contentIdReferences['company']]['htmlContent'] : '';
        $this->_view->aboutHtmlContent = isset($pageContent[$contentIdReferences['about']]) ? $pageContent[$contentIdReferences['about']]['htmlContent'] : '';
        $this->_view->privacyHtmlContent = isset($pageContent[$contentIdReferences['privacy']]) ? $pageContent[$contentIdReferences['privacy']]['htmlContent'] : '';
        
        $this->_view->render('admin/generalcontent.tpl');
    }
    
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
        
            $contentIdReferences = $this->_config->get('content')->toArray();
            $validPageIds = array_values($contentIdReferences);

            if (in_array($pageId, $validPageIds))
            {
                $contentWriter = new GamingBlog_Database_PageContent_Writer($this->_db->write());

                $contentWriter->setHtmlContent($htmlContent);
                
                $contentByKeys = array_flip($contentIdReferences);

                if ($contentWriter->updateData($pageId) > 0)
                {
                    $this->redirect('/admin/generalcontent?saved=' . $contentByKeys[$pageId]);
                } else {
                    $this->redirect('/admin/generalcontent?err=' . $contentByKeys[$pageId]);
                }
            } else {
                $this->redirect('/admin/generalcontent?err=invalidId');
            }
        }
        
        $this->redirect('/admin/generalcontent');
    }
}

