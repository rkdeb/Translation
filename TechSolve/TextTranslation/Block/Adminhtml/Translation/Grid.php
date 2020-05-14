<?php
namespace TechSolve\TextTranslation\Block\Adminhtml\Translation;


class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \TechSolve\TextTranslation\Model\translationFactory
     */
    protected $_translationFactory;

    /**
     * @var \TechSolve\TextTranslation\Model\Status
     */
    protected $locale;

    protected $systemStore;



    /**
     * [__construct description]
     * @param \Magento\Backend\Block\Template\Context             $context            [description]
     * @param \Magento\Backend\Helper\Data                        $backendHelper      [description]
     * @param \TechSolve\TextTranslation\Model\TranslationFactory $TranslationFactory [description]
     * @param \Magento\Store\Model\System\Store                   $systemStore        [description]
     * @param \Magento\Config\Model\Config\Source\Locale          $locale             [description]
     * @param \Magento\Framework\Module\Manager                   $moduleManager      [description]
     * @param array                                               $data               [description]
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \TechSolve\TextTranslation\Model\TranslationFactory $TranslationFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Config\Model\Config\Source\Locale $locale,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
        ) {
        $this->_translationFactory = $TranslationFactory;
        $this->locale = $locale;
        $this->systemStore = $systemStore;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('key_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_translationFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {


        $this->addColumn(
            'key_id',
            [
            'header' => __('ID'),
            'type' => 'number',
            'index' => 'key_id',
            'column_css_class'=>'no-display',
            'header_css_class'=>'no-display'
            ]
            );

        $this->addColumn(
            'page_section',
            [
            'header' => __('Page Section'),
            'type' => 'string',
            'index' => 'page_section',
            'type' => 'options',
            'options' => ['Header'=>'Header','Footer'=>'Footer','Home page'=>'Home page','Listing page'=>'Listing page','Cart'=>'Cart','My account'=>'My account']
            ]
            );



        $this->addColumn(
           'string',
           [
           'header' => __('Original Text'),
           'index' => 'string',
           ]
           );

        $this->addColumn(
           'translate',
           [
           'header' => __(' Translate Text'),
           'index' => 'translate',
           ]
           );

        $this->addColumn(
           'store_id',
           [
           'header' => __(' Store View'),
           'index' => 'store_id',
           'type' => 'store'
           ]
           );

        $this->addColumn(
           'locale',
           [
           'header' => __(' Locale'),
           'index' => 'locale',
           'type' => 'options',
           'options' => $this->getLocaleForOptions()
           ]
           );




        $this->addColumn(
            'edit',
            [
            'header' => __('Edit'),
            'type' => 'action',
            'getter' => 'getId',
            'actions' => [
            [
            'caption' => __('Edit'),
            'url' => [
            'base' => '*/*/edit'
            ],
            'field' => 'key_id'
            ]
            ],
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'header_css_class' => 'col-action',
            'column_css_class' => 'col-action'
            ]
            );




        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }


    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('key_id');
        $this->getMassactionBlock()->setFormFieldName('translation');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
            'label' => __('Delete'),
            'url' => $this->getUrl('texttranslation/*/massDelete'),
            'confirm' => __('Are you sure?')
            ]
            );
        return $this;
    }


    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('texttranslation/*/index', ['_current' => true]);
    }

    /**
     * @param \TechSolve\TextTranslation\Model\translation|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {

        return $this->getUrl(
            'texttranslation/*/edit',
            ['key_id' => $row->getId()]
            );

    }

    private function getLocaleForOptions(){
        $locale = $this->locale->toOptionArray();

        $options = [];
        foreach ($locale as $key => $_locale) {
            $options[$_locale['value']] = $_locale['label'];
        }

        return $options;
    }


}