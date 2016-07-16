<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * @var Zend_Config
     */
    protected $_config;

    public function _initAutoload()
    {
        //$autoloader = Zend_Loader_Autoloader::getInstance();
    }
    
    public function _initConfig()
    {
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        Zend_Registry::set('config', $this->_config);
    }
    
    public function _initView()
    {
        //Debug::out($this->getOption('smarty'));
        // initialize smarty view
        $view = new GamingBlog_View_Smarty($this->getOption('smarty'));
        Zend_Registry::set("view", $view);
        
        // Note: Rendering by the default-view is disabled by the config
        
        // setup viewRenderer with suffix and view
        /*$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setViewSuffix('tpl');
        $viewRenderer->setView($view);*/

        // ensure we have layout bootstraped
        //$this->bootstrap('layout');
        // set the tpl suffix to layout also
        //$layout = Zend_Layout::getMvcInstance();
        //$layout->setViewSuffix('tpl');

        return $view;
    }
    
    public function _initDb()
    {
        $gamingBlogDb = new GamingBlog_Database($this->_config->get('db'));
        
        Zend_Registry::set('db', $gamingBlogDb);
    }
    
    
    public function _initUser()
    {
        $user = new GamingBlog_User(Zend_Registry::get('db')->read());
        
        Zend_Registry::set('user', $user);
    }

}

