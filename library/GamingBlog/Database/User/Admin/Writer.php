<?php

/* 
 * The Admin-User-Write to offer a direct access to the table for inserting / updating lines
 * 
 * @author TH<>
 */
class GamingBlog_Database_User_Admin_Writer extends GamingBlog_Database_Writer
{
    /**
     * The admin-id, can be set to update a specific row
     * 
     * @var int
     */
    private $_adminId;
    
    /**
     * The user-name
     * 
     * @var string
     */
    private $_userName;
    
    /**
     * The user-password
     * 
     * @var string
     */
    private $_password;
    
    /**
     * The user-email
     * 
     * @var string
     */
    private $_email;
    
    /**
     * The state-variable, which defines if the user-account is active (can be used)
     * 
     * @var int
     */
    private $_active;
    
    public function __construct($db) {
        parent::__construct($db, 'user_admin');
    }
    
    public function setAdminId($userId)
    {
        $this->_adminId = intval($userId);
        
        return $this;
    }
    
    public function setUsername($userName)
    {
        $this->_userName = $userName;
        
        return $this;
    }
    
    public function setPassword($password)
    {
        $this->_password = $password;
        
        return $this;
    }
    
    public function setEmail($email)
    {
        $this->_email = $email;
        
        return $this;
    }
    
    public function setActiveState($activeState)
    {
        $this->_active = intval($activeState) % 2;
        
        return $this;
    }

    protected function _getRowData() {
        
        $rowData = array();
        
        if (is_numeric($this->_adminId) && $this->_adminId >= 0)
        {
            $rowData['userId'] = $this->_adminId;
        }
        
        if (!empty($this->_userName))
        {
            $rowData['userName'] = $this->_userName;
        }
        
        if (!empty($this->_password))
        {
            $rowData['password'] = $this->_password;
        }
        
        if (!empty($this->_email))
        {
            $rowData['email'] = $this->_email;
        }
        
        if (!empty($this->_active))
        {
            $rowData['active'] = $this->_active;
        }
        
        return $rowData;
    }

    protected function _getPkField() {
        return 'adminId';
    }
}