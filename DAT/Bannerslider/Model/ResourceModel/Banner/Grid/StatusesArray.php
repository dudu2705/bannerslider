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

namespace DAT\Bannerslider\Model\ResourceModel\Banner\Grid;

/**
 * Class StatusesArray
 * @package DAT\Affiliateplusprogram\Model\ResourceModel\Program\Grid
 */
class StatusesArray implements \Magento\Framework\Option\ArrayInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            self::STATUS_ENABLED => __('Enabled')
            , self::STATUS_DISABLED => __('Disabled'),
        ];
    }
}
