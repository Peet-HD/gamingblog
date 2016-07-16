<?php

/* 
 * The Visitor-User-Writer to offer a direct access to the table for inserting / updating lines
 * 
 * @author TH<>
 */
class GamingBlog_Database_User_Visitor_Writer extends GamingBlog_Database_Writer
{
    /**
     * The user-id, can be set to update a specific row
     * 
     * @var int
     */
    private $_userId;
    
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
     * @var int 0 or 1
     */
    private $_active = -1;
    
    
    /**
     * The state-variable, which defines if the user-account has been activated at least once
     * 
     * @var int 0 or 1 
     */
    private $_activatedOnce = -1;
    
    /**
     * The variable holds the time of the last-login
     * 
     * @var string 
     */
    private $_lastLogin = -1;
    
    public function __construct($db) {
        parent::__construct($db, 'user_visitor');
    }
    
    public function setUserId($userId)
    {
        $this->_userId = intval($userId);
        
        return $this;
    }
    
    public function setUsername($userName)
    {
        $this->_userName = $userName;
        
        return $this;
    }
    
    public function setLastLogin($time)
    {
        $this->_lastLogin = $time;
        
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
    
    public function setActiveOnceState($activatedOnceState)
    {
        $this->_activatedOnce = intval($activatedOnceState) % 2;
        
        return $this;
    }

    protected function _getRowData() {
        
        $rowData = array();
        
        if (is_numeric($this->_userId) && $this->_userId >= 0)
        {
            $rowData['userId'] = $this->_userId;
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
        
        if ($this->_active != -1)
        {
            $rowData['active'] = $this->_active;
        }
        
        if ($this->_activatedOnce != -1)
        {
            $rowData['activatedOnce'] = $this->_activatedOnce;
        }
        
        if ($this->_lastLogin != -1)
        {
            $rowData['lastLogin'] = $this->_lastLogin;
        }
        
        return $rowData;
    }

    protected function _getPkField() {
        return 'userId';
    }
}