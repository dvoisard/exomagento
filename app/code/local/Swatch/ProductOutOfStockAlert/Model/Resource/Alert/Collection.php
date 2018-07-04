<?php
/**
* Alert collection
*
* @author David Voisard
*/
class Swatch_ProductOutOfStockAlert_Model_Resource_Alert_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
    * Define collection model
    */
    protected function _construct()
    {
        $this->_init('swatch_productoutofstockalert/log');
    }
    /**
    * Prepare for displaying in list
    *
    * @param integer $page
    * @return Swatch_ProductOutOfStockAlert_Model_Resource_Alert_Collection
    */
    public function prepareForList($page)
    {
        $this->setPageSize(Mage::helper('swatch_productoutofstockalert')
                ->getNewsPerPage());
        $this->setCurPage($page)->setOrder('entered_at', Varien_Data_Collection::SORT_ORDER_DESC);
        return $this;
    }
    
    /**
     *
     * @param int $productId
     * @return Swatch_ProductOutOfStockAlert_Model_Resource_Alert_Collection
     */
    public function join($productId)
    {
        $this->getSelect()->join(
            array('alert' => $this->getTable('swatch_productoutofstockalert')),
            'alert.product_id=e.entity_id',
            array('log_id', 'email', 'entrered_at')
        );
        $this->addAttributeToSelect('*');

        return $this;
    }
}