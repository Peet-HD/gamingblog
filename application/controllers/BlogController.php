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

    public function writenewentryAction()
    {
        // Redirect users without proper access
        if (!$this->_user->authenticate() || !$this->_user->isAdmin())
        {
            $this->redirect('/blog/overview');
        }
        
        $text = $this->_getParam('text', "");
        $title = $this->_getParam('title', "");
        $categoryId = $this->_getParam('categoryId', -1);
        $page = $this->getParam('page');
        
        if ($categoryId == -1)
        {
            $this->redirect('/blog/overview');
        }
        
        $entryDbWriter = new GamingBlog_Database_Blog_Entry_Writer($this->_db->write());
        $entryDbWriter->setAdminId($this->_user->getId());
        $entryDbWriter->setCategory($categoryId);
        $entryDbWriter->setText(GamingBlog_Database::stripXss($text));
        $entryDbWriter->setTitle(GamingBlog_Database::stripXss($title));
        $blogId = $this->getParam('blogId', -1);
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
        $this->redirect('blog/overview?page='.$page);
    }
    
    public function writecommentAction()
    {
        // Redirect users without proper access
        if (!$this->_user->authenticate())
        {
            $this->redirect('/blog/overview');
        }
        
        $strippedText = GamingBlog_Database::stripXss($this->getParam('comment', ''), true);
        $blogId = $this->getParam('blogId', -1);
        
        if (($blogId != -1) && (strlen($strippedText) > 0))
        {
            $commentDbWriter = new GamingBlog_Database_Blog_Commentary_Writer($this->_db->write());
            $commentDbWriter->setText($strippedText);
            $commentDbWriter->setUserId($this->_user->getId());
            $commentDbWriter->setBlogId($blogId);
            $commentDbWriter->writeData();
        }

       $this->redirect('blog/entrydetail?blogid='.$blogId);
    }

}

