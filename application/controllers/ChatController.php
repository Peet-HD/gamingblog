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
        // Only authenticated user's can write chat-messages
        if ($this->_user->authenticate())
        {
            // Trim whitespace from the text-param, if available, to check if the string is usable
            $text = trim($this->_getParam('text', ''));

            if (strlen($text) > 0)
            {
                $chatDbWriter = new GamingBlog_Database_Chat_Line_Writer($this->_db->write());
                $chatDbWriter->setUserId($this->_user->getId());
                $chatDbWriter->setText($text);

                /**
                 * Save the prepared chat-row and save the created index-num
                 */
                $retVal = $chatDbWriter->writeData();

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
}

