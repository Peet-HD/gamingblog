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
    
    protected $_fetchMode = 3;
    
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
    
    /**
     * Sets the fetchmode for the fetcher-object.
     * Possible values are (1 => ROW, 2 => ALL, 3 => ASSOC)
     * 
     * @param type $fetchMode
     * 
     * @author TH<>
     */
    public function setFetchMode($fetchMode)
    {
        if (($fetchMode == GamingBlog_DbFetcher::FETCHMODE_ROW) ||
            ($fetchMode == GamingBlog_DbFetcher::FETCHMODE_ALL) ||
            ($fetchMode == GamingBlog_DbFetcher::FETCHMODE_ASSOC))
        {
            $this->_fetchMode = $fetchMode;
        }
    }
    
    /**
     * Offers a limiting to the sql-select
     * 
     * @param type $page
     * @param type $countPerPage
     * 
     * @author TH<>
     */
    public function setLimit($page, $countPerPage)
    {
        if (($page >= 0) && ($countPerPage >= 0))
        {
            $this->_page = intval($page);
            $this->_countPerPage = intval($countPerPage);
        }
    }
    
    /**
     * Returns the sql-result by applying the sql-select to the database
     * 
     * @return mixed
     * 
     * @author TH<>
     */
    public function getResult()
    {
        $selectSql = $this->_getSelectSql();
        
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
                
                $res = $this->_db->fetchAll($selectSql);
                break;
        }
        
        return $res;
    }
    
    /**
     * Returns the count-result by applying the sql-select to the database
     * 
     * @return mixed
     * 
     * @author TH<>
     */
    public function getCount()
    {
        $res = $this->_db->fetchRow($this->_getCountSql());
        
        return $res['count'];
    }
    
    
    /**
     * Function should prepare a Zend_Db_Select and return it
     * 
     * @return Zend_Db_Select
     */
    protected abstract function _getSelectSql();
    
    /**
     * Function should prepare a Zend_Db_Select and return it
     * 
     * @return Zend_Db_Select
     */
    protected abstract function _getCountSql();
}