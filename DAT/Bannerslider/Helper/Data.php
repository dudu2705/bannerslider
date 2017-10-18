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
 * @package     DAT_Bannerslider
 * @copyright   Copyright (c) 2012 DAT (http://www.DAT.com/)
 * @license     http://www.DAT.com/license-agreement.html
 */

namespace DAT\Bannerslider\Helper;

use DAT\Bannerslider\Model\Slider;

/**
 * Helper Data
 * @category DAT
 * @package  DAT_Bannerslider
 * @module   Bannerslider
 * @author   DAT Developer
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $_backendUrl;

    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * category collection factory.
     *
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $_categoryCollectionFactory;

    /**
     * [__construct description].
     *
     * @param \Magento\Framework\App\Helper\Context                      $context              [description]
     * @param \Magento\Directory\Helper\Data                             $directoryData        [description]
     * @param \Magento\Directory\Model\ResourceModel\Country\Collection       $countryCollection    [description]
     * @param \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regCollectionFactory [description]
     * @param \Magento\Store\Model\StoreManagerInterface                 $storeManager         [description]
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->_storeManager = $storeManager;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * get Base Url Media.
     *
     * @param string $path   [description]
     * @param bool   $secure [description]
     *
     * @return string [description]
     */
    public function getBaseUrlMedia($path = '', $secure = false)
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA, $secure) . $path;
    }

    /**
     * get categories array.
     *
     * @return array
     */
    public function getCategoriesArray()
    {
        $categoriesArray = $this->_categoryCollectionFactory->create()
            ->addAttributeToSelect('name')
            ->addAttributeToSort('path', 'asc')
            ->load()
            ->toArray();

        $categories = array();
        foreach ($categoriesArray as $categoryId => $category) {
            if (isset($category['name']) && isset($category['level'])) {
                $categories[] = array(
                    'label' => $category['name'],
                    'level' => $category['level'],
                    'value' => $categoryId,
                );
            }
        }

        return $categories;
    }

    /**
     * get Slider Banner Url
     * @return string
     */
    public function getSliderBannerUrl()
    {
        return $this->_backendUrl->getUrl('*/*/banners', ['_current' => true]);
    }

    /**
     * get Backend Url
     * @param  string $route
     * @param  array  $params
     * @return string
     */
    public function getBackendUrl($route = '', $params = ['_current' => true])
    {
        return $this->_backendUrl->getUrl($route, $params);
    }

    /**
     * getSliderModeAvailable
     * @return array
     */
    public function getSliderModeAvailable()
    {
        return [
            Slider::STYLESLIDE_EVOLUTION_ONE => 'Slider Evolution Default',
            Slider::STYLESLIDE_EVOLUTION_TWO => 'Slider Evolution Caborno',
            Slider::STYLESLIDE_EVOLUTION_THREE => 'Slider Evolution Minimalist',
            Slider::STYLESLIDE_EVOLUTION_FOUR => 'Slider Evolution Fresh',
            Slider::STYLESLIDE_POPUP => 'Pop up on Home page',
            Slider::STYLESLIDE_SPECIAL_NOTE => 'Note displayed on all pages',
            Slider::STYLESLIDE_FLEXSLIDER_ONE => 'FlexSlider 1',
            Slider::STYLESLIDE_FLEXSLIDER_TWO => 'FlexSlider 2',
            Slider::STYLESLIDE_FLEXSLIDER_THREE => 'FlexSlider 3',
            Slider::STYLESLIDE_FLEXSLIDER_FOUR => 'FlexSlider 4',
        ];
    }

    /**
     *  get Style Slider
     * @return array
     */
    public function getStyleSlider()
    {
        return [
            [
                'label' => __('--------- Please choose style -------'),
                'value' => '',
            ],


            [
                'label' => __('Dat Slider'),
                'value' => [
                    [
                        'label' => __(' Dat Slider 1'),
                        'value' => Slider::STYLESLIDE_FLEXSLIDER_ONE,
                    ]

                ],
            ],
        ];
    }

    /**
     * get Animation A
     * @return array
     */
    public function getAnimationA()
    {
        return [
            [
                'label' => __('Fade'),
                'value' => 'fade',
            ],
            [
                'label' => __('Square'),
                'value' => 'squarerandom',
            ],
            [
                'label' => __('Bar'),
                'value' => 'bar',
            ],
            [
                'label' => __('Rain'),
                'value' => 'rain',
            ],
        ];
    }

    /**
     * get Animation B
     * @return array
     */
    public function getAnimationB()
    {
        return [
            [
                'label' => __('Slide'),
                'value' => 'slide',
            ],
            [
                'label' => __('Fade'),
                'value' => 'fade',
            ],
        ];
    }

    /**
     * get Option Color
     * @return array
     */
    public function getOptionColor()
    {
        return [
            ['label' => __('Yellow'), 'value' => '#f7d700'],
            ['label' => __('Red'), 'value' => '#dd0707'],
            ['label' => __('Orange'), 'value' => '#ee5f00'],
            ['label' => __('Green'), 'value' => '#83ba00'],
            ['label' => __('Blue'), 'value' => '#23b8ff'],
            ['label' => __('Gray'), 'value' => '#999'],
        ];
    }

    /**
     * get Block Ids To Options Array
     * @return array
     */
    public function getBlockIdsToOptionsArray()
    {
        return [
            [
                'label' => __(' Please choose position '),
                'value' => '',
            ],
            [
                'label' => __('Choose please'),
                'value' => [
                    ['value' => 'cms-page-content-top', 'label' => __('Get it in home page')],
                ],
            ],



        ];
    }

    /**
     * get Available Positions
     * @return array
     */
    public function getAvailablePositions()
    {
        return [
            'pop-up' => __('Pop up at Home page'),
            'note-allsite' => __('Note will be displayed on all pages'),
            'cms-page-content-top' => __('Homepage content top'),
            'custom' => __('Custom'),
            'sidebar-right-top' => __('Sidebar-Top-Right(all pages)'),
            'sidebar-right-bottom' => __('Sidebar-Bottom-Right (all pages)'),
            'sidebar-left-top' => __('Sidebar-Top-Left(all pages)'),
            'sidebar-left-bottom' => __('Sidebar-Bottom-Left(all pages)'),
            'content-top' => __('Content-Top(all pages)'),
            'menu-top' => __('Menu-Top(all pages)'),
            'menu-bottom' => __('Menu-Bottom(all pages)'),
            'page-bottom' => __('Page-Bottom(all pages)'),
            'catalog-sidebar-right-top' => __(' Catalog-Sidebar-Top-Right'),
            'catalog-sidebar-right-bottom' => __('Catalog-Sidebar-Bottom-Right'),
            'catalog-sidebar-left-top' => __('Catalog-Sidebar-Top-Left'),
            'catalog-sidebar-left-bottom' => __('Catalog-Sidebar-Bottom-Left'),
            'catalog-content-top' => __('Catalog-Content-Top'),
            'catalog-menu-top' => __('Catalog-Menu-Top'),
            'catalog-menu-bottom' => __('Catalog-Menu-Bottom'),
            'catalog-page-bottom' => __('Catalog-Page-Bottom'),
            'category-sidebar-right-top' => __('Category-Sidebar-Top-Right'),
            'category-sidebar-right-bottom' => __('Category-Sidebar-Bottom-Right'),
            'category-sidebar-left-top' => __('Category-Sidebar-Top-Left'),
            'category-sidebar-left-bottom' => __('Category-Sidebar-Bottom-Left'),
            'category-content-top' => __('Category-Content-Top'),
            'category-menu-top' => __('Category-Menu-Top'),
            'category-menu-bottom' => __('Category-Menu-Bottom'),
            'category-page-bottom' => __('Category-Page-Bottom'),
            'product-sidebar-right-top' => __('Product-Sidebar-Top-Right'),
            'product-sidebar-right-bottom' => __('Product-Sidebar-Bottom-Right'),
            'product-sidebar-left-top' => __('Product-Sidebar-Top-Left'),
            'product-sidebar-left-bottom' => __('Product-Sidebar-Bottom-Left'),
            'product-content-top' => __('Product-Content-Top'),
            'product-menu-top' => __('Product-Menu-Top'),
            'product-menu-bottom' => __('Product-Menu-Bottom'),
            'product-page-bottom' => __('Product-Page-Bottom'),
            'customer-content-top' => __('Customer-Content-Top'),
            'cart-content-top' => __('Cart-Content-Top'),
            'checkout-content-top' => __('Checkout-Content-Top'),
            'customer-sidebar-main-top' => __('Customer-Siderbar-Main-Top'),
            'customer-sidebar-main-bottom' => __('Customer-Siderbar-Main-Bottom'),
        ];
    }

    /**
     * get list slider for preview.
     *
     * @return []
     */
    public function getCoreSlider()
    {
        return [

            [
                'label' => __('FlexSlider 1'),
                'value' => Slider::STYLESLIDE_FLEXSLIDER_ONE,
            ],

        ];
    }
}
