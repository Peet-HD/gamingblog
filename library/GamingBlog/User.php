<?php

/**
 * Gaming-Blog-User class, stores the user-specific data in a session-namespace
 * 
 * @author TH<>
 */
class GamingBlog_User
{
    /**
     * @var Zend_Session_Namespace
     */
    protected $_userSess;
    
    private static $_pwSalt = 'gblog_salt';
    
    /**
     * The expiration-time of the user-session
     */
    const expirationTime = 1500;  
    
    /**
     * The current ip-addr
     * 
     * @var string
     */
    private $_currentIpAddr;
    
    /**
     * @param Zend_Db_Adapter_Abstract $db
     */
    public function __construct($dbRead) {
        $this->_userSess = new Zend_Session_Namespace('gamingblog_user');
        $this->_userSess->setExpirationSeconds($this::expirationTime);
        
        if ($this->authenticate() && !$this->isAdmin() && $this->isActiveCheckRequired()) {
            
            $userFetcher = new GamingBlog_Database_User_Visitor_Fetcher($dbRead);
            $userFetcher->setIdFilter($this->_userSess->data['id']);
            $userFetcher->setFilterActive(1);
            $userFetcher->setFetchMode(GamingBlog_DbFetcher::FETCHMODE_ROW);

            $res = $userFetcher->getResult();
            
            if (empty($res) || ($res['id'] != $this->_userSess->data['id']))
            {
                $this->logout();
            } else {
                $this->_userSess->data['lastActiveCheck'] = time();
            }
        }
    }
    
    /**
     * Tries to login with the given visitor-data
     * If the visitor exists a check if the password needs to be rehashed will be done
     * 
     * @param type $dbWrite
     * @param type $userData
     * @return array
     */
    public function tryVisitorLogin($dbWrite, $userData)
    {
        $errorData = array();
        
        if (!isset($userData['login']) || empty($userData['login']))
        {
            $errorData['missingLogin'] = 1;
        }
        
        if (!isset($userData['password']) || empty($userData['password']))
        {
            $errorData['missingPassword'] = 1;
        }
        
        if (empty($errorData))
        {
            $userFetcher = new GamingBlog_Database_User_Visitor_Fetcher($dbWrite, GamingBlog_Database_User_Visitor_Fetcher::DATA_COMPLETE);
            $userFetcher->setFetchMode(GamingBlog_DbFetcher::FETCHMODE_ROW);
            $userFetcher->setNameFilter($userData['login']);

            $res = $userFetcher->getResult();
            
            $saltedUserPw = GamingBlog_User::getSaltedPw($userData['password']);
            
            // Check if the complete user-data has been fetched from the database, the user is active and the password is correct
            if (!isset($res['name']) || empty($res['name']) ||
                !isset($res['id']) || ($res['id'] < 0) ||
                !isset($res['password']) || empty($res['password']) ||
                !isset($res['email']) || empty($res['email']) ||
                /**
                 * @todo TODO TODO TODO unbedingt das active-flag wieder auf 1 schalten,
                 * damit korrekt geprüft wird, welcher account aktiv geschaltet wurde
                 */
                !isset($res['active']) || ($res['active'] != 1) ||
                !password_verify($saltedUserPw, $res['password'])) {
                
                $errorData['invalidLogin'] = 1;
            } else {
                $userDbWriter = new GamingBlog_Database_User_Visitor_Writer($dbWrite);
                
                $currentDateTime = date('Y-m-d H:i:s');
                
                $userDbWriter->setLastLogin($currentDateTime);
                        
                // Optional: Rehash the password, if necessary
                if (password_needs_rehash($res['password'], PASSWORD_BCRYPT)) {
                    // Rehash the password
                    $newPwHash = password_hash($saltedUserPw, PASSWORD_BCRYPT);
                    
                    // Verify the new password-hash-value
                    if (password_verify($saltedUserPw, $newPwHash))
                    {
                        // Add the rehashed password to the proper database-row
                        $userDbWriter->setPassword($newPwHash);
                    }
                }
                
                $rows = $userDbWriter->updateData($res['id']);
                
                
                // Write the user-data to the session (the user is now authenticated)
                $this->_userSess->data = array(
                    'name' => $res['name'],
                    'id' => $res['id'],
                    'lastActiveCheck' => time(),
                    'lastLogin' => $currentDateTime,
                    'ip_addr' => $this->_currentIpAddr
                );
            }
            
        }
        
        return $errorData;
    }
    
