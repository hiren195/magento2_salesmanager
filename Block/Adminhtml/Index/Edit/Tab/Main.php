<?php

namespace Highlite\MyAccountManager\Block\Adminhtml\Index\Edit\Tab;

/**
 * Coach edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Highlite\MyAccountManager\Model\Status
     */
    protected $_status;
    
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Highlite\MyAccountManager\Model\Status $status
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Highlite\MyAccountManager\Model\Status $status,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \Highlite\Coach\Model\BlogPosts */
        $model = $this->_coreRegistry->registry('row_data');
        
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        
        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Manager Information')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
        
        $fieldset->addField(
            'manager_name',
            'text',
            [
                'name' => 'manager_name',
                'label' => __('Manager Name'),
                'id' => 'manager_name',
                'title' => __('Manager Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'manager_number',
            'text',
            [
                'name' => 'manager_number',
                'label' => __('Manager Number'),
                'id' => 'manager_number',
                'title' => __('Manager Number'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'manager_email',
            'text',
            [
                'name' => 'manager_email',
                'label' => __('Manager Email'),
                'id' => 'manager_email',
                'title' => __('Manager Email'),
                'class' => 'required-entry validate-email',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'image',
            'image',
            [
                'name' => 'image',
                'label' => __('Image'),
                'id' => 'image',
                'title' => __('Image'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
            
        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'id' => 'status',
                'title' => __('Status'),
                'values' => $this->_status->getOptionArray(),
                'class' => 'status',
                'required' => true,
            ]
        );
            
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Manager Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Manager Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
