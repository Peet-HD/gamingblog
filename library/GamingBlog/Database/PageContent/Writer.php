<?php

/* 
 * The Page-Content-Writer to offer a direct access to the table for inserting / updating lines
 * 
 * @author TH<>
 */
class GamingBlog_Database_PageContent_Writer extends GamingBlog_Database_Writer
{
    /**
     * The content-id, can be set to update a specific row
     * 
     * @var int
     */
    private $_contentId = -1;
    
    /**
     * The html-content of the page
     * 
     * @var string
     */
    private $_pageHtml = '';
    
    
    public function __construct($db) {
        parent::__construct($db, 'general_page_content');
    }
    
    public function setContentId($contentId)
    {
        $this->_contentId = intval($contentId);
        
        return $this;
    }
    
    public function setHtmlContent($htmlContent)
    {
        $this->_pageHtml = $htmlContent;
        
        return $this;
    }

    protected function _getRowData() {
        
        $rowData = array();
        
        if (is_numeric($this->_contentId) && $this->_contentId >= 0)
        {
            $rowData['contentId'] = $this->_contentId;
        }
        
        if (!empty($this->_pageHtml))
        {
            $rowData['pageHtml'] = $this->_pageHtml;
        }
        
        return $rowData;
    }

    protected function _getPkField() {
        return 'contentId';
    }
}