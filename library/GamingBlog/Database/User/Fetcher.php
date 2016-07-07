<?php

/**
 * A class to fetch user-data from the database
 * 
 * @author TH<>
 */
class GamingBlog_Database_User_Fetcher extends GamingBlog_DbFetcher
{
    const DATA_COMPLETE = 1;
    const DATA_ID_ONLY = 2;
    
    private $_fetchFullData = false;
    
    private $_filterName = '';
    private $_filterPassword = '';
    private $_filterMail = '';
    private $_filterActive = 0;
    
    public function __construct($pDb, $fetchData = GamingBlog_Database_User_Fetcher::DATA_ID_ONLY) {
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
            );
        }
    }
    
    protected function _getSelectSql()
    {
        /*$subSelect = $this->_db->select();
        
        $date = new DateTime();
        $currentTimeStamp = $date->getTimestamp();
        
        $subSelect->from(array('gb_c'=>'chat_data'), $this->_getDataFields())
                  ->order('entryId DESC');
        
        // *  Restrict the minimum timestamp of fetched messages to (now - 5 seconds),
        // *  to deny fetching more chat-data than necessary
        $subSelect->where('gb_c.timestamp > FROM_UNIXTIME(' . ($currentTimeStamp-5) . ')');
        
        // If the last fetched index is provided, it will be used for filtering
        if ($this->_lastNum >= 0)
        {
            $subSelect->where('gb_c.entryId >= ?', $this->_lastNum);
        }*/
        
        $sql = $this->_db->select();
        
        $sql->from(array('gb_u' => 'user_data'), $this->_getDataFields());
        
        if (!empty($this->_filterName)) {
            $sql->where('gb_u.userName = ?', $this->_filterName);
        }
        
        if (!empty($this->_filterMail)) {
            $sql->where('gb_u.email = ?', $this->_filterMail);
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