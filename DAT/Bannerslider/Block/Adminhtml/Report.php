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
namespace DAT\Bannerslider\Block\Adminhtml;
/**
 * Report grid container.
 * @category DAT
 * @package  DAT_Bannerslider
 * @module   Bannerslider
 * @author   DAT Developer
 */
class Report extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_report';
        $this->_blockGroup = 'DAT_Bannerslider';
        $this->_headerText = __('Reports');
        parent::_construct();
        $this->removeButton('add');
    }
}