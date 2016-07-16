<?php

/**
 * A class to fetch admin-user-data from the database
 * 
 * @author TH<>
 */
class GamingBlog_Database_User_Admin_Fetcher extends GamingBlog_DbFetcher
{
    /**
     * Fetches the full user-data
     */
    const DATA_COMPLETE = 1;
    /**
     * Fetches only the id, name and mail
     */
    const DATA_BASIC = 2;
    
    private $_fetchFullData = false;
    
    private $_filterName = '';
    private $_filterMail = '';
    private $_filterId = -1;
    private $_filterActive = -1;
    
    public function __construct($pDb, $fetchData = GamingBlog_Database_User_Visitor_Fetcher::DATA_BASIC) {
        parent::__construct($pDb);
        
        if ($fetchData == GamingBlog_Database_User_Visitor_Fetcher::DATA_COMPLETE)
        {
            $this->_fetchFullData = true;
        }
    }
    
    public function setNameFilter($val)
    {
        $this->_filterName = $val;
    }
    
    public function setMailFilter($val)
    {
        $this->_filterMail = $val;
    }
    
    public function setIdFilter($idVal)
    {
        $this->_filterId = intval($idVal);
    }
    
    public function setFilterActive($filterVal)
    {
        $this->_filterActive = intval($filterVal);
    }
            
    private function _getDataFields()
    {
        if ($this->_fetchFullData)
        {
            return array(
                'id' => 'gb_a.adminId',
                'name' => 'gb_a.userName',
                'password' => 'gb_a.password',
                'email' => 'gb_a.email',
                'active' => 'gb_a.active'
            );
        } else {
            return array(
                'id' => 'gb_a.adminId',
                'name' => 'gb_a.userName',
                'email' => 'gb_a.email'
            );
        }
    }
    
    /**
     * Prepares the select-select-sql and returns it
     * 
     * @return Zend_Db_Select
     */
    protected function _getSelectSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_a' => 'user_admin'), $this->_getDataFields());
        $sql->where('gb_a.active = 1');
        
        if (!empty($this->_filterName)) {
            $sql->where('gb_a.userName = ?', $this->_filterName);
        }

        if (!empty($this->_filterMail)) {
            $sql->where('gb_a.email = ?', $this->_filterMail);
        }
        
        if ($this->_filterId != -1)
        {
            $sql->where('gb_a.adminId = ?', $this->_filterId);
        }
        
        if ($this->_filterActive != -1)
        {
            $sql->where('gb_a.active = ?', $this->_filterActive);
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
        
        $sql->from(array('gb_u'=>'user_visitor'), array('count' => 'Count(*)'));
        
        return $sql;
    }

}