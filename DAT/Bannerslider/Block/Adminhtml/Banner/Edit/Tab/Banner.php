<?php



namespace DAT\Bannerslider\Block\Adminhtml\Banner\Edit\Tab;

use DAT\Bannerslider\Model\Status;


class Banner extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $_objectFactory;


    protected $_valueCollectionFactory;

    protected $_sliderFactory;


    protected $_banner;


    protected $_wysiwygConfig;

    protected $dateTime;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\DataObjectFactory $objectFactory,
        \DAT\Bannerslider\Model\Banner $banner,
        \DAT\Bannerslider\Model\ResourceModel\Value\CollectionFactory $valueCollectionFactory,
        \DAT\Bannerslider\Model\SliderFactory $sliderFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Framework\Stdlib\DateTime\Timezone $dateTime,
        array $data = []
    ) {
        $this->_objectFactory = $objectFactory;
        $this->_banner = $banner;
        $this->_valueCollectionFactory = $valueCollectionFactory;
        $this->_sliderFactory = $sliderFactory;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->dateTime = $dateTime;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * prepare layout.
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());

        \Magento\Framework\Data\Form::setFieldsetElementRenderer(
            $this->getLayout()->createBlock(
                'DAT\Bannerslider\Block\Adminhtml\Form\Renderer\Fieldset\Element',
                $this->getNameInLayout().'_fieldset_element'
            )
        );

        return $this;

    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $bannerAttributes = $this->_banner->getStoreAttributes();
        $bannerAttributesInStores = ['store_id' => ''];

        foreach ($bannerAttributes as $bannerAttribute) {
            $bannerAttributesInStores[$bannerAttribute.'_in_store'] = '';
        }

        $dataObj = $this->_objectFactory->create(
            ['data' => $bannerAttributesInStores]
        );
        $model = $this->_coreRegistry->registry('banner');

        if ($sliderId = $this->getRequest()->getParam('current_slider_id')) {
            $model->setSliderId($sliderId);
        }

        $dataObj->addData($model->getData());

        $storeViewId = $this->getRequest()->getParam('store');

        $attributesInStore = $this->_valueCollectionFactory
            ->create()
            ->addFieldToFilter('banner_id', $model->getId())
            ->addFieldToFilter('store_id', $storeViewId)
            ->getColumnValues('attribute_code');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix($this->_banner->getFormFieldHtmlIdPrefix());

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Banner Information')]);

        if ($model->getId()) {
            $fieldset->addField('banner_id', 'hidden', ['name' => 'banner_id']);
        }

        $elements = [];
        $elements['name'] = $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
            ]
        );

        $elements['status'] = $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Banner Status'),
                'name' => 'status',
                'options' => Status::getAvailableStatuses(),
            ]
        );

        $slider = $this->_sliderFactory->create()->load($sliderId);

        if ($slider->getId()) {
            $elements['slider_id'] = $fieldset->addField(
                'slider_id',
                'select',
                [
                    'label' => __('Slider'),
                    'name' => 'slider_id',
                    'values' => [
                        [
                            'value' => $slider->getId(),
                            'label' => $slider->getTitle(),
                        ],
                    ],
                ]
            );
        } else {
            $elements['slider_id'] = $fieldset->addField(
                'slider_id',
                'select',
                [
                    'label' => __('Slider'),
                    'name' => 'slider_id',
                    'values' => $model->getAvailableSlides(),
                ]
            );
        }


        $wysiwygConfig = $this->_wysiwygConfig->getConfig();

        $elements['caption'] = $fieldset->addField(
            'caption',
            'editor',
            [
                'title' => __('Caption'),
                'label' => __('Caption'),
                'name' => 'caption',
                'config' => $wysiwygConfig
            ]
        );

        $elements['click_url'] = $fieldset->addField(
            'click_url',
            'text',
            [
                'title' => __('URL'),
                'label' => __('URL'),
                'name' => 'click_url',
            ]
        );

        $elements['image'] = $fieldset->addField(
            'image',
            'image',
            [
                'title' => __('Banner Image'),
                'label' => __('Banner Image'),
                'name' => 'image',
                'note' => 'Allow image type: jpg, jpeg, gif, png',
            ]
        );

        $dateFormat = 'M/d/yyyy';
        $timeFormat = 'h:mm a';
        if($dataObj->hasData('start_time')) {

            $datetime = $this->dateTime->date($dataObj->getData('start_time'), null, $this->_localeDate->getConfigTimezone());
//            $datetime = new \DateTime($dataObj->getData('start_time'));

            $dataObj->setData('start_time',$datetime);

        }

        if($dataObj->hasData('end_time')) {
            $datetime = $this->dateTime->date($dataObj->getData('end_time'), null, $this->_localeDate->getConfigTimezone());
//            $datetime = new \DateTime($dataObj->getData('end_time'));
            $dataObj->setData('end_time', $datetime);
        }

        $style = 'color: #000;background-color: #fff; font-weight: bold; font-size: 13px;';
        $elements['start_time'] = $fieldset->addField(
            'start_time',
            'date',
            [
                'name' => 'start_time',
                'label' => __('Starting time'),
                'title' => __('Starting time'),
                'required' => true,
                'readonly' => true,
                'style' => $style,
                'class' => 'required-entry',
                'date_format' => $dateFormat,
                'time_format' => $timeFormat,
                'note' => implode(' ', [$dateFormat, $timeFormat])
            ]
        );

        $elements['end_time'] = $fieldset->addField(
            'end_time',
            'date',
            [
                'name' => 'end_time',
                'label' => __('Ending time'),
                'title' => __('Ending time'),
                'required' => true,
                'readonly' => true,
                'style' => $style,
                'class' => 'required-entry',
                'date_format' => $dateFormat,
                'time_format' => $timeFormat,
                'note' => implode(' ', [$dateFormat, $timeFormat])
            ]
        );



        foreach ($attributesInStore as $attribute) {
            if (isset($elements[$attribute])) {
                $elements[$attribute]->setStoreViewId($storeViewId);
            }
        }
        $form->addValues($dataObj->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return mixed
     */
    public function getBanner()
    {
        return $this->_coreRegistry->registry('banner');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getPageTitle()
    {
        return $this->getBanner()->getId()
            ? __("Edit Banner '%1'", $this->escapeHtml($this->getBanner()->getName())) : __('New Banner');
    }

    /**
     * Prepare label for tab.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Banner Information');
    }

    /**
     * Prepare title for tab.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Banner Information');
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
}