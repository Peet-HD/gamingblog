<?php

/* 
 * The GamingBlog-Database-class prepares and stores the both database-connections for read / write
 * 
 * @author TH<>
 */
class GamingBlog_Database
{
    /**
     * @var Zend_Config
     */
    private $_config_read;
    
    /**
     * @var Zend_Config
     */
    private $_config_write;
    
    /**
     * The variable for the read-db-user
     * 
     * @var Zend_Db_Adapter_Abstract 
     */
    private $_dbRead;
    
    /**
     * The variable for the write-db-user
     * 
     * @var Zend_Db_Adapter_Abstract 
     */
    private $_dbWrite;
    
    /**
     * 
     * @param Zend_Config $dbConfig
     */
    public function __construct($dbConfig) {
        
        if (!is_a($dbConfig, 'Zend_Config'))
        {
            throw new GamingBlogDbException('No configuration-data found !!.');
        } else if (($dbConfig->get('read') == null) ||
                   ($dbConfig->get('write') == null))
        {
            throw new GamingBlogDbException('read- or write-configuration is not available !!.');
        }
        
        $this->_config_read = $dbConfig->get('read')->get('params');
        $this->_config_write = $dbConfig->get('write')->get('params');
        
        $this->_dbRead = Zend_Db::factory('Pdo_Mysql', $this->_config_read);
        $this->_dbWrite = Zend_Db::factory('Pdo_Mysql', $this->_config_write);
    }
    
    /**
     * Returns the prepared read-db
     * 
     * @return Zend_Db_Adapter_Abstract
     */
    public function read()
    {
        return $this->_dbRead;
    }
    
    /**
     * Returns the prepared read-db
     * 
     * @return Zend_Db_Adapter_Abstract
     */
    public function write()
    {
        return $this->_dbWrite;
    }
}