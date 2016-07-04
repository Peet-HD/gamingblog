<?php

class ChatController extends GamingBlog_Controller_Action
{
    /**
     * index-action of the helper-controller, doesnt render it's own view, but redirects to the default-controller
     * 
     * @author TH<>
     */
    public function indexAction()
    {
        $frontCont = $this->getFrontController();
        $this->redirect('/' . $frontCont->getDefaultControllerName() . '/' . $frontCont->getDefaultAction());
    }
    
    public function fetchlastentriesAction()
    {
        $db = Zend_Registry::get('db');
        
        $dbFetcher = new Application_Model_ChatDbFetcher($db);
        $result = $dbFetcher->getResult();
        
        echo json_encode($result);
    }
}

