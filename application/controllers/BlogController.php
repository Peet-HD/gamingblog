<?php

class BlogController extends GamingBlog_Controller_Action
{
    protected $_defaultAction = 'overview';
    
    /* Main-Action with the overview of the news-entries */
    public function overviewAction()
    {
        
        $page=$this->_getParam("page",0);
        
        $blog_entry_fetcher = new GamingBlog_Database_Blog_Entry_Fetcher($this->_db->read());
        
        $res = $blog_entry_fetcher->getResult();

        
        $this->_view->news_entries= $res;
        // action body
        
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

