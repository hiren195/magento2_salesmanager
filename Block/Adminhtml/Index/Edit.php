<?php

namespace Highlite\MyAccountManager\Block\Adminhtml\Index;
 
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
 
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry           $registry
     * @param array                                 $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }
 
    /**
     * Initialize Imagegallery Images Edit Block.
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Highlite_MyAccountManager';
        $this->_controller = 'adminhtml_index';
        parent::_construct();
        if ($this->_isAllowedAction('Highlite_MyAccountManager::manager')) {
            $this->buttonList->update('save', 'label', __('Save'));
        } else {
            $this->buttonList->remove('save');
        }
        $this->buttonList->update('delete', 'label', __('Delete Account'));
        $this->buttonList->remove('reset');
    }
 
    /**
     * Retrieve text for header element depending on loaded post
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('row_data')->getId()) {
            return __(
                "Edit Plan '%1'",
                $this->escapeHtml($this->_coreRegistry->registry('row_data')->getManagerName())
            );
        } else {
            return __('New Plan');
        }
    }
    
    /**
     * Check permission for passed action.
     *
     * @param string $resourceId
     *
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
    
    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            'myaccountmanager/index/save',
            ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']
        );
    }
    
    public function getBackUrl()
    {
        parent::getBackUrl();
        return $this->getUrl('myaccountmanager/index/grid');
    }
}
