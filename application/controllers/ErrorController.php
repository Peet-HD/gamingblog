<?php

class ErrorController extends GamingBlog_Controller_Action
{    
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

        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->_view->exception = $errors->exception;

            $this->_view->request   = $errors->request;

            $this->_view->render('error/default.tpl');
        } else if ($applicationError) {

            // Remove existing user-login-data on application-error
            $this->_user->logout();
            
            $this->_view->render('error/errPage.tpl');
        }
        
        // If the Route/Controller/Action were wrong, show the 404-page
        $this->_view->render('error/404.tpl');   
    }
}