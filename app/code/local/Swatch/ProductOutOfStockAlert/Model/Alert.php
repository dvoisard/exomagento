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
        $this->_init('swatch_productoutofstockalert/alert');
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
    
    public function getCollection()
    {
        return Mage::getResourceModel('swatch_productoutofstockalert/alert_collection');
    }
    
    /**
     * @todo send email to customer when the product is available
     * Send customer email
     *
     * @return bool
     */
    public function send()
    {
        return true;
    }

    public function isEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
}

