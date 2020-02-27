<?php
namespace Highlite\MyAccountManager\Setup;

use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('highlite_account_manager')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('highlite_account_manager')
            )
                ->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Account Id'
                )
                ->addColumn(
                    'manager_name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Manager Name'
                )
                ->addColumn(
                    'manager_number',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    20,
                    ['nullable' => false],
                    'Manager Number'
                )
                ->addColumn(
                    'manager_email',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    30,
                    ['nullable' => false],
                    'Manager Email'
                )
                ->addColumn(
                    'image',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Image'
                )
                ->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    1,
                    ['nullable' => false, 'default' => '0'],
                    'Status'
                )
                 ->addColumn(
                     'created_at',
                     Table::TYPE_DATETIME,
                     null,
                     [],
                     'Created At'
                 )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_DATETIME,
                    null,
                    [],
                    'Updated At'
                )
                ->setComment('Highlite Account Manager');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
