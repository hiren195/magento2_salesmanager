<?php

namespace Highlite\MyAccountManager\Model;
  
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\AbstractExtensibleModel;
use Highlite\MyAccountManager\Api\Data\AccountManagerExtensionInterface;
use Highlite\MyAccountManager\Api\Data\AccountManagerInterface;

class AccountManager extends AbstractExtensibleModel implements AccountManagerInterface
{
    const NAME = 'manager_name';
    const NUMBER = 'manager_number';
    const EMAIL = 'manager_email';
    const IMAGE_URL = 'image';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(\Highlite\MyAccountManager\Model\ResourceModel\AccountManager::class);
    }

    /**
     * @return string
     */
    public function getManagerName()
    {
        return $this->_getData(self::NAME);
    }

    /**
     * @param string $managerName
     * @return void
     */
    public function setManagerName($managerName)
    {
        $this->setData(self::NAME, $managerName);
    }

    /**
     * @return string
     */
    public function getManagerNumber()
    {
        return $this->_getData(self::NUMBER);
    }

    /**
     * @param string $managerNumber
     * @return void
     */
    public function setManagerNumber($managerNumber)
    {
        $this->setData(self::NUMBER, $managerNumber);
    }

    /**
     * @return string
     */
    public function getManagerEmail()
    {
        return $this->_getData(self::EMAIL);
    }

    /**
     * @param string $managerEmail
     * @return void
     */
    public function setManagerEmail($managerEmail)
    {
        $this->setData(self::EMAIL, $managerEmail);
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->_getData(self::IMAGE_URL);
    }

    /**
     * @param string $imageUrl
     * @return void
     */
    public function setImage($imageUrl)
    {
        $this->setData(self::IMAGE_URL, $imageUrl);
    }

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->_getData(self::STATUS);
    }

    /**
     * @param bool $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * @param datetime $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->_getData(self::UPDATED_AT);
    }

    /**
     * @param datetime $updatedAt
     * @return void
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * @return \Highlite\MyAccountManager\Api\Data\AccountManagerExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @param \Highlite\MyAccountManager\Api\Data\AccountManagerExtensionInterface $extensionAttributes
     * @return void
     */
    public function setExtensionAttributes(AccountManagerExtensionInterface $extensionAttributes)
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
