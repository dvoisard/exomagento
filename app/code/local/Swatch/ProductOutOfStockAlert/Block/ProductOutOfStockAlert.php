<?php
/**
 * ProductOutOfStockAlert block
 *
 * @category   local
 * @package    Swatch_ProductOutOfStockAlert
 * @author     David Voisard
 */
class Swatch_ProductOutOfStockAlert_Block_ProductOutOfStockAlert extends Mage_Core_Block_Template
{
    /**
     * Current product instance
     *
     * @var null|Mage_Catalog_Model_Product
     */
    protected $_product = null;
    
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('productoutofstockalert/form.phtml');
    }
    
    /**
     * Get current product instance
     *
     * @return Mage_ProductAlert_Block_Product_View
     */
    protected function _prepareLayout()
    {
        $product = Mage::registry('current_product');
        if ($product && $product->getId()) {
            $this->_product = $product;
        }

        return parent::_prepareLayout();
    }

    /**
     * Get action form
     * 
     * @return string
     */
    public function getActionForm()
    {
        return $this->getUrl('productoutofstockalert/index/subscribeAlert');
    }

    /**
     * Get product
     *
     * @return Mage_Catalog_Model_Product|null
     */
    public function getProduct()
    {
        return $this->_product;
    }
}