    /**
     * Tries to login with the given admin-userdata
     * If the admin exists a check if the password needs to be rehashed will be done
     * 
     * @param type $dbWrite
     * @param type $userData
     * @return array
     */
    public function tryAdminLogin($dbWrite, $userData)
    {
        $errorData = array();
        
        if (!isset($userData['login']) || empty($userData['login']))
        {
            $errorData['missingLogin'] = 1;
        }
        
        if (!isset($userData['password']) || empty($userData['password']))
        {
            $errorData['missingPassword'] = 1;
        }
        
        if (empty($errorData))
        {
            $adminFetcher = new GamingBlog_Database_User_Admin_Fetcher($dbWrite, GamingBlog_Database_User_Visitor_Fetcher::DATA_COMPLETE);
            $adminFetcher->setFetchMode(GamingBlog_DbFetcher::FETCHMODE_ROW);
            $adminFetcher->setNameFilter($userData['login']);

            $res = $adminFetcher->getResult(); 
           
            $saltedUserPw = GamingBlog_User::getSaltedPw($userData['password']);
            
            // Check if the complete user-data has been fetched from the database, the user is active and the password is correct
            if (!isset($res['name']) || empty($res['name']) ||
                !isset($res['id']) || ($res['id'] < 0) ||
                !isset($res['password']) || empty($res['password']) ||
                !isset($res['email']) || empty($res['email']) ||
                !isset($res['active']) || ($res['active'] != 1) ||
                !password_verify($saltedUserPw, $res['password'])) {
                
                $errorData['invalidLogin'] = 1;
            } else {
                $adminDbWriter = new GamingBlog_Database_User_Admin_Writer($dbWrite);
                
                $currentDateTime = date('Y-m-d H:i:s');
                
                $adminDbWriter->setLastLogin($currentDateTime);
                
                // Optional: Rehash the password, if necessary
                if (password_needs_rehash($res['password'], PASSWORD_BCRYPT)) {
                    
                    // Rehash the password
                    $newPwHash = password_hash($saltedUserPw, PASSWORD_BCRYPT);
                    
                    // Verify the new password-hash-value
                    if (password_verify($saltedUserPw, $newPwHash))
                    {
                        // Add the rehashed password to the proper database-row
                        $adminDbWriter->setPassword($newPwHash);
                    }
                }
                        
                $adminDbWriter->updateData($res['id']);
                
                // Write the user-data to the session (the user is now authenticated)
                $this->_userSess->data = array(
                    'name' => $res['name'],
                    'id' => $res['id'],
                    'isAdmin' => 1,
                    'lastLogin' => $currentDateTime,
                    'ip_addr' => $this->_currentIpAddr
                );
            }
        }
        
        return $errorData;
    }
    
    /**
     * Adds the Gamingblog_Salt to the password 
     * 
     * @param string $pw
     * @return string
     * 
     * @author TH<>
     */
    public static function getSaltedPw($pw)
    {
        return $pw . GamingBlog_User::$_pwSalt;
    }
    
    /**
     * Tries to register the given user-data
     * Checks the following conditions:
     * - Does the username already exist => error
     * - Is the password safe (at least one numeric, one alphanumeric and one special-char)
     * 
     * @param GamingBlog_Database $gamingBlogDb
     * @param type $userData
     * 
     * @return array - The error-data if available
     * 
     * @author TH<>
     */
    public static function tryRegister($gamingBlogDb, $userData)
    {
        $errorData = array();
        
        if (!isset($userData['name']) || empty($userData['name']))
        {
            $errorData['missingName'] = 1;
        } else if ((strlen($userData['name']) < 6) || (strlen($userData['name']) > 20))
        {
            $errorData['missingNameLength'] = 1;
        }
        
        if (GamingBlog_Database::containsInvalidUserNameChars($userData['name']))
        {
            $errorData['invalidNameChars'] = 1;
        }
        
        if (!isset($userData['email']) || empty($userData['email']))
        {
            $errorData['missingMail'] = 1;
        }
        
        if (isset($userData['email']))
        {
            $validator = new Zend_Validate_EmailAddress();
            if (!$validator->isValid($userData['email']))
            {
                $errorData['invalidMail'] = 1;
            }
        }
        
        if (!isset($userData['password']) || empty($userData['password']))
        {
            $errorData['missingPassword'] = 1;
        } else if (isset($userData['password']) && (strlen($userData['password']) < 8))
        {
            $errorData['missingPasswordLength'] = 1;
        } else if (!GamingBlog_User::is_safe_pw($userData['password']))
        {
            $errorData['unsafePassword'] = 1;
        }
        
        if (empty($errorData))
        {
            $userResult = GamingBlog_User::getRegisteredUser($gamingBlogDb->read(), $userData['name'], $userData['email']);
            
            // Check if the given user is valid
            if (!empty($userResult))
            {
                foreach ($userResult as $userFromDb)
                {
                    // Username exists
                    if ($userFromDb['name'] == $userData['name'])
                    {
                        $errorData['userNameExists'] = 1;
                    }
                    // UserMail exists
                    if ($userFromDb['email'] == $userData['email'])
                    {
                        $errorData['userMailExists'] = 1;
                    }
                }
            } else {
                $pwHash = password_hash(GamingBlog_User::getSaltedPw($userData['password']), PASSWORD_BCRYPT);

                $userDbWriter = new GamingBlog_Database_User_Visitor_Writer($gamingBlogDb->write());
                $userDbWriter->setUsername(GamingBlog_Database::stripXss($userData['name'], true))
                             ->setPassword($pwHash)
                             ->setEmail(GamingBlog_Database::stripXss($userData['email']));

                $userDbWriter->writeData();
            }
        }
        
        return $errorData;
    }
    
