<?php

/**
 * A Controller, which handles the blog-entry-specific actions
 * 
 * @author TH<>
 */
class BlogController extends GamingBlog_Controller_Action
{
    protected $_defaultAction = 'overview';
    
    /* 
     * Main-Action with the overview of the news-entries
     * 
     * @author TH<>
     */
    public function overviewAction()
    {
        $page = max(array(0, $this->getParam('page', 0)));
        $blog_entry_fetcher = new GamingBlog_Database_Blog_Entry_Fetcher($this->_db->read());
        
        $res = $blog_entry_fetcher->getResult();
        
        $this->_view->news_entries= $res;
        
        $blog_category_fetcher = new GamingBlog_Database_Blog_Category_Fetcher($this->_db->read());
        $res = $blog_category_fetcher->getResult();
        $this->_view->category = $res;
        
        //$this->_view->render("blog/overview.tpl");
        
                $pageFetcher = new GamingBlog_Database_Blog_Entry_Fetcher($this->_db->read());
        
        $entryCount = $blog_entry_fetcher->getCount();
        
        $elementsPerPage = 10;
        
        $maxPage = ceil(floatval($entryCount) / $elementsPerPage) - 1;
        
        // limit the page-value to a proper range
        $page = min(array($page, $maxPage));
        
        $pageFetcher->setLimit($page, $elementsPerPage);
        $this->_view->news_entries = $pageFetcher->getResult();
        
        $this->_view->page = $page;
        $this->_view->elementsPerPage = $elementsPerPage;
        $this->_view->maxPage = $maxPage;
        $this->_view->render('blog/overview.tpl');
    }
    
    /* Shows the Detail-Page for a specific entry */
    public function entrydetailAction()
    {
        $entryId = $this->getParam('blogid', -1);
        
        $blog_entry_fetcher = new GamingBlog_Database_Blog_Entry_Fetcher($this->_db->read());
        $blog_entry_fetcher->setFetchMode(GamingBlog_DbFetcher::FETCHMODE_ROW);
        $blog_entry_fetcher->setEntryId($entryId);
                
        $res = $blog_entry_fetcher->getResult();
        
        $this->_view->entryDetails=$res;

        $comment_fetcher = new GamingBlog_Database_Blog_Commentary_Fetcher($this->_db->read());
        $comment_fetcher->setBlogEntryId($entryId);
        $comm = $comment_fetcher->getResult();
        $this->_view->comment=$comm;
        $this->_view->render('blog/entryDetail.tpl');
    }

    public function writenewentryAction(){
        
        $text = $this->_getParam('text');
        $title = $this->_getParam('title');
        $categoryId = $this->_getParam('categoryId');
        $entryDbWriter = new GamingBlog_Database_Blog_Entry_Writer($this->_db->write());
        $entryDbWriter->setAdminId($this->_user->getId());
        $entryDbWriter->setCategory($categoryId);
                $b= html_entity_decode($text);
                $text=preg_replace('/(\<(\s)*s(\s)*c(\s)*r(\s)*i(\s)*p(\s)*t(\s)*\>)||(\<\/(\s)*s(\s)*c(\s)*r(\s)*i(\s)*p(\s)*t\>)/','', $b);
        $entryDbWriter->setText($text);
                        $b= html_entity_decode($title);
                $title=preg_replace('/(\<(\s)*s(\s)*c(\s)*r(\s)*i(\s)*p(\s)*t(\s)*\>)||(\<\/(\s)*s(\s)*c(\s)*r(\s)*i(\s)*p(\s)*t\>)/','', $b);
        $entryDbWriter->setTitle($title);
        $blogId = $this->getParam('blogId');
        $a=  htmlentities($text, ENT_QUOTES);

        
        $delete = $this->getParam('delete');
        if($blogId > 0){
            $entryDbWriter->updateData($blogId);
        }
        else{
        $entryDbWriter->writeData();
        }
        if($delete==1){
            $entryDbWriter->deleteData($blogId);
        }
        $this->redirect('blog/overview');
    }
    
    public function writecommentAction(){
        
        $text = $this->getParam('comment');
        $blogId = $this->getParam('blogId');

        $commentDbWriter = new GamingBlog_Database_Blog_Commentary_Writer($this->_db->write());
        $commentDbWriter->setText($text);
        $commentDbWriter->setUserId($this->_user->getId());
        $commentDbWriter->setBlogId($blogId);
        $commentDbWriter->writeData();

       $this->redirect('blog/entrydetail?blogid='.$blogId);
    }

}

