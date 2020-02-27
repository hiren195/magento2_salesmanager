<?php

namespace Highlite\MyAccountManager\Model;

use Magento\Framework\Data\OptionSourceInterface;
 
class Status implements OptionSourceInterface
{
    const ENABEL = 1;
    const DISABLE = 2;
    
    /**
     * Get Grid row status type labels array.
     * @return array
     */
    public function getOptionArray()
    {
        $options = [self::ENABEL => __('Enable'), self::DISABLE => __('Disable')];
        return $options;
    }
 
    /**
     * Get Grid row status labels array with empty value for option element.
     *
     * @return array
     */
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
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
