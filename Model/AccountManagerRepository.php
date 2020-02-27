<?php

namespace Highlite\MyAccountManager\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Highlite\MyAccountManager\Api\Data\AccountManagerInterface;
use Highlite\MyAccountManager\Api\Data\AccountManagerSearchResultInterface;
use Highlite\MyAccountManager\Api\Data\AccountManagerSearchResultInterfaceFactory;
use Highlite\MyAccountManager\Api\AccountManagerRepositoryInterface;
use Highlite\MyAccountManager\Model\ResourceModel\AccountManager\CollectionFactory as AccountManagerCollectionFactory;
use Highlite\MyAccountManager\Model\ResourceModel\AccountManager\Collection;

class AccountManagerRepository implements AccountManagerRepositoryInterface
{
    /**
     * @var AccountManagerFactory
     */
    private $accountManagerFactory;

    /**
     * @var AccountManagerCollectionFactory
     */
    private $accountManagerCollectionFactory;

    /**
     * @var AccountManagerSearchResultInterfaceFactory
     */
    private $searchResultFactory;
    
    /**
     * @param AccountManagerFactory $accountManagerFactory
     * @param AccountManagerCollectionFactory $accountManagerCollectionFactory
     * @param AccountManagerSearchResultInterfaceFactory $accountManagerSearchResultInterfaceFactory
     */
    public function __construct(
        AccountManagerFactory $accountManagerFactory,
        AccountManagerCollectionFactory $accountManagerCollectionFactory,
        AccountManagerSearchResultInterfaceFactory $accountManagerSearchResultInterfaceFactory
    ) {
        $this->accountManagerFactory = $accountManagerFactory;
        $this->accountManagerCollectionFactory = $accountManagerCollectionFactory;
        $this->searchResultFactory = $accountManagerSearchResultInterfaceFactory;
    }

    /**
     * @param int $id
     * @return \Highlite\MyAccountManager\Api\Data\AccountManagerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $accountManager = $this->accountManagerFactory->create();
        $accountManager->getResource()->load($accountManager, $id);
        if (!$accountManager->getId()) {
            throw new NoSuchEntityException(__('Unable to find account manager with ID "%1"', $id));
        }
        return $accountManager;
    }

    /**
     * @param \Highlite\MyAccountManager\Api\Data\AccountManagerInterface $accountManager
     * @return \Highlite\MyAccountManager\Api\Data\AccountManagerInterface
     */
    public function save(AccountManagerInterface $accountManager)
    {
        $accountManager->getResource()->save($accountManager);
        return $accountManager;
    }

    /**
     * @param \Highlite\MyAccountManager\Api\Data\AccountManagerInterface $accountManager
     * @return voide
     */
    public function delete(AccountManagerInterface $accountManager)
    {
        $accountManager->getResource()->delete($accountManager);
    }
    
    /**
     * Delete customer by ID.
     *
     * @param int $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id)
    {
        $accountManager = $this->getById($id);
        return $this->delete($accountManager);
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Highlite\MyAccountManager\Api\Data\AccountManagerSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->accountManagerCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }
    
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return void
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }
    
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return void
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return void
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return \Highlite\MyAccountManager\Api\Data\AccountManagerSearchResultInterface
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
