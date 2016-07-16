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
     * Shows the privacy-page
     * 
     * @author TH<>
     */
    public function privacyAction()
    {
        $contentFetcher = new GamingBlog_Database_PageContent_Fetcher($this->_db->read());
        $contentFetcher->setFetchMode(GamingBlog_DbFetcher::FETCHMODE_ROW);
        $contentFetcher->setIdFilter($this->_config->get('content')->get('privacy'));
        $res = $contentFetcher->getResult();
        
        $this->_view->pageContent = isset($res['htmlContent']) ? $res['htmlContent'] : '';
        
        $this->_view->navName = 'privacy';
        
        $this->_view->render('general/dynamicContentPage.tpl');
    }
    
    /**
     * Shows general information about the company
     * 
     * @author TH<>
     */
    public function aboutAction()
    {
        $contentFetcher = new GamingBlog_Database_PageContent_Fetcher($this->_db->read());
        $contentFetcher->setFetchMode(GamingBlog_DbFetcher::FETCHMODE_ROW);
        $contentFetcher->setIdFilter($this->_config->get('content')->get('about'));
        $res = $contentFetcher->getResult();
        
        $this->_view->navName = 'imprint';
        
        $this->_view->pageContent = isset($res['htmlContent']) ? $res['htmlContent'] : '';
        
        $this->_view->render('general/dynamicContentPage.tpl');
    }
}

