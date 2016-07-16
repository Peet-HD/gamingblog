<?php

/**
 * A class to fetch general-page-content-data from the database
 * 
 * @author TH<>
 */
class GamingBlog_Database_PageContent_Fetcher extends GamingBlog_DbFetcher
{
    private $_filterId = -1;
    
    public function setIdFilter($idVal)
    {
        $this->_filterId = intval($idVal);
    }
    
    private function _getDataFields()
    {
        return array(
            'id' => 'gb_gpc.contentId',
            'htmlContent' => 'gb_gpc.pageHtml',
            'lastChange' => 'gb_gpc.lastChange'
        );
    }
    
    /**
     * Prepares the select-select-sql and returns it
     * 
     * @return Zend_Db_Select
     */
    protected function _getSelectSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_gpc' => 'general_page_content'), $this->_getDataFields());
        
        if ($this->_filterId != -1) {
            $sql->where('gb_gpc.contentId = ?', $this->_filterId);
        }
        
        return $sql;
    }
    
    /**
     * Prepares the count-select-sql and returns it
     * 
     * @return Zend_Db_Select
     */
    protected function _getCountSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_gpc'=>'general_page_content'), array('count' => 'Count(*)'));
        
        return $sql;
    }

}