<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * @var Zend_Config
     */
    protected $_config;
    
    /**
     * Bootstrap-method for initializing the configuration
     * 
     * @author TH<>
     */
    public function _initConfig()
    {
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        Zend_Registry::set('config', $this->_config);
    }
    
    /**
     * Bootstrap-method for initializing the view
     * 
     * @author TH<>
     */
    public function _initView()
    {
        //Debug::out($this->getOption('smarty'));
        // initialize smarty view
        $view = new GamingBlog_View_Smarty($this->getOption('smarty'));
        Zend_Registry::set("view", $view);

        return $view;
    }
    
    /**
     * Bootstrap-method for initializing the database
     * 
     * @author TH<>
     */
    public function _initDb()
    {
        $gamingBlogDb = new GamingBlog_Database($this->_config->get('db'));
        
        Zend_Registry::set('db', $gamingBlogDb);
    }
    
    /**
     * Bootstrap-method for initializing the user
     * 
     * @author TH<>
     */
    public function _initUser()
    {
        $user = new GamingBlog_User(Zend_Registry::get('db')->read());
        
        Zend_Registry::set('user', $user);
    }

}

