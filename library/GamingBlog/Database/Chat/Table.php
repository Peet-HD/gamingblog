<?php

/* 
 * The Chat-Line-Table-Class to offer a direct access to the table for inserting / updating lines
 */
class GamingBlog_Database_Chat_Table extends Zend_Db_Table_Abstract
{
    protected function _setupTableName()
    {
        $this->_name = 'chat_data';
        parent::_setupTableName();
    }
}