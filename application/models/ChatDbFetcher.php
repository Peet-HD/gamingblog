<?php

class Application_Model_ChatDbFetcher extends GamingBlog_DbFetcher
{
    private $_lastUpdateTimestamp = 0;
    
    public function setMinimumTimestamp($val)
    {
        $this->_lastUpdateTimestamp = intval($val);
    }
            
    private function _getDataFields()
    {
        return array(
            'id' => 'gb_c.entryId',
            'timestamp' => 'gb_c.timestamp',
            'text' => 'gb_c.text'
        );
    }
    
    protected function _getSelectSql()
    {
        $subSelect = $this->_db->select();
        
        $subSelect->from(array('gb_c'=>'chat_data'), $this->_getDataFields())
                  ->order('entryId DESC');
        
        if ($this->_lastUpdateTimestamp > 0)
        {
            $subSelect->where('gb_c.timestamp > FROM_UNIXTIME(' . $this->_lastUpdateTimestamp . ')');
        }
        
        $sql = $this->_db->select();
        
        $sql->from(array('t' => new Zend_Db_Expr('(' . $subSelect . ')')))
            ->order('id ASC');
        
        //Debug::e($sql->__toString());
        
        return $sql;
    }
    
    protected function _getCountSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_c'=>'chat_data'), array('count' => 'Count(*)'));
        
        return $sql;
    }

}