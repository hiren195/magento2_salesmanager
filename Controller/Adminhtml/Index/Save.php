<?php

namespace Highlite\MyAccountManager\Controller\Adminhtml\Index;

use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Variable\Model\VariableFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Highlite\MyAccountManager\Model\AccountManagerFactory
     */
    protected $myaccountmanagerFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime $datetime
     */
    protected $datetime;
    
    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public $_storeManager;

    /**
     * @var Filesystem $fileSystem
     */
    protected $fileSystem;
    
    /**
     * @var UploaderFactory $uploaderFactory
     */
    protected $uploaderFactory;
    
    protected $allowedExtensions = ['png','jpeg','jpg'];
    
    protected $fileId = 'image';
     
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Highlite\MyAccountManager\Model\AccountManagerFactory $myaccountmanagerFactory
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $datetime
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Filesystem $fileSystem
     * @param UploaderFactory $uploaderFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Highlite\MyAccountManager\Model\AccountManagerFactory $myaccountmanagerFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Filesystem $fileSystem,
        UploaderFactory $uploaderFactory
    ) {
        parent::__construct($context);
        $this->myaccountmanagerFactory = $myaccountmanagerFactory;
        $this->datetime = $datetime;
        $this->_storeManager = $storeManager;
        $this->fileSystem = $fileSystem;
        $this->uploaderFactory = $uploaderFactory;
    }
 
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $imagePath = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            $this->_redirect('myaccountmanager/index/new');
            return;
        }

        try {
            
            $destinationPath = $this->getDestinationPath();
            $filename = '';
            $file = $this->getRequest()->getFiles($this->fileId);
            if (!empty($file)) {
                $filename =  $file['name'];
                if ($file['error'] == 0 && $filename) {
                    $data['image'] = 'myaccountmanager/'.str_replace(' ', '_', $filename);
                }
            }

            if (is_array($data['image'])) {
                $data['image'] = $data['image']['value'];
            }

            if ($filename) {
                $uploader = $this->uploaderFactory->create(['fileId' => $this->fileId])
                    ->setAllowCreateFolders(true)
                    ->setAllowedExtensions($this->allowedExtensions)
                    ->setAllowRenameFiles(true)
                    ->addValidateCallback('validate', $this, 'validateFile');
                $result = $uploader->save($destinationPath);
                if (!$result) {
                    throw new LocalizedException(
                        __('File cannot be saved to path: $1', $destinationPath)
                    );
                } else {
                    if ($result['error'] == 0) {
                        $data['image'] = 'myaccountmanager/'.$result['file'];
                    }
                }
            }

            $data['created_at'] = $this->datetime->gmtDate();
            $data['updated_at'] = $this->datetime->gmtDate();
            
            $rowData = $this->myaccountmanagerFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Manager has been saved successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('myaccountmanager/index/grid');
    }
 
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Highlite_MyAccountManager::manager');
    }

    public function getDestinationPath()
    {
        return $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('/myaccountmanager/');
    }
}
