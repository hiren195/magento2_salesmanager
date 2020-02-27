<?php
namespace Highlite\MyAccountManager\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * Get Config Path
     *
     * @var string
     */
    const XML_PATH_ACCOUNTMANAGER = 'accountmanager/';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    public $_storeManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Helper\Context $context,
        array $data = []
    ) {
        $this->_storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * Get Config Value
     *
     * @return string
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get Config Value
     *
     * @return string
     */
    public function getManagerName($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_ACCOUNTMANAGER .'general/'. $code, $storeId);
    }

    /**
     * Get Config Value
     *
     * @return string
     */
    public function getManagerEmail($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_ACCOUNTMANAGER .'general/'. $code, $storeId);
    }

    /**
     * Get Config Value
     *
     * @return string
     */
    public function getManagerNumber($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_ACCOUNTMANAGER .'general/'. $code, $storeId);
    }
}