    /**
     * Checks if the given pw-string is safe (contains at least one of each of the following elements: numerical, alphanumerical, special-char)
     * 
     * @param string $password
     * @return true, if safe, false, otherwise
     * 
     * @author TH<>
     */
    private static function is_safe_pw($password)
    {
        return (preg_match('/^.*[a-zA-Z]*.*$/', $password) &&
                preg_match('/[0-9]/', $password) &&
                preg_match('/[\!\@\$\%\&\*\-\_]/', $password));
    }
    
    /**
     * Helper-Method to check if the given username / mail exists in the user- or admin-database
     * 
     * @param Zend_Db_Adapter_Abstract $dbRead
     * @param string $userName
     * @param string $userMail
     * 
     * @author TH<>
     */
    private static function getRegisteredUser($dbRead, $userName, $userMail)
    {
        $userFetcher = new GamingBlog_Database_User_General_NameAndMail_Fetcher($dbRead, $userName, $userMail);
        $userFetcher->setFetchMode(GamingBlog_DbFetcher::FETCHMODE_ALL);
        
        $res = $userFetcher->getResult();
        
        if (!empty($res))
        {
            return $res;
        } else {
            return array();
        }
    }
    
    /**
     * The user-login-action - Checks if the necessary data is available and prepares the sessiondata
     * 
     * @param type $userData
     * @return boolean
     */
    public function login($userData)
    {
        if (isset($userData['id']) && !empty($userData['id']) &&
            isset($userData['name']) && !empty($userData['name']))
        {
            $this->_userSess->data = $userData;
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Tries to authenticate the user, by checking the user-data in the session
     * 
     * @return boolean, returns true, if authenticated, false otherwise
     * 
     * @author TH<>
     */
    public function authenticate()
    {
        if (isset($this->_userSess->data) && !empty($this->_userSess->data) &&
            isset($this->_userSess->data['id']) && isset($this->_userSess->data['name']) &&
            $this->currentIpMatches())
        {
            $id = $this->_userSess->data['id'];
            $name = $this->_userSess->data['name'];
            
            if (is_numeric($id) && ($id >= 0) &&
                !empty($name))
            {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Sets the current ip-addr of the user-obj
     * 
     * @param type $ipAddr
     */
    public function setCurrentIpAddr($ipAddr)
    {
        $this->_currentIpAddr = $ipAddr;
    }
    
    /**
     * Checks if the current ip matches the ip stored in the user-session
     * 
     * @return boolean
     */
    public function currentIpMatches()
    {        
        if (isset($this->_userSess->data) &&
            isset($this->_userSess->data['ip_addr']) &&
            ($this->_userSess->data['ip_addr'] == $this->_currentIpAddr))
        {
            return true;
        } else
        {
            return false;
        }
    }
    
    /**
     * Returns the information, if the user-active-state has to be checked again
     * 
     * @return boolean
     * 
     * @author TH<>
     */
    public function isActiveCheckRequired()
    {
        if (!isset($this->_userSess->data['lastActiveCheck']) ||
            ((time() - $this->_userSess->data['lastActiveCheck']) > 60))
        {
            return true;
        }
        
        return false;
    }
    
    /**
     * Tries to authenticate the user as admin, by checking the user-data in the session
     * 
     * @return boolean, returns true, if authenticated as admin, false otherwise
     * 
     * @author TH<>
     */
    public function authenticateAdmin()
    {
        return $this->authenticate() && isset($this->_userSess->data['admin']) && ($this->_userSess->data['admin'] == 1);
    }
    
    /**
     * Logs the user out, by clearing the saved session-data
     * 
     * @author TH<>
     */
    public function logout()
    {
        $this->_userSess->unsetAll();
    }
    
    /**
     * Returns the user-specific id, if available, "-1" otherwise
     * 
     * @author TH<>
     */
    public function getId()
    {
        if (isset($this->_userSess->data['id']))
        {
            return $this->_userSess->data['id'];
        }
        
        return -1;
    }
    
    /**
     * Returns the user-specific name, if available, "" otherwise
     * 
     * @author TH<>
     */
    public function getUsername()
    {
        if (isset($this->_userSess->data['name']))
        {
            return $this->_userSess->data['name'];
        }
        
        return "";
    }
    
    /**
     * Checks, if the user is an admin
     * 
     * @author PB 
     */
    public function  isAdmin(){
        return isset($this->_userSess->data['isAdmin']);
    }
    
    public function getLoginTime()
    {
        if (isset($this->_userSess->data['lastLogin']))
        {
            return $this->_userSess->data['lastLogin'];
        }
        
        return "";
    }

    /**
     * A helper-method to create an admin-password
     * @param type $userPw
     * @return type
     */
    public static function createAdminPw($userPw) {
        return password_hash(GamingBlog_User::getSaltedPw($userPw), PASSWORD_BCRYPT);
    }

}

