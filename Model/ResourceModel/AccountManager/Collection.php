<?php
namespace Highlite\MyAccountManager\Model\ResourceModel\AccountManager;
  
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
  
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    
    protected function _construct()
    {
        $this->_init(
            \Highlite\MyAccountManager\Model\AccountManager::class,
            \Highlite\MyAccountManager\Model\ResourceModel\AccountManager::class
        );
    }
}
