<?php

/**
 * An abstract Database-Row-Fetcher class, which demands proper sql-preparation-functions of children,
 * to offer the fetch of the data
 * 
 * @author TH<>
 */
abstract class GamingBlog_DbFetcher
{
    /**
     * @var Zend_Db_Adapter_Pdo_Mssql
     */
    protected $_db;
    
    /**
     * @var Zend_Db_Select
     */
    protected $_baseSelect;
    
    public function __construct($pDb) {
        $this->_db = $pDb;
    }
    
    public function getResult()
    {
        $res = $this->_db->fetchAll($this->_getSelectSql());
        
        return $res;
    }
    
    
    protected abstract function _getSelectSql();
    protected abstract function _getCountSql();
}