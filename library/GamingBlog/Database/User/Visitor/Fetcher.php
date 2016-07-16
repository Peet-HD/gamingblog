<?php

/**
 * A class to fetch visitor-user-data from the database
 * 
 * @author TH<>
 */
class GamingBlog_Database_User_Visitor_Fetcher extends GamingBlog_DbFetcher
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
    private $_filterPassword = '';
    private $_filterMail = '';
    private $_filterActive = -1;
    private $_filterId = -1;
    
    private $_filterNameOrMail = false;
    
    /**
     * @param Zend_Db_Adapter_Abstract $pDb
     * @param int $fetchData can have one of the following values: "..::DATA_COMPLETE" or "..::DATA_BASIC"
     */
    public function __construct($pDb, $fetchData = GamingBlog_Database_User_Visitor_Fetcher::DATA_BASIC) {
        parent::__construct($pDb);
        
        if ($fetchData == GamingBlog_Database_User_Visitor_Fetcher::DATA_COMPLETE)
        {
            $this->_fetchFullData = true;
        }
    }
    
    public function setIdFilter($idVal)
    {
        $this->_filterId = intval($idVal);
    }
    
    public function setNameFilter($val)
    {
        $this->_filterName = $val;
    }
    
    public function setMailFilter($val)
    {
        $this->_filterMail = $val;
    }
    
    public function enableNameOrMailFilter()
    {
        $this->_filterNameOrMail = true;
    }
    
    public function setPasswordFilter($val)
    {
        $this->_filterPassword = $val;
    }
    
    public function setFilterActive($filterVal)
    {
        $this->_filterActive = intval($filterVal)%2;
    }
            
    private function _getDataFields()
    {
        if ($this->_fetchFullData)
        {
            return array(
                'id' => 'gb_u.userId',
                'name' => 'gb_u.userName',
                'password' => 'gb_u.password',
                'email' => 'gb_u.email',
                'active' => 'gb_u.active',
                'activatedOnce' => 'gb_u.activatedOnce'
            );
        } else {
            return array(
                'id' => 'gb_u.userId',
                'name' => 'gb_u.userName',
                'email' => 'gb_u.email'
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
        
        $sql->from(array('gb_u' => 'user_visitor'), $this->_getDataFields());
        
        if ($this->_filterNameOrMail)
        {
            $sql->where('gb_u.userName = ?', $this->_filterName);
            $sql->orWhere('gb_u.email = ?', $this->_filterMail);
        } else {
            if (!empty($this->_filterName)) {
                $sql->where('gb_u.userName = ?', $this->_filterName);
            }

            if (!empty($this->_filterMail)) {
                $sql->where('gb_u.email = ?', $this->_filterMail);
            }
        }
        
        if (!empty($this->_filterPassword)) {
            $sql->where('gb_u.password = ?', $this->_filterPassword);
        }
        
        if ($this->_filterActive != -1)
        {
            $sql->where('gb_u.active = ?', $this->_filterActive);
        }
        
        if ($this->_filterId != -1)
        {
            $sql->where('gb_u.userId = ?', $this->_filterId);
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