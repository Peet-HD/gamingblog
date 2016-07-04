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
        $lastUpdateTimestamp = intval($this->_getParam('lastUpdate', 0));
        
        $db = Zend_Registry::get('db');
        
        $dbChatFetcher = new Application_Model_ChatDbFetcher($db);
        
        $lowestValidTimestamp = time()-10;
        
        if ($lastUpdateTimestamp > $lowestValidTimestamp)
        {
            $dbChatFetcher->setMinimumTimestamp($lastUpdateTimestamp);
        } else {
            $dbChatFetcher->setMinimumTimestamp($lowestValidTimestamp);
        }
        
        $result = $dbChatFetcher->getResult();
        
        echo json_encode($result);
    }
    
    public function sendentryAction()
    {
        $text = $this->_getParam('text');
        
        if (strlen($text) > 0)
        {
            $db = Zend_Registry::get('db');

            $db->insert('chat_data', array(
                'userId' => 0,
                'text' => $text
            ));

            echo $db->lastInsertId('order', 'order_id');
        }
    }
}

