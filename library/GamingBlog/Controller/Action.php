<?php

abstract class GamingBlog_Controller_Action extends Zend_Controller_Action
{
    /**
     * @var GamingBlog_View_Smarty
     */
    protected $_view;
    
    /**
     * @var Zend_Db_Adapter_Pdo_Mysql
     */
    protected $_db;
    
    /**
     * Defines the default-action for the controller (should be overriden if the index-action does not exist)
     * 
     * @var string
     */
    protected $_defaultAction = '';
    
    
    public function init() {
        parent::init();
        
        // Prepare the view-object
        $this->_view = Zend_Registry::get('view');
        
        // Prepare the db-object
        $this->_db = Zend_Registry::get('db');
        
    }
    
    /**
     * Default-Action -> reroute's to the the pre-set-default-action
     * 
     * @author TH<>
     */
    public function indexAction()
    {
        if (!empty($this->_defaultAction) && method_exists($this, $this->_defaultAction . 'Action'))
            $this->redirect('/' . Zend_Controller_Front::getInstance()->getRequest()->getControllerName() . '/' . $this->_defaultAction);
        else
            $this->redirect ('/error/404');
    }
}
