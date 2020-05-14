<?php

namespace TechSolve\TextTranslation\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;
/**
 * 
 */
class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface {
	/**
	 * [upgrade description]
	 * @param  SchemaSetupInterface   $setup   [description]
	 * @param  ModuleContextInterface $context [description]
	 * @return [type]                          [description]
	 */
	public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context) {
		$installer = $setup;

		$installer->startSetup();

		$connection = $installer->getConnection();
		if (version_compare($context->getVersion(), '1.0.3') < 0){

			if ($connection->tableColumnExists($installer->getTable('translation'), 'page_section') === false) {
				$installer->getConnection()->addColumn(
					$installer->getTable('translation'),
					'page_section',
					[
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'length' => 100,
					'nullable' => true,
					'after'     => null,
					'comment' => 'Page Section'
					]
					);
			}
		}

		$installer->endSetup();


	}

}