<?php

/**
 * The Company-Controller contains actions to show content about the developer-company and offer contact-possibilities
 * 
 * @author TH<>
 */
class CompanyController extends GamingBlog_Controller_Action
{
    protected $_defaultAction = 'about';
    
    /**
     * Shows general information about the company
     * 
     * @author TH<>
     */
    public function aboutAction()
    {
        // TODO
        
        $this->_view->render('company/about.tpl');
    }
    
    /**
     * Shows the imprint-page with relevant business-content about the company
     * 
     * @author TH<>
     */
    public function imprintAction()
    {
        // TODO
        
        $this->_view->render('company/contact.tpl');
    }
    
    /**
     * Shows the contact-page
     * 
     * @author TH<>
     */
    public function contactAction()
    {
        // TODO
        
        $this->_view->render('company/contact.tpl');
    }
}

