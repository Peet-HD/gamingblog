<?php

abstract class GamingBlog_Database_Writer
{
    /**
     * @var Zend_Db_Table
     */
    protected $_dbTable;
    
    public function __construct($db, $dbName) {
        $this->_dbTable = new Zend_Db_Table(
                                array(
                                    'db' => $db,
                                    'name' => $dbName
                                ));
    }
    
    /**
     * Writes the prepared data to the database
     * 
     * @return mixed An array with each primary-key-value, or a single primary-key.
     */
    public function writeData()
    {
        $row = $this->_dbTable->createRow(
                    $this->_getRowData()
                );

        return $row->save();
    }
    
    public function updateData($primaryKeyVal)
    {
        return $this->_dbTable->update(
                $this->_getRowData(),
                $this->_dbTable->getAdapter()->quoteInto($this->_getPkField() . " = ?", $primaryKeyVal)
        );
    }
    
    protected abstract function _getRowData();
    protected abstract function _getPkField();
    
}