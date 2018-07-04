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
        if (!Mage::helper('swatch_productoutofstockalert')->isEnabled())
        {
            $this->setFlag('', 'no-dispatch', true);
            $this->_redirect('noRoute');
        }
    }
    
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function subscribeAlertAction()
    {
        $productId  = (int) $this->getRequest()->getParam('product');
        if (!$productId) {
            $this->_redirect('');
            return;
        }

        $session = Mage::getSingleton('catalog/session');
        /* @var $session Mage_Catalog_Model_Session */
        $product = Mage::getModel('catalog/product')->load($productId);
        /* @var $product Mage_Catalog_Model_Product */
        if (!$product->getId() || !$product->isVisibleInCatalog()) {
            Mage::getSingleton('customer/session')->addError($this->__('The product was not found.'));
            $this->_redirect('customer/account/');
            return ;
        }
        
        $data = $this->getRequest()->getPost();
        $alert = Mage::getModel('swatch_productoutofstockalert/alert');
        $alert->setData('email', $data['email']);
        $alert->setData('product_id', $productId);
        
        try
        {
            $alert->save();
            $session->addSuccess('Subscribtion to notification save');
        } catch(Exception $e)
        {
          $session->addError('Add Error');
        }
        
        $this->_redirectUrl($product->getProductUrl());
    }
}