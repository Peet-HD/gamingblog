<?php

class BlogController extends GamingBlog_Controller_Action
{
    protected $_defaultAction = 'overview';
    
    /* Main-Action with the overview of the news-entries */
    public function overviewAction()
    {
        $this->_view->news_entries = array(array('title' => "blub", 'content' => 'whuzzza'));
        
        // action body
        $this->_view->hello = 'Hello Smarty 3';
        
        $this->_view->render("blog/overview.tpl");
    }
    
    /* Shows the Detail-Page for a specific entry */
    public function entrydetailAction()
    {
        $entryID = $this->getParam('eId');
        
        $this->_view->render('blog/entryDetail.tpl');
    }

    public function fourzerofourAction()
    {
        $this->_view->render('error/404.tpl');   
    }
}

