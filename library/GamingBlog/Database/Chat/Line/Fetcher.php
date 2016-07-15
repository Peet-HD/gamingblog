<?php

/**
 * A class to fetch chat-text-lines from the database
 * Offers a general Filtering, to fetch only messages from the last 5 seconds
 * and an optional Filtering, to fetch only messages higher than a specific num
 * 
 * @author TH<>
 */
class GamingBlog_Database_Chat_Line_Fetcher extends GamingBlog_DbFetcher
{
    private $_lastNum = 0;
    
    public function setLastNum($val)
    {
        $this->_lastNum = intval($val);
    }
            
    private function _getDataFields()
    {
        return array(
            'id' => 'gb_c.entryId',
            'timestamp' => 'gb_c.timestamp',
            'adminEntry' => 'gb_c.adminEntry',
            'author' => 'IF(gb_c.adminEntry = "0", gb_u.userName, gb_a.userName)',
            'text' => 'gb_c.text'
        );
    }
    
    protected function _getSelectSql()
    {
        $subSelect = $this->_db->select();
        
        $date = new DateTime();
        $currentTimeStamp = $date->getTimestamp();
        
        $subSelect->from(array('gb_c'=>'chat_data'), $this->_getDataFields())
                  ->order('entryId DESC')
                  ->joinLeft(array('gb_u' => 'user_visitor'), 'gb_u.userId = gb_c.userId', array())
                  ->joinLeft(array('gb_a' => 'user_admin'), 'gb_a.adminId = gb_c.userId', array());
        
        /**
         *  Restrict the minimum timestamp of fetched messages to (now - 5 seconds),
         *  to deny fetching more chat-data than necessary
        */
        $subSelect->where('gb_c.timestamp > FROM_UNIXTIME(' . ($currentTimeStamp-5) . ')');
        
        // If the last fetched index is provided, it will be used for filtering
        if ($this->_lastNum >= 0)
        {
            $subSelect->where('gb_c.entryId > ?', $this->_lastNum);
        }
        
        $sql = $this->_db->select();
        
        $sql->from(array('t' => new Zend_Db_Expr('(' . $subSelect . ')')))
            ->order('id ASC');
        
        return $sql;
    }
    
    protected function _getCountSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_c'=>'chat_data'), array('count' => 'Count(*)'));
        
        Debug::p($sql->__toString());
        return $sql;
    }

}