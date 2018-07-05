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
    const XML_PATH_ENABLED            = 'catalog/productoutofstockalert/enabled';

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
     * @return Swatch_ProductOutOfStockAlert_Helper_Data
     */
    public function setProduct($product)
    {
        $this->_product = $product;
        return $this;
    }
}
