<?php

namespace Highlite\MyAccountManager\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface AccountManagerSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Highlite\MyAccountManager\Api\Data\AccountManagerInterface[]
     */
    public function getItems();

    /**
     * @param \Highlite\MyAccountManager\Api\Data\AccountManagerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
