<?php

/**
 * A class to fetch blog-entry-data from the database
 * 
 * @author PB<>
 */
class GamingBlog_Database_Blog_Entry_Fetcher extends GamingBlog_DbFetcher
{
    /**
     * 
     * @param Zend_Db_Adapter_Abstract $pDb
     */
    public function __construct($pDb) {
        parent::__construct($pDb);
    }
    
    private function _getDataFields()
    {
            return array(
                'id' => 'gb_be.blogId',
                'title' => 'gb_be.title',
                'text' => 'gb_be.text',
                'adminId' => 'gb_be.adminId',
                'timestamp' => 'gb_be.timestamp',
                'categoryId'=> 'gb_be.categoryId',
                'userName'=>'gb_a.userName'
            );
    }
    
    protected function _getSelectSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_be' => 'blog_entry'), $this->_getDataFields())
            ->joinInner(array('gb_a'=>'user_admin'),'gb_a.adminId=gb_be.adminId',array());
        
        return $sql;
    }
    
    protected function _getCountSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_be'=>'blog_entry'), array('count' => 'Count(*)'));
        
        return $sql;
    }

}