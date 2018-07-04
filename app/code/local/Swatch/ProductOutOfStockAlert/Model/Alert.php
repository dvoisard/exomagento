<?php
/**
* Alert model
*
* @author David Voisard
*/
class Swatch_ProductOutOfStockAlert_Model_Alert extends Mage_Core_Model_Abstract
{
    /**
    * Define resource model
    */
    protected function _construct()
    {
        $this->_init('swatch_productoutofstockalert/log');
    }
    /**
    * @return Swatch_ProductOutOfStockAlert_Model_Alert
    */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        if ($this->isObjectNew()) {
            $this->setData('entered_at', Varien_Date::now());
        }
        return $this;
    }
}

