<?php

/**
 * A Controller, which handles the blog-entry-specific actions
 * 
 * @author TH<>
 */
class BlogController extends GamingBlog_Controller_Action
{
    protected $_defaultAction = 'overview';
    
    /* Main-Action with the overview of the news-entries */
    public function overviewAction()
    {
        $page = $this->_getParam("page",0);
        
        $blog_entry_fetcher = new GamingBlog_Database_Blog_Entry_Fetcher($this->_db->read());
        
        $res = $blog_entry_fetcher->getResult();

        $this->_view->news_entries= $res;
        
    //    $this->_view->category='hallo';
        
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
    
    public function writenewentryAction(){
        
        $text = $this->_getParam('text');
        $title = $this->_getParam('title');
        $categoryId = $this->_getParam('categoryId');
        

        
        $entryDbWriter = new GamingBlog_Database_Blog_Entry_Writer($this->_db->write());
        $entryDbWriter->setAdminId($this->_user->getId());
        $entryDbWriter->setCategory($categoryId);
        $entryDbWriter->setText($text);
        $entryDbWriter->setTitle($title);
        
        $entryDbWriter->writeData();
        
        $this->redirect('blog/overview');
    }
}

