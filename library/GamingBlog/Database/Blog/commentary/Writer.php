<?php

/**
 * A class to write blog-commentary-data to the database
 * 
 * @author PB<>
 * 
 */

class GamingBlog_Database_Blog_Commentary_Writer extends GamingBlog_Database_Writer
{
    /**
     * 
     * @param Zend_Db_Adapter_Abstract $pDb
     */
    
    private $_commentId = 0; 
    
    private $_blogId = 0;

    private $_text = '';
    
    private $_userId = 0;
    
    public function __construct($db) {
        parent::__construct($db, 'blog_entry');
    }
    
    public function setCommentId($commentId){
        
        $this->_commentId = $commentId;
        
        return $this;
    }
    
    public function setText($text){
        
        $this->_text = $text;
        
        return $this;
    }
    
    public function setBlogId($blogId){
        
        $this->_blogId = intval($blogId);
        
        return $this;
    }
    
    public function setUserId($userId){
        
        $this->_userId = intval($userId);
        
        return $this;
    }

    protected function _getPkField() {
        return 'blogId';
    }

    protected function _getRowData() {
        
        $rowData = array();
        
        if ($this->_commentId >= 0)
        {
            $rowData['commentId'] = $this->_commentId;
        }
        
        if($this->_blogId >= 0)
        {
            $rowData['blogId'] = $this->_blogId;
        }
        
        if(!empty($this->_text))
        {
            $rowData['text'] = $this->_text;
        }
        
        if($this->_userId >= 0)
        {
            $rowData['userId'] = $this->_userId;
        }
        
        return $rowData;
        
    }
    
    private function _setText() {
        
    }
}