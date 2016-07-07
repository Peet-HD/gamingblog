<?php

/* 
 * A general Gaming-Blog-Database-Exception for Exceptions in connection to the database
 * 
 * @author TH<>
 */
class GamingBlog_Database_Exception extends Zend_Exception
{
    public function __construct($msg = '', $code = 0, \Exception $previous = null) {
        parent::__construct($msg, $code, $previous);
    }
}