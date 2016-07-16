<?php

/**
 * Abstract Database-Writer-Class, offers general methods and forces the implementation of specific writer-methods
 * 
 * @author TH<>
 */
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
     * 
     * @author TH<>
     */
    public function writeData()
    {
        $row = $this->_dbTable->createRow(
                    $this->_getRowData()
                );

        return $row->save();
    }
    
    /**
     * Updates the row with the given key and the prepared data in the database, 
     * 
     * @param type $primaryKeyVal
     * 
     * @return int
     * 
     * @author TH<>
     */
    public function updateData($primaryKeyVal)
    {
        return $this->_dbTable->update(
                $this->_getRowData(),
                $this->_dbTable->getAdapter()->quoteInto($this->_getPkField() . " = ?", $primaryKeyVal)
        );
    }
    
    /**
     * Deletes the row with the given key-value
     * 
     * @param type $primaryKeyVal
     * 
     * @return int
     * 
     * @author TH<>
     */
    public function deleteData($primaryKeyVal)
    {
        return $this->_dbTable->delete(
                $this->_dbTable->getAdapter()->quoteInto($this->_getPkField() . " = ?", $primaryKeyVal)
        );
    }
    
    /**
     * Should prepare an associative-data-array and return it
     * 
     * @return array
     */
    protected abstract function _getRowData();
    
    /**
     * Should prepare the primary-key as string and return it
     * 
     * @return string
     */
    protected abstract function _getPkField();
    
}