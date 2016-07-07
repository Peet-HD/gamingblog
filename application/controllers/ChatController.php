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
        $lastNum = intval($this->_getParam('lastNum', 0));
        
        $this->_dbChatFetcher = new GamingBlog_Database_Chat_Line_Fetcher($this->_db->read());
        
        if ($lastNum >= 0)
        {
            $this->_dbChatFetcher->setLastNum($lastNum);
        } else {
            $this->_dbChatFetcher->setLastNum($lastNum);
        }
        
        $result = $this->_dbChatFetcher->getResult();
        
        echo json_encode($result);
    }
    
    public function sendentryAction()
    {
        // Trim whitespace from the text-param, if available, to check if the string is usable
        $text = trim($this->_getParam('text', ''));
        
        if (strlen($text) > 0)
        {
            $chatUpdater = new GamingBlog_Database_Chat_Table(array('db' => $this->_db->write()));
            
            $newRow = $chatUpdater->createRow(
                array(
                    'userId' => 0,
                    'text' => $text
                )
            );
            
            /**
             * Save the prepared chat-row and save the created index-num
             */
            $retVal = $newRow->save();

            if ($retVal >= 0)
            {
                echo $retVal;
                exit;
            }
        }
        
        // On error return -1
        echo -1;
        exit;
    }
}

