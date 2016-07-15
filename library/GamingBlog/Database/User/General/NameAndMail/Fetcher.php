<?php

/**
 * A class to fetch general user-data (name and mail) from the user- and the admin-table with prepared filters
 * 
 * @author TH<>
 */
class GamingBlog_Database_User_General_NameAndMail_Fetcher extends GamingBlog_DbFetcher
{
    private $_filterName = '';
    private $_filterMail = '';
    
    private $_dbVisitorPrefix = 'gb_u';
    private $_dbAdminPrefix = 'gb_a';
    
    public function __construct($pDb, $nameFilter, $mailFilter) {
        parent::__construct($pDb);
        
        $this->_filterName = $nameFilter;
        
        $this->_filterMail = $mailFilter;
    }
    
    public function setNameFilter($val)
    {
        $this->_filterName = $val;
    }
    
    public function setMailFilter($val)
    {
        $this->_filterMail = $val;
    }
            
    private function _getDataFields($prefix)
    {
        if (($prefix != $this->_dbAdminPrefix) && ($prefix != $this->_dbVisitorPrefix))
        {
            throw new GamingBlog_Database_Fetcher_Exception("Invalid db-prefix used");
        }
        
        return array(
            'name' => $prefix . '.userName',
            'email' => $prefix . '.email',
        );
    }
    
    protected function _getSelectSql()
    {
        $sqlVisitor = $this->_db->select();
        $sqlVisitor->from(array($this->_dbVisitorPrefix => 'user_visitor'), $this->_getDataFields($this->_dbVisitorPrefix));
        $sqlVisitor->where($this->_dbVisitorPrefix . '.userName = ?', $this->_filterName);
        $sqlVisitor->orWhere($this->_dbVisitorPrefix . '.email = ?', $this->_filterMail);
        
        $sqlAdmin = $this->_db->select();
        $sqlAdmin->from(array($this->_dbAdminPrefix => 'user_admin'), $this->_getDataFields($this->_dbAdminPrefix));
        $sqlAdmin->where($this->_dbAdminPrefix . '.userName = ?', $this->_filterName);
        $sqlAdmin->orWhere($this->_dbAdminPrefix . '.email = ?', $this->_filterMail);
        
        return $this->_db->select()->union(
            array(
                $sqlVisitor,
                $sqlAdmin
            )
        );
    }
    
    protected function _getCountSql()
    {
        // unnecessary for this fetcher
    }

}