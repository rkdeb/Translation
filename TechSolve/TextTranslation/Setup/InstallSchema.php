<?php

namespace TechSolve\TextTranslation\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{ 
    /**
     * [install description]
     * @param  SchemaSetupInterface   $setup   [description]
     * @param  ModuleContextInterface $context [description]
     * @return [type]                          [description]
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        
        $connection = $installer->getConnection();
        if (version_compare($context->getVersion(), '1.0.2') < 0){

            if ($connection->tableColumnExists($installer->getTable('translation'), 'page_section') === false) {
              $installer->getConnection()->addColumn(
                $installer->getTable('translation'),
                'page_section',
                [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 100,
                'nullable' => true,
                'comment' => 'Page Section'
                ]
                );
          }
      }

      
      $installer->endSetup();

  }
}