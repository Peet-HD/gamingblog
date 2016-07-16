<?php

/**
 * A class to fetch visitor-user-data from the database
 * 
 * @author TH<>
 */
class GamingBlog_Database_User_Visitor_AccountSettings_Fetcher extends GamingBlog_DbFetcher
{
    private $_filterName = '';
    private $_filterMail = '';
    private $_filterActive = 0;
    
    private $_filterNameOrMail = false;
    
    public function setNameFilter($val)
    {
        $this->_filterName = $val;
    }
    
    public function setMailFilter($val)
    {
        $this->_filterMail = $val;
    }
    
    public function enableNameOrMailFilter()
    {
        $this->_filterNameOrMail = true;
    }
    
    public function setActiveFilter($val)
    {
        $this->_filterActive = intval($val) % 2;
    }
            
    private function _getDataFields()
    {
        return array(
            'id' => 'gb_u.userId',
            'name' => 'gb_u.userName',
            'email' => 'gb_u.email',
            'active' => 'gb_u.active',
            'activatedOnce' => 'gb_u.activatedOnce'
        );
    }
    
    protected function _getSelectSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_u' => 'user_visitor'), $this->_getDataFields());
        
        if ($this->_filterNameOrMail)
        {
            $sql->where('gb_u.userName = ?', $this->_filterName);
            $sql->orWhere('gb_u.email = ?', $this->_filterMail);
        } else {
            if (!empty($this->_filterName)) {
                $sql->where('gb_u.userName = ?', $this->_filterName);
            }

            if (!empty($this->_filterMail)) {
                $sql->where('gb_u.email = ?', $this->_filterMail);
            }
        }
        
        if (!empty($this->_filterPassword)) {
            $sql->where('gb_u.password = ?', $this->_filterPassword);
        }
        
        $sql->order('gb_u.activatedOnce ASC');
        $sql->order('gb_u.userName ASC');
        
        return $sql;
    }
    
    protected function _getCountSql()
    {
        $sql = $this->_db->select();
        
        $sql->from(array('gb_u'=>'user_visitor'), array('count' => 'Count(*)'));
        
        return $sql;
    }

}