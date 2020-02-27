<?php
namespace Highlite\MyAccountManager\Block;

use Highlite\MyAccountManager\Model\ResourceModel\AccountManager\CollectionFactory as AccountManagerFactory;

class AccountManager extends \Magento\Framework\View\Element\Template
{
    
    /**
     * @var \Magento\Framework\View\Element\Template\Context $context
     */
    protected $_context;

    /**
     * @var AccountManagerFactory $myAccountManager
     */
    protected $myAccountManager;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    protected $customerSession;

    /**
     * @var Highlite\MyAccountManager\Helper\Data $helper
     */
    protected $helper;
    
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Magento\Framework\Image\AdapterFactory
     */
    protected $imageFactory;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    private $fileDriver;
   
    /**
     * @param \Highlite\MyAccountManager\Helper\Data $helper
     * @param Magento\Customer\Api\CustomerRepositoryInterface $customer
     * @param \Magento\Customer\Model\Session $customerSession
     * @param AccountManagerFactory $myAccountManager
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Image\AdapterFactory $imageFactory
     * @param \Magento\Framework\Filesystem\Driver\File $fileDriver
     * @param \Magento\Framework\View\Element\Template\Context $context
     */
    public function __construct(
        \Highlite\MyAccountManager\Helper\Data $helper,
        \Magento\Customer\Api\CustomerRepositoryInterface $customer,
        \Magento\Customer\Model\Session $customerSession,
        AccountManagerFactory $myAccountManager,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->helper = $helper;
        $this->customer = $customer;
        $this->customerSession = $customerSession;
        $this->myAccountManager = $myAccountManager;
        $this->filesystem = $filesystem;
        $this->imageFactory = $imageFactory;
        $this->fileDriver = $fileDriver;
        
        parent::__construct($context);
    }

    /**
     * get account manager Id by customer
     *
     * @return int
     */
    public function getAccountManager()
    {
        if ($this->customerSession->getCustomer()->getId()) {
            $customerData = $this->customer->getById($this->customerSession->getCustomer()->getId());
            if ($customerData->getCustomAttribute('account_manager')) {
                return $customerData->getCustomAttribute('account_manager')->getValue();
            }
        }
    }

    /**
     * load manager based on customer selection
     *
     * @return Highlite\MyAccountManager\Model\ResourceModel\AccountManager\Collection|NULL
     */
    public function loadManager()
    {
        if ($this->getAccountManager() !== null) {
            $managerId = $this->getAccountManager();
            $collection = $this->myAccountManager->create();
            $collection->addFieldToFilter('id', ['eq' => $managerId]);
            $collection->addFieldToFilter('status', ['neq' => \Highlite\MyAccountManager\Model\Status::DISABLE]);
            
            if ($collection->getSize()) {
                return $collection->getFirstItem();
            }
        } else {
            return;
        }
    }

    /**
     * Get Config Value
     *
     * @return string
     */
    public function getManagerName()
    {
        return $this->helper->getManagerName('manager_name');
    }

    /**
     * Get Config Value
     *
     * @return string
     */
    public function getManagerNumber()
    {
        return $this->helper->getManagerNumber('manager_number');
    }

    /**
     * Get Config Value
     *
     * @return string
     */
    public function getManagerEmail()
    {
        return $this->helper->getManagerEmail('manager_email');
    }

    /**
     * @param string $image
     * @param string $width
     * @param string $height
     * @return string
     */
    public function resize($image, $width = null, $height = null)
    {
        $absolutePath = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)
            ->getAbsolutePath().$image;
        if (!$this->fileDriver->isExists($absolutePath)) {
            return false;
        }

        $imageResized = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)
            ->getAbsolutePath('myaccountmanager/resized/'.$width).str_replace('myaccountmanager', '', $image);
        if (!$this->fileDriver->isExists($imageResized)) {
            $imageResize = $this->imageFactory->create();
            $imageResize->open($absolutePath);
            $imageResize->constrainOnly(true);
            $imageResize->keepTransparency(true);
            $imageResize->keepFrame(true);
            $imageResize->keepAspectRatio(true);
            $imageResize->backgroundColor([255, 255, 255]);
            $imageResize->resize($width, $height);
            $destination = $imageResized;
            //save image
            $imageResize->save($destination);
        }
        $resizedURL = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
        .'myaccountmanager/resized/'.$width.str_replace('myaccountmanager', '', $image);

        return $resizedURL;
    }
}
