<?php

class ErrorController extends Zend_Controller_Action
{

    /*public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request   = $errors->request;
    }*/
    
    public function errorAction()
    {

        $view = Zend_Registry::get('view');
        $this->_view = $view;

        $errors = $this->_getParam('error_handler');

        if (!$errors || !$errors instanceof ArrayObject) {
            $this->_view->message = 'You have reached the error page';
            return;
        }

        $applicationError = false;

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->_view->message = 'Page not found';
                break;
            default:
                // setup application error flag
                $applicationError = true;
                
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->_view->message = 'Application error';
                break;
        }

        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->_view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }

        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->_view->exception = $errors->exception;

            $this->_view->request   = $errors->request;

            $this->_view->render('error/default.tpl');
        } else if ($applicationError) {

            // Remove existing user- and cart-data on application-error
            $user = new User();
            $user->logout();
            $cart = new Cart();
            $cart->removeAllItems();

            // remove possible Login-Parameter-Values, for correct handling in the Login
            $this->_request->setParam('loginName', '');
            $this->_request->setParam('passPhrase', '');

            // Redirect to the Login-Page with a proper Application-Problem-Message
            $this->_forward('login', 'index', NULL, array('mNum' => Message::APPLICATION_PROBLEM));
        } else {
            // If the Route/Controller/Action were wrong, redirect to the index with proper Wrong-Route-Message
            $this->_forward('index', 'index', NULL, array('mNum' => Message::APPLICATION_WRONG_ROUTE));
        }
    }
    

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

