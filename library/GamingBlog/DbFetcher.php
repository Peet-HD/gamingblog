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
    const FETCHMODE_ASSOC = 2;
    const FETCHMODE_ALL = 3;
    
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
    
    /**
     * The current data-page
     * 
     * @var int 
     */
    private $_page = -1;
    
    /**
     * The count per data-page
     * 
     * @var int 
     */
    private $_countPerPage = -1;
    
    public function __construct($pDb) {
        $this->_db = $pDb;
    }
    
    public function setFetchMode($fetchMode)
    {
        if (($fetchMode == GamingBlog_DbFetcher::FETCHMODE_ROW) ||
            ($fetchMode == GamingBlog_DbFetcher::FETCHMODE_ALL) ||
            ($fetchMode == GamingBlog_DbFetcher::FETCHMODE_ASSOC))
        {
            $this->_fetchMode = $fetchMode;
        }
    }
    
    public function setLimit($page, $countPerPage)
    {
        if (($page >= 0) && ($countPerPage >= 0))
        {
            $this->_page = intval($page);
            $this->_countPerPage = intval($countPerPage);
        }
    }
    
    public function getResult()
    {
        $selectSql = $this->_getSelectSql();
        
        switch($this->_fetchMode)
        {
            
        }
        
        switch ($this->_fetchMode)
        {
            case GamingBlog_DbFetcher::FETCHMODE_ROW:
                $res = $this->_db->fetchRow($selectSql);
                break;
            case GamingBlog_DbFetcher::FETCHMODE_ASSOC:
                if ($this->_page >= 0)
                {
                    $selectSql->limit($this->_countPerPage, $this->_countPerPage * $this->_page);
                }
                
                $res = $this->_db->fetchAssoc($selectSql);
                break;
            case GamingBlog_DbFetcher::FETCHMODE_ALL:
                if ($this->_page >= 0)
                {
                    $selectSql->limit($this->_countPerPage, $this->_countPerPage * $this->_page);
                }
                
                $res = $this->_db->fetchRow($selectSql);
                break;
        }
        
        return $res;
    }
    
    public function getCount()
    {
        $res = $this->_db->fetchRow($this->_getCountSql());
        
        return $res['count'];
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
    
    
    /**
     * @return Zend_Db_Select
     */
    protected abstract function _getSelectSql();
    /**
     * @return Zend_Db_Select
     */
    protected abstract function _getCountSql();
}