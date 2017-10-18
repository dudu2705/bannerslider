<?php

/**
 * DAT
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the DAT.com license that is
 * available through the world-wide-web at this URL:
 * http://www.DAT.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    DAT
 * @package     DAT_BannerSlider
 * @copyright   Copyright (c) 2012 DAT (http://www.DAT.com/)
 * @license     http://www.DAT.com/license-agreement.html
 */

namespace DAT\Bannerslider\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * @category DAT
 * @package  DAT_Storelocator
 * @module   Storelocator
 * @author   DAT Developer
 */
class Slider extends \DAT\Bannerslider\Ui\Component\Listing\Column\AbstractColumn
{

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \DAT\Bannerslider\Model\SliderFactory
     */
    protected $_sliderFactory;
    /**
     * Constructor.
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \DAT\Bannerslider\Model\SliderFactory $sliderFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_storeManager = $storeManager;
        $this->_sliderFactory = $sliderFactory;
    }

    /**
     * prepare item.
     *
     * @param array $item
     *
     * @return array
     */
    protected function _prepareItem(array & $item)
    {
        $slider = $this->_sliderFactory->create()->load($item[$this->getData('name')]);

        if (isset($item[$this->getData('name')])) {
            if ($item[$this->getData('name')]) {

                $item[$this->getData('name')] = sprintf(
                    '%s',
                    $slider->getTitle()
                );
            } else {
                $item[$this->getData('name')] = '';
            }
        }

        return $item;
    }
}
