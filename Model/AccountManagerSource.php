<?php

namespace Highlite\MyAccountManager\Model;

use Highlite\MyAccountManager\Model\ResourceModel\AccountManager\CollectionFactory as MyAccountManagerFactory;

class AccountManagerSource extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * @var MyAccountManagerFactory
     */
    protected $myAccountManager;

    /**
     * @param MyAccountManagerFactory $MyAccountManager
     */
    public function __construct(MyAccountManagerFactory $myAccountManager)
    {
        $this->myAccountManager = $myAccountManager;
    }

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        /* your Attribute options list*/
        $labels = $this->myAccountManager->create();
        $this->_options = [['label'=>'Select', 'value'=>'']];
        foreach ($labels as $label) {
            $this->_options[] =  ['label'=>$label->getManagerName(), 'value'=>$label->getId()];
        }
        
        return $this->_options;
    }

    public function getReviewStatusesOptionArray()
    {
        $result = [];
        foreach ($this->getOptionArray() as $value => $label) {
            $result[] = ['value' => $value, 'label' => $label];
        }

        return $result;
    }
 
    /**
     * Get Grid row type array for option element.
     * @return array
     */
    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }
 
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
