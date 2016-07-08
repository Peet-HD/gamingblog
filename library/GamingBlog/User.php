<?php

/**
 * Gaming-Blog-User class, stores the user-specific data in a session-namespace
 * 
 * @author TH<>
 */
class GamingBlog_User
{
    protected $_userSess;
    
    /**
     * @todo TODO TODO Check expiration timer, looks like it's not working currently
     */
    const expirationTime = 90;    
    
    public function __construct() {
        $this->_userSess = new Zend_Session_Namespace('gamingblog_user');
        $this->_userSess->setExpirationSeconds($this::expirationTime);
    }
    
    /**
     * Tries to login with the given userdata
     * If the user-exists a check if the password needs to be rehashed will be done
     * 
     * @param type $dbWrite
     * @param type $userData
     * @return array
     */
    public function tryLogin($dbWrite, $userData)
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
            $userFetcher = new GamingBlog_Database_User_Fetcher($dbWrite, GamingBlog_Database_User_Fetcher::DATA_COMPLETE);
            $userFetcher->setFetchMode(GamingBlog_DbFetcher::FETCHMODE_ROW);
            
            if (strpos($userData['login'], '@') == false)
            {
                $userFetcher->setNameFilter($userData['login']);
            } else {
                $userFetcher->setMailFilter($userData['login']);
            }

            $res = $userFetcher->getResult();
            
            // Check if the complete user-data has been fetched from the database, the user is active and the password is correct
            if (!isset($res['name']) || empty($res['name']) ||
                !isset($res['id']) || ($res['id'] < 0) ||
                !isset($res['password']) || empty($res['password']) ||
                !isset($res['email']) || empty($res['email']) ||
                /**
                 * @todo TODO TODO TODO unbedingt das active-flag wieder auf 1 schalten,
                 * damit korrekt geprüft wird, welcher account aktiv geschaltet wurde
                 */
                !isset($res['active']) || ($res['active'] != 0) ||
                !password_verify($userData['password'], $res['password'])) {
                
                $errorData['invalidLogin'] = 1;
            } else {
                // Optional: Rehash the password, if necessary
                if (!password_needs_rehash($res['password'], PASSWORD_BCRYPT)) {
                    // Rehash the password
                    $newPwHash = password_hash($userData['password'], PASSWORD_BCRYPT);
                    
                    // Verify the new password-hash-value
                    if (password_verify($userData['password'], $newPwHash))
                    {
                        // Add the rehashed password to the proper database-row
                        $userDbWriter = new GamingBlog_Database_User_Writer($dbWrite);
                        $userDbWriter->setUserId($res['id'])
                                     ->setPassword($newPwHash);
                        
                        $userDbWriter->updateData($res['id']);
                    }
                }
                
                // Write the user-data to the session (the user is now authenticated)
                $this->_userSess->data = array(
                    'name' => $res['name'],
                    'id' => $res['id'],
                );
            }
            
        }
        
        return $errorData;
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
     */
    public static function tryRegister($gamingBlogDb, $userData)
    {
        $errorData = array();
        
        if (!isset($userData['name']) || empty($userData['name']))
        {
            $errorData['missingName'] = 1;
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
        } else if (isset($userData['password']) && strlen($userData['password']) < 8)
        {
            $errorData['missingPasswordLength'] = 1;
        } else if (!GamingBlog_User::is_safe_pw($userData['password']))
        {
            $errorData['unsafePassword'] = 1;
        }
        
        if (empty($errorData))
        {
            // Check if the given user is valid
            if (GamingBlog_User::checkUserExists($gamingBlogDb->read(), $userData['name']))
            {
                // User exists
                $errorData['userExists'] = 1;
            } else {
                $pwHash = password_hash($userData['password'], PASSWORD_BCRYPT);

                $userDbWriter = new GamingBlog_Database_User_Writer($gamingBlogDb->write());
                $userDbWriter->setUsername($userData['name'])
                             ->setPassword($pwHash)
                             ->setEmail($userData['email']);

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
     */
    private static function is_safe_pw($password)
    {
        return (preg_match('/^.*[a-zA-Z]*.*$/', $password) &&
                preg_match('/[0-9]/', $password) &&
                preg_match('/[\!\@\$\%\&\*\-\_]/', $password));
    }
    
    /**
     * Helper-Method to check if the given username exists in the user-database
     * 
     * @param Zend_Db_Adapter_Abstract $dbRead
     * @param string $userName
     * @param string $userPwHash
     */
    private static function checkUserExists($dbRead, $userName)
    {
        $userFetcher = new GamingBlog_Database_User_Fetcher($dbRead);
        $userFetcher->setNameFilter($userName);
        
        $res = $userFetcher->getResult();
        
        if (!empty($res))
        {
            return true;
        } else {
            return false;
        }
    }
    
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
            isset($this->_userSess->data['id']) && isset($this->_userSess->data['name']))
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
     * Tries to authenticate the user as admin, by checking the user-data in the session
     * 
     * @return boolean, returns true, if authenticated as admin, false otherwise
     * 
     * @author TH<>
     */
    public function authenticateAdmin()
    {
        return authenticate() && isset($this->_userSess->data['admin']) && ($this->_userSess->data['admin'] == 1);
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
}

