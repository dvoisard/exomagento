<?php
/**
 * Adminhtml alerts templates grid block
 *
 * @author David Voisard
 */
class Swatch_ProductOutOfStockAlert_Block_Adminhtml_Alerts_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('alertOutOfStock');
        $this->setDefaultSort('entered_at');
        $this->setDefaultSort('DESC');
        $this->setUseAjax(true);
        $this->setFilterVisibility(false);
        $this->setEmptyText(Mage::helper('catalog')->__('There are no customers for this alert.'));
    }

    protected function _prepareCollection()
    {
        $productId = $this->getRequest()->getParam('id');
        if (Mage::helper('catalog')->isModuleEnabled('Swatch_ProductOutOfStockAlert')) {
            $collection = Mage::getModel('swatch_productoutofstockalert/alert')
                ->getCollection()
                ->join($productId);
            $this->setCollection($collection);
        }
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('email', array(
            'header'    => Mage::helper('catalog')->__('Email'),
            'index'     => 'email',
        ));

        $this->addColumn('entered_at', array(
            'header'    => Mage::helper('catalog')->__('Date Subscribed'),
            'index'     => 'entered_at',
            'type'      => 'date'
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        $productId = $this->getRequest()->getParam('id');

        return $this->getUrl('*/catalog_product/alertsOutOfStockGrid', array(
            'id'    => $productId,
        ));
    }

}

