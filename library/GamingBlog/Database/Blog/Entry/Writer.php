<?php

/**
 * A class to fetch blog-entry-data from the database
 * 
 * @author PB<>
 * 
 */

class GamingBlog_Database_Blog_Entry_Writer extends GamingBlog_Database_Writer
{
    /**
     * 
     * @param Zend_Db_Adapter_Abstract $pDb
     */
    private function _getDataFields(){
        return array( 'title'=>$title,
                  'text'=>$text,
                  'adminId'=>$adminId);
    
    }
    
}