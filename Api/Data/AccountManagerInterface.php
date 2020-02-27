<?php

namespace Highlite\MyAccountManager\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface AccountManagerInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return void
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getManagerName();

    /**
     * @param string $managerName
     * @return void
     */
    public function setManagerName($managerName);

    /**
     * @return string
     */
    public function getManagerNumber();

    /**
     * @param string $managerNumber
     * @return void
     */
    public function setManagerNumber($managerNumber);

    /**
     * @return string
     */
    public function getManagerEmail();

    /**
     * @param string $managerEmail
     * @return void
     */
    public function setManagerEmail($managerEmail);

    /**
     * @return string
     */
    public function getImage();

    /**
     * @param string $imageUrl
     * @return void
     */
    public function setImage($imageUrl);

    /**
     * @return bool
     */
    public function getStatus();

    /**
     * @param bool $status
     * @return void
     */
    public function setStatus($status);

    /**
     * @return datetime
     */
    public function getCreatedAt();

    /**
     * @param datetime $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt);

    /**
     * @return datetime
     */
    public function getUpdatedAt();

    /**
     * @param datetime $updatedAt
     * @return void
     */
    public function setUpdatedAt($updatedAt);

    /**
     * @return \Highlite\MyAccountManager\Api\Data\AccountManagerExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * @param \Highlite\MyAccountManager\Api\Data\AccountManagerExtensionInterface $extensionAttributes
     * @return void
     */
    public function setExtensionAttributes(AccountManagerExtensionInterface $extensionAttributes);
}
