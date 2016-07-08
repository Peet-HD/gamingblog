<?php

/**
 * A class to fetch user-data from the database
 * 
 * @author TH<>
 */
class GamingBlog_Database_User_Fetcher extends GamingBlog_DbFetcher
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
    private $_filterActive = 0;
    
    private $_filterNameOrMail = false;
    
    public function __construct($pDb, $fetchData = GamingBlog_Database_User_Fetcher::DATA_BASIC) {
        parent::__construct($pDb);
        
        if ($fetchData == GamingBlog_Database_User_Fetcher::DATA_COMPLETE)
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
    
    public function enableNameOrMailFilter()
    {
        $this->_filterNameOrMail = true;
    }
    
    public function setPasswordFilter($val)
    {
        $this->_filterPassword = $val;
    }
    
    public function setActiveFilter($val)
    {
        $this->_filterActive = intval($val) % 2;
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
                'active' => 'gb_u.active'
            );
        } else {
            return array(
                'id' => 'gb_u.userId',
                'name' => 'gb_u.userName',
                'email' => 'gb_u.email'
            );
        }
    }
    
    protected function _getSelectSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_u' => 'user_data'), $this->_getDataFields());
        
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
        
        return $sql;
    }
    
    protected function _getCountSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_u'=>'user_data'), array('count' => 'Count(*)'));
        
        return $sql;
    }

}