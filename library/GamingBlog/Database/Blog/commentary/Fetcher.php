<?php

/**
 * A class to fetch blog-commentary-data from the database
 * 
 * @author PB<>
 */
class GamingBlog_Database_Blog_Commentary_Fetcher extends GamingBlog_DbFetcher
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
                'commentId' => 'gb_co.commentId',
                'text' => 'gb_co.text',
                'blogId' => 'gb_co.blogId',
                'timestamp' => 'gb_co.timestamp'
            );
    }
    
    protected function _getSelectSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_co' => 'blog_commentary'), $this->_getDataFields())
                ->order('timestamp DESC')
   //         ->joinInner(array('gb_uv'=>'userId'),'gb_uv.userId=gb_co.userId',array())
            ->joinInner(array('gb_be'=>'blog_entry'),'gb_be.blogId=gb_co.blogId',array());
        
        return $sql;
    }
    
    protected function _getCountSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_co'=>'blog_commentary'), array('count' => 'Count(*)'));
        
        return $sql;
    }

}