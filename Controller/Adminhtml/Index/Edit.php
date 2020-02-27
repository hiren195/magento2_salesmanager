<?php

namespace Highlite\MyAccountManager\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    
    protected $_userFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_userFactory = $userFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Highlite_Index::add_index_row')
            ->addBreadcrumb(__('Highlite Index'), __('Highlite Index'))
            ->addBreadcrumb(__('Manage Item'), __('Manage Index'));
        return $resultPage;
    }

    /**
     * Edit Item
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create(\Highlite\MyAccountManager\Model\AccountManager::class);

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This item no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/index/grid');
            }
        }

        $data = $this->_objectManager->get(\Magento\Backend\Model\Session::class)->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        
        $this->_coreRegistry->register('row_data', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->setActiveMenu('Highlite_MyAccountManager::add_index_row');
        $resultPage->addBreadcrumb(__('Highlite'), __('Highlite'));
        $resultPage->addBreadcrumb(
            $id ? __('Edit Manager') : __('New Manager'),
            $id ? __('Edit Manager') : __('New Manager')
        );
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Manager') : __('New Manager'));

        return $resultPage;
    }
}
