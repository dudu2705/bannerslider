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

namespace DAT\Bannerslider\Controller\Adminhtml\Banner;

use Magento\Framework\Controller\ResultFactory;
use DAT\Bannerslider\Model\ResourceModel\Banner\Grid\StatusesArray;
/**
 * MassDelete action.
 * @category DAT
 * @package  DAT_Bannerslider
 * @module   Bannerslider
 * @author   DAT Developer
 */
class MassEnable extends \DAT\Bannerslider\Controller\Adminhtml\AbstractAction
{

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {

        $collection = $this->_massActionFilter->getCollection($this->_createMainCollection());
        $collectionSize = $collection->getSize();
        $storeId = $this->getRequest()->getParam('store');
        $collection->setStoreViewId($storeId);
        foreach ($collection as $item) {
            $item->setStoreViewId($storeId);
            $item->setStatus(StatusesArray::STATUS_ENABLED);
            try{
                $item->save();

            }catch (\Exception $e){
                $this->messageManager->addError($e->getMessage());
            }
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
