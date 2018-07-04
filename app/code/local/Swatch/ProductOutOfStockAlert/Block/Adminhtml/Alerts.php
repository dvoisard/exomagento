<?php
/**
 * @author David Voisard
 */
class Swatch_ProductOutOfStockAlert_Block_Adminhtml_Alerts extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('productoutofstockalert/list.phtml');
    }


    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('swatch_productoutofstock/adminhtml_alerts_grid', 'adminhtml.alerts.grid'));
        return parent::_prepareLayout();
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/productoutofstockalert');
    }

    public function getHeaderText()
    {
        return Mage::helper('Cutsomer Out Of Stock Alerts')->__('Alerts');
    }
}
