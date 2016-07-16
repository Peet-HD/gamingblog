<?php

/**
 * An abstract Database-Row-Fetcher class, which demands proper sql-preparation-functions of children,
 * to offer the fetch of the data
 * 
 * @author TH<>
 */
abstract class GamingBlog_DbFetcher
{
    const FETCHMODE_ROW = 1;
    const FETCHMODE_ALL = 2;
    
    protected $_fetchMode = 2;
    
    /**
     * @var Zend_Db_Adapter_Pdo_Mssql
     */
    protected $_db;
    
    /**
     * @var Zend_Db_Select
     */
    protected $_baseSelect;
    
    /**
     * The minimum-fetched-index
     * 
     * @var int
     */
    private $_minFetch = 0;
    
    /**
     * The maximum-fetched-index
     * 
     * @var int
     */
    private $_maxFetch = -1;
    
    public function __construct($pDb) {
        $this->_db = $pDb;
    }
    
    public function setFetchMode($fetchMode)
    {
        if (($fetchMode == GamingBlog_DbFetcher::FETCHMODE_ROW) ||
            ($fetchMode == GamingBlog_DbFetcher::FETCHMODE_ALL))
        {
            $this->_fetchMode = $fetchMode;
        }
    }
    
    public function getResult()
    {
        if ($this->_fetchMode == GamingBlog_DbFetcher::FETCHMODE_ROW)
        {
            $res = $this->_db->fetchRow($this->_getSelectSql());
        } else {
            $res = $this->_db->fetchAll($this->_getSelectSql());
        }
        
        return $res;
    }
    
    public function getCount()
    {
        $res = $this->_db->fetchRow($this->_getCountSql());
        
        return $res;
    }
    
    
    public function limit($min, $max)
    {
        if (($min >= 0) && ($max > $min))
        {
            $this->_minFetch = $min;
            $this->_maxFetch = $max;
        } else {
            throw new GamingBlog_Database_Fetcher_Exception('Invalid Limit-Values used');
        }
    }
    
    
    protected abstract function _getSelectSql();
    protected abstract function _getCountSql();
}