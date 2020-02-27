<?php

namespace Highlite\MyAccountManager\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Highlite\MyAccountManager\Api\Data\AccountManagerInterface;

interface AccountManagerRepositoryInterface
{
    /**
     * @param int $id
     * @return \Highlite\MyAccountManager\Api\Data\AccountManagerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \Highlite\MyAccountManager\Api\Data\AccountManagerInterface $accountManager
     * @return \Highlite\MyAccountManager\Api\Data\AccountManagerInterface
     */
    public function save(AccountManagerInterface $accountManager);

    /**
     * @param \Highlite\MyAccountManager\Api\Data\AccountManagerInterface $accountManager
     * @return voide
     */
    public function delete(AccountManagerInterface $accountManager);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Highlite\MyAccountManager\Api\Data\AccountManagerSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
    
    /**
     * Delete manager by ID.
     *
     * @param int $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}
