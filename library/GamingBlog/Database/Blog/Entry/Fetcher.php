<?php

/**
 * A class to fetch blog-entry-data from the database
 * 
 * @author PB<>
 */
class GamingBlog_Database_Blog_Entry_Fetcher extends GamingBlog_DbFetcher
{
    /**
     * Stores the filter-value for the entry-id
     * 
     * @var int 
     */
    private $_entryId;
    
    /**
     * 
     * @param Zend_Db_Adapter_Abstract $pDb
     */
    public function __construct($pDb) {
        parent::__construct($pDb);
    }
    
    public function setEntryId($entryId)
    {
        $this->_entryId = intval($entryId);
    }
    
    private function _getDataFields()
    {
            return array(
                'blogId' => 'gb_be.blogId',
                'title' => 'gb_be.title',
                'text' => 'gb_be.text',
                'adminId' => 'gb_be.adminId',
                'timestamp' => 'gb_be.timestamp',
                'categoryId'=> 'gb_be.categoryId',
                'userName'=>'gb_a.userName',
                'categoryName'=>'gb_bc.categoryName'
            );
    }
    
    protected function _getSelectSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_be' => 'blog_entry'), $this->_getDataFields())
            ->order('blogId DESC')
            ->joinInner(array('gb_a'=>'user_admin'),'gb_a.adminId=gb_be.adminId',array())
            ->joinInner(array('gb_bc'=>'blog_category'),'gb_bc.categoryId=gb_be.categoryId',array());
        
        if ($this->_entryId > -1)
        {
            $sql->where('gb_be.blogId = ?', $this->_entryId);
        }
        
        return $sql;
    }
    
    protected function _getCountSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_be'=>'blog_entry'), array('count' => 'Count(*)'));
        
        return $sql;
    }

}