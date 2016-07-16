<?php

/**
 * A class to write blog-entry-data to the database
 * 
 * @author PB<>
 * 
 */

class GamingBlog_Database_Blog_Entry_Writer extends GamingBlog_Database_Writer
{
    /**
     * 
     * @param Zend_Db_Adapter_Abstract $pDb
     */
    
    private $_title = '';    
    
    private $_text = '';
    
    private $_adminId = 0;
    
    private $_categoryId = 0;
    
    public function __construct($db) {
        parent::__construct($db, 'blog_entry');
    }
    
    public function setTitle($title){
        
        $this->_title = $title;
        
        return $this;
    }
    
    public function setText($text){
        
        $this->_text = $text;
        
        return $this;
    }
    
    public function setAdminId($adminId){
        
        $this->_adminId = intval($adminId);
        
        return $this;
    }
    
    public function setCategory($categoryId){
        
        $this->_categoryId = intval($categoryId);
        
        return $this;
    }

    protected function _getPkField() {
        return 'blogId';
    }
    
    protected function _getRowData() {
        
        $rowData = array();
        
        if ($this->_adminId >= 0)
        {
            $rowData['adminId'] = $this->_adminId;
        }
        
        if(!empty($this->_title))
        {
            $rowData['title'] = $this->_title;
        }
        
        if(!empty($this->_text))
        {
            $rowData['text'] = $this->_text;
        }
        
        if($this->_categoryId >= 0)
        {
            $rowData['categoryId'] = $this->_categoryId;
        }
        
        return $rowData;
        
    }
    

    
    private function _setText() {
        
    }
}