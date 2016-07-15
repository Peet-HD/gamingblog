<?php

/* 
 * The Chat-Line-Table-Class to offer a direct access to the table for inserting / updating lines
 */
class GamingBlog_Database_Chat_Line_Writer extends GamingBlog_Database_Writer
{
    /**
     * The user-id, can be set to update a specific row
     * 
     * @var int
     */
    private $_userId;
    
    /**
     * The written chat-message
     * 
     * @var string
     */
    private $_text;
    
    /**
     * The boolean info, if the message comes from an admin
     * 
     * @var bool
     */
    private $_isAdminEntry = 0;
    
    public function __construct($db) {
        parent::__construct($db, 'chat_data');
    }
    
    public function setUserId($userId)
    {
        $this->_userId = intval($userId);
        
        return $this;
    }
    
    public function setText($text)
    {
        $this->_text = $text;
        
        return $this;
    }
    
    public function setAdminEntry($boolVal)
    {
        $this->_isAdminEntry = intval($boolVal) % 2;
        
        return $this;
    }

    protected function _getRowData() {
        
        $rowData = array();
        
        $rowData['adminEntry'] = $this->_isAdminEntry;
        
        if ($this->_userId >= 0)
        {
            $rowData['userId'] = $this->_userId;
        }
        
        if (!empty($this->_text))
        {
            $rowData['text'] = $this->_text;
        }
        
        return $rowData;
    }

    protected function _getPkField() {
        return 'entryId';
    }

}