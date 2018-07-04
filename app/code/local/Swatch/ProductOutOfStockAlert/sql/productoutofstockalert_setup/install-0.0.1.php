<?php
/**
* News installation script
*
* @author David Voisard
*/

/**
* @var $installer Mage_Core_Model_Resource_Setup
*/
$installer = $this;

$installer->startSetup();

/**
* Creating table productoutofstockalert_log
*/
$table = $installer->getConnection()
        ->newTable($installer->getTable('productoutofstockalert_log/log'))
        ->addColumn('log_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'identity' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Entity id')
        ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Product ID')
        ->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable' => true,
        ), 'Email')
        ->addColumn('entered_at', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
            'nullable' => true,
            'default'  => null,
        ), 'Entered date')
        ->addIndex(
            $installer->getIdxName(
                $installer->getTable('productoutofstockalert_log/log'),
                array('entered_at'),
                Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
            ),
            array('entered_at'),
            array('product_id' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX)
        )
        ->addForeignKey($installer->getFkName('productoutofstockalert_log/log', 'product_id', 'catalog/product', 'entity_id'),
            'product_id', $installer->getTable('catalog/product'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
        )
        ->setComment('Log product out of stock alert');

$installer->getConnection()->createTable($table);

$installer->endSetup();
