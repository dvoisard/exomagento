<?php
/**
* Alert Data helper
*
* @author David Voisard
*/
class Swatch_ProductOutOfStockAlert_Helper_Data extends Mage_Core_Helper_Data
{
    /**
    * Path to store config if frontend output is enabled
    *
    * @var string
    */
    const XML_PATH_ENABLED            = 'productoutofstockalert/view/enabled';
    /**
    * Path to store config where count of news posts per page is stored
    *
    * @var string
    */
    const XML_PATH_ITEMS_PER_PAGE     = 'productoutofstockalert/view/items_per_page';
    /**
     * Current product instance (override registry one)
     *
     * @var null|Mage_Catalog_Model_Product
     */
    protected $_product = null;

    /**
    * @param integer|string|Mage_Core_Model_Store $store
    * @return boolean
    */
    public function isEnabled($store = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }
    /**
     * Get current product instance
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        if (!is_null($this->_product)) {
            return $this->_product;
        }
        return Mage::registry('product');
    }

    /**
     * Set current product instance
     *
     * @param Mage_Catalog_Model_Product $product
     * @return Mage_ProductAlert_Helper_Data
     */
    public function setProduct($product)
    {
        $this->_product = $product;
        return $this;
    }
    /**
    * Return the number of items per page
    *
    * @param integer|string|Mage_Core_Model_Store $store
    * @return int
    */
    public function getNewsPerPage($store = null)
    {
        return abs((int)Mage::getStoreConfig(self::XML_PATH_ITEMS_PER_PAGE, $store));
    }
    
    public function getStore()
    {
        return Mage::app()->getStore();
    }
}
