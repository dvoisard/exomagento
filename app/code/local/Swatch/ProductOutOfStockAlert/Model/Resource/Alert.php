<?php
/**
* Alert resource model
*
* @author David Voisard
*/
class Swatch_ProductOufOfStockAlert_Model_Resource_Alert extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
    * Initialize connection and define main table and primary key
    */
    protected function _construct()
    {
        $this->_init('swatch_productoutofstockalert/log', 'log_id');
    }
}

