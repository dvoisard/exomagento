<?php
/**
 * Productoutofstock observer
 *
 * @package    Swatch_ProductOutOfStockAlert
 * @author     David Voisard
 */
class Swatch_ProductOutOfStockAlert_Model_Observer
{
    /**
     * Error email template configuration
     */
    const XML_PATH_ERROR_TEMPLATE   = 'catalog/productalert_cron/error_email_template';

    /**
     * Error email identity configuration
     */
    const XML_PATH_ERROR_IDENTITY   = 'catalog/productalert_cron/error_email_identity';

    /**
     * 'Send error emails to' configuration
     */
    const XML_PATH_ERROR_RECIPIENT  = 'catalog/productalert_cron/error_email';

    /**
     * Allow stock alert
     *
     */
    const XML_PATH_STOCK_ALLOW      = 'catalog/productalert/allow_stock';

    /**
     * Warning (exception) errors array
     *
     * @var array
     */
    protected $_errors = array();

    /**
     * Process emails
     *
     * @param Swatch_ProductOutOfStockAlert_Model_Alert $alert
     * @return Swatch_ProductOutOfStockAlert_Model_Observer
     */
    protected function _process(Swatch_ProductOutOfStockAlert_Model_Alert $alertModel)
    {
        try {
            $collection = Mage::getModel('productoutofstockalert/alert')
                ->getCollection();
        }
        catch (Exception $e) {
            $this->_errors[] = $e->getMessage();
            return $this;
        }
        $previousEmail = null;
        foreach ($collection as $alert) {
            try {
                if (!$previousEmail || $previousEmail != $alert->getEmail()) {
                    $email = $alert->getEmail();
                    if ($email) {
                        $alert->send();
                    }
                    if (!$email) {
                        continue;
                    }
                    $previousEmail = $email;
                    $email = '';
                }
                else {
                    $email = $previousEmail;
                }

                $product = Mage::getModel('catalog/product')
                    ->load($alert->getProductId());
                /* @var $product Mage_Catalog_Model_Product */
                if (!$product) {
                    continue;
                }
            }
            catch (Exception $e) {
                $this->_errors[] = $e->getMessage();
            }
        }

        if ($email) {
            try {
                $alertModel->send();
            }
            catch (Exception $e) {
                $this->_errors[] = $e->getMessage();
            }
        }

        return $this;
    }

    /**
     * Send email to administrator if error
     *
     * @return Swatch_ProductOutOfStockAlert_Model_Observer
     */
    protected function _sendErrorEmail()
    {
        if (count($this->_errors)) {
            if (!Mage::getStoreConfig(self::XML_PATH_ERROR_TEMPLATE)) {
                return $this;
            }

            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);

            $emailTemplate = Mage::getModel('core/email_template');
            /* @var $emailTemplate Mage_Core_Model_Email_Template */
            $emailTemplate->setDesignConfig(array('area'  => 'backend'))
                ->sendTransactional(
                    Mage::getStoreConfig(self::XML_PATH_ERROR_TEMPLATE),
                    Mage::getStoreConfig(self::XML_PATH_ERROR_IDENTITY),
                    Mage::getStoreConfig(self::XML_PATH_ERROR_RECIPIENT),
                    null,
                    array('warnings' => join("\n", $this->_errors))
                );

            $translate->setTranslateInline(true);
            $this->_errors[] = array();
        }
        return $this;
    }

    /**
     * Run process send product alerts
     *
     * @return Swatch_ProductOutOfStockAlert_Model_Observer
     */
    public function process()
    {
        $alert = Mage::getModel('swatch_productoutofstock/alert');
        $this->_process($alert);
        $this->_sendErrorEmail();

        return $this;
    }
}
