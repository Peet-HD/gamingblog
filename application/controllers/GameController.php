<?php

/**
 * The Game-Controller contains actions to show content about the developed game
 * 
 * @author TH<>
 */
class GameController extends GamingBlog_Controller_Action
{
    protected $_defaultAction = 'about';
    
    /**
     * The about-action shows general information about the developed game
     * 
     * @author TH<>
     */
    public function aboutAction()
    {
        $contentFetcher = new GamingBlog_Database_PageContent_Fetcher($this->_db->read());
        $contentFetcher->setFetchMode(GamingBlog_DbFetcher::FETCHMODE_ROW);
        $contentFetcher->setIdFilter($this->_config->get('content')->get('game'));
        $res = $contentFetcher->getResult();
        
        $this->_view->pageContent = isset($res['htmlContent']) ? $res['htmlContent'] : '';
        
        $this->_view->navName = 'game';
        
        $this->_view->render('general/dynamicContentPage.tpl');
    }
    
    /**
     * The game-company-about-action shows general information about the developed game
     * 
     * @author TH<>
     */
    public function companyAction()
    {
        $contentFetcher = new GamingBlog_Database_PageContent_Fetcher($this->_db->read());
        $contentFetcher->setFetchMode(GamingBlog_DbFetcher::FETCHMODE_ROW);
        $contentFetcher->setIdFilter($this->_config->get('content')->get('company'));
        $res = $contentFetcher->getResult();
        
        $this->_view->pageContent = isset($res['htmlContent']) ? $res['htmlContent'] : '';
        
        $this->_view->navName = 'company';
        
        $this->_view->render('general/dynamicContentPage.tpl');
    }
}

