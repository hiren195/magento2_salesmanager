<?php

namespace Highlite\MyAccountManager\Ui\Component\Index\Listing\Grid\Column;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Highlite\MyAccountManager\Model\Status as StatusSource;

class Status extends Column implements OptionSourceInterface
{
    /**
     * @var StatusSource
     * @since 100.1.0
     */
    protected $source;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StatusSource $source
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StatusSource $source,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->source = $source;
    }

    /**
     * {@inheritdoc}
     * @since 100.1.0
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);
        $options = $this->source->getOptionArray();

        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (isset($options[$item['status']])) {
                $item['status'] = $options[$item['status']];
            }
        }

        return $dataSource;
    }

    /**
     * {@inheritdoc}
     * @since 100.1.0
     */
    public function toOptionArray()
    {
        return $this->source->getReviewStatusesOptionArray();
    }
}
