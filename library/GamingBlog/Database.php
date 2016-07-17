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
    
    /**
     * Checks if the text contains html-limiters
     * 
     * @param type $text
     * @return boolean
     */
    public static function containsHtmlLimiters($text)
    {
        $decodedText = html_entity_decode($text);
        
        if (preg_match('/[\<\>]/', $decodedText))
        {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Checks if the Username contains invalid characters
     * 
     * @param type $name
     * @return boolean
     */
    public static function containsInvalidUserNameChars($name)
    {
        $decodedText = html_entity_decode($name);
        
        if (preg_match('/[^a-zA-Z0-9\_]/', $decodedText))
        {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Strips xss-tags "script" and "iframe"
     * @param string $text
     * @return type
     */
    public static function stripXss($text, $stripLimiters = false)
    {
        $decodedHtml = html_entity_decode($text);
        $regexSearch = '/\<((\s*\/?(\s*j\s*a\s*v\s*a)?\s*s\s*c\s*r\s*i\s*p\s*\s*t\s*)|(\s*\/?\s*i\s*f\s*r\s*a\s*m\s*e\s*[^\>]*))\>/';
        
        $replaceTimes = 0;
        while (preg_match($regexSearch, $decodedHtml))
        {
            if ($replaceDeph >= 5)
            {
                $decodedHtml = 'Invalid corrupted text can\'t be parsed. Contact administrator.';
                break;
            }
            
            $decodedHtml = preg_replace($regexSearch,'', $decodedHtml);
            
            $replaceTimes++;
        }
        
        if ($stripLimiters)
        {
            $decodedHtml = preg_replace('/[\<\>]/', '', $decodedHtml);
        }
        
        return $decodedHtml;
    }
}