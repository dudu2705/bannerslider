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

namespace DAT\Bannerslider\Model;

/**
 * Value Model
 * @category DAT
 * @package  DAT_Bannerslider
 * @module   Bannerslider
 * @author   DAT Developer
 */
class Value extends \Magento\Framework\Model\AbstractModel
{
    /**
     * constructor.
     *
     * @param \Magento\Framework\Model\Context                        $context
     * @param \Magento\Framework\Registry                             $registry
     * @param \DAT\Bannerslider\Model\ResourceModel\Value            $resource
     * @param \DAT\Bannerslider\Model\ResourceModel\Value\Collection $resourceCollection
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \DAT\Bannerslider\Model\ResourceModel\Value $resource,
        \DAT\Bannerslider\Model\ResourceModel\Value\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
    }

    /**
     * load attribute value.
     *
     * @param int    $bannerId
     * @param int    $storeViewId
     * @param string $attributeCode
     *
     * @return $this
     */
//    public function loadAttributeValue($bannerId, $storeViewId, $attributeCode)
//    {
//        $attributeValue = $this->getResourceCollection()
//            ->addFieldToFilter('banner_id', $bannerId)
//            ->addFieldToFilter('store_id', $storeViewId)
//            ->addFieldToFilter('attribute_code', $attributeCode)
//            ->setPageSize(1)->setCurPage(1)
//            ->getFirstItem();
//
//        $this->setData('banner_id', $bannerId)
//            ->setData('store_id', $storeViewId)
//            ->setData('attribute_code', $attributeCode);
//        if ($attributeValue->getId()) {
//            $this->addData($attributeValue->getData())
//                ->setId($attributeValue->getId());
//        }
//
//        return $this;
//    }

    public function loadAttributeValue($bannerId, $storeViewId, $attributeCode)
    {
        $attributeValue = $this->getResourceCollection()
            ->addFieldToFilter('banner_id', $bannerId)
            ->addFieldToFilter('store_id', $storeViewId)
            ->addFieldToFilter('attribute_code', array('in' => $attributeCode));
//            ->setPageSize(1)->setCurPage(1)
//            ->getFirstItem();
        foreach($attributeValue as $model){
            $this->setData('banner_id', $bannerId)
                ->setData('store_id', $storeViewId)
                ->setData('attribute_code', $model->getData('attribute_code'));
            if ($model->getId()) {
                $this->addData($model->getData())
                    ->setId($model->getId());
            }
        }

        return $attributeValue;
    }
}
