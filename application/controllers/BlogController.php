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
        $page = $this->_getParam("page",0);
        
        $blog_entry_fetcher = new GamingBlog_Database_Blog_Entry_Fetcher($this->_db->read());
        
        $res = $blog_entry_fetcher->getResult();
        
        $this->_view->news_entries= $res;
        
        $blog_category_fetcher = new GamingBlog_Database_Blog_Category_Fetcher($this->_db->read());
        $res = $blog_category_fetcher->getResult();
        $this->_view->category = $res;
        
        $this->_view->render("blog/overview.tpl");
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
        $entryDbWriter->setText($text);
        $entryDbWriter->setTitle($title);
        $blogId = $this->getParam('blogId');
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

