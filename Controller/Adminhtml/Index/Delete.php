<?php
namespace Highlite\MyAccountManager\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;

class Delete extends \Magento\Backend\App\Action
{
    protected $scopeConfig;
    protected $_userFactory;
    
    /**
     * @param Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\User\Model\UserFactory $userFactory,
        Action\Context $context
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_userFactory = $userFactory;
        parent::__construct($context);
    }
    
    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Highlite\MyAccountManager\Model\AccountManager::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('The manager has been deleted.'));
                return $resultRedirect->setPath('*/index/grid');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/index/edit', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a manager to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/index/grid');
    }
}
