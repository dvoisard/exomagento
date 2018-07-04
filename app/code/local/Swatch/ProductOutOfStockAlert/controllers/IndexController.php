<?php
/**
* Form frontend controller
*
* @author David Voisard
*/
class Swatch_ProductOutOfStockAlert_IndexController extends Mage_Core_Controller_Front_Action
{
    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::helper('productoutofstockalert')->isEnabled())
        {
            $this->setFlag('', 'no-dispatch', true);
            $this->_redirect('noRoute');
        }
    }
}