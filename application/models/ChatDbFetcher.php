<?php

class Application_Model_ChatDbFetcher extends GamingBlog_DbFetcher
{
            
    private function _getDataFields()
    {
        return array(
            'id' => 'gb_c.entryId',
            'userId' => 'gb_c.userId',
            'text' => 'gb_c.text'
        );
    }
    
    protected function _getSelectSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_c'=>'chat_data'), $this->_getDataFields());
        
        return $sql;
    }
    
    protected function _getCountSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_c'=>'chat_data'), array('count' => 'Count(*)'));
        
        return $sql;
    }

}