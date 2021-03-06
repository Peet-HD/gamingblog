<?php

/**
 * A basic controller-class to provide the necessary objects (database, view, etc.) and
 * offer a default-action-routine for the index-call (without any action)
 * 
 * @author TH<>
 */
abstract class GamingBlog_Controller_Action extends Zend_Controller_Action
{
    /**
     * @var GamingBlog_View_Smarty
     */
    protected $_view;
    
    /**
     * @var Gamingblog_Database
     */
    protected $_db;
    
    /**
     * Defines the default-action for the controller (should be overriden if the index-action does not exist)
     * 
     * @var string
     */
    protected $_defaultAction = '';
    
    /**
     * The user-object
     * 
     * @var GamingBlog_User
     */
    protected $_user;
    
    /**
     * The page-configuration
     * 
     * @var Zend_Config
     */
    protected $_config;
    
    /**
     * Initialize-Method - Prepares the general necessary variables to be accessible in every controller
     * 
     * @author TH<>
     */
    public function init() {
        parent::init();
        
        // Prepare the config-object
        $this->_config = Zend_Registry::get('config');
        
        // Prepare the view-object
        $this->_view = Zend_Registry::get('view');
        
        // Prepare the db-object
        $this->_db = Zend_Registry::get('db');
        
        // Prepare the user-object
        $this->_user = Zend_Registry::get('user');
        $this->_view->user = $this->_user;
        
        $this->_view->prepareCacheId($this->getRequest()->getControllerName(), $this->getRequest()->getActionName(), $this->getRequest()->getParams());
        
        $this->_view->urlHelper = $this->_helper->getHelper('Url');
        
        $request = $this->getRequest();
        $remoteAddr = $request->getServer('REMOTE_ADDR');
        
        $this->_user->setCurrentIpAddr($remoteAddr);
    }
    
    /**
     * Default-Action -> reroute's to the the pre-set-default-action
     * 
     * @author TH<>
     */
    public function indexAction()
    {
        if ((!empty($this->_defaultAction) && method_exists($this, $this->_defaultAction . 'Action')) ||
            (!empty($this->_defaultController)))
        {
                
            if (!empty($this->_defaultController))
            {
                $this->redirect('/' . $this->_defaultController . '/' . $this->_defaultAction);
            } else {
                $this->redirect('/' . Zend_Controller_Front::getInstance()->getRequest()->getControllerName() . '/' . $this->_defaultAction);
            }
        } else
        {
            $this->redirect ('/error/404');
        }
    }
}
