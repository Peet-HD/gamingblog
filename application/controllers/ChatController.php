<?php

/**
 * A Controller, which handles the chat-actions
 * 
 * @author TH<>
 */
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
    
    /**
     * helper-action to fetch the last chat-entries with ajax
     * 
     * @author TH<>
     */
    public function fetchlastentriesAction()
    {
        // Only authenticated user's can fetch chat-messages
        if ($this->_user->authenticate())
        {
            $lastNum = intval($this->_getParam('lastNum', 0));

            $dbChatFetcher = new GamingBlog_Database_Chat_Line_Fetcher($this->_db->read());
            
            $loginTime = $this->_user->getLoginTime();
            
            if ($lastNum >= 0)
            {
                $dbChatFetcher->setLastNum($lastNum);
            } else if (!empty($loginTime))
            {
                $dbChatFetcher->setMinEntryTime($loginTime);
            }

            $result = $dbChatFetcher->getResult();
        
             echo json_encode($result);
        } else {
            echo -1;
        }
    }
    
    /**
     * helper-action to send a new chat-line from a user
     * 
     * @author TH<>
     */
    public function sendentryAction()
    {
        // Only authenticated user's can write chat-messages
        if ($this->_user->authenticate())
        {
            // Trim whitespace from the text-param, if available, to check if the string is usable
            $strippedTextMsg = strip_tags(trim($this->_getParam('text', '')));

            if (strlen($strippedTextMsg) > 0)
            {
                
                $chatDbWriter = new GamingBlog_Database_Chat_Line_Writer($this->_db->write());
                $chatDbWriter->setUserId($this->_user->getId());
                $chatDbWriter->setText($strippedTextMsg);
                
                if ($this->_user->isAdmin())
                {
                    $chatDbWriter->setAdminEntry(true);
                }

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
        } else {
            echo -1;
            exit;
        }
    }
}

