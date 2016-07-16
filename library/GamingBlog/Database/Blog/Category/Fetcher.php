<?php

/**
 * A class to fetch blog-entry-data from the database
 * 
 * @author PB<>
 */
class GamingBlog_Database_Blog_Category_Fetcher extends GamingBlog_DbFetcher
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
                'categoryId'=> 'gb_bc.categoryId',
                'categoryName'=>'gb_bc.categoryName'
            );
    }
    
    protected function _getSelectSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_bc' => 'blog_category'), $this->_getDataFields());
        
        return $sql;
    }
    
    protected function _getCountSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_bc'=>'blog_category'), array('count' => 'Count(*)'));
        
        return $sql;
    }

}