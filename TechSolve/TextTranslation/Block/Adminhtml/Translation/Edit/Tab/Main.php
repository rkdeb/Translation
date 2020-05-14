<?php

namespace TechSolve\TextTranslation\Block\Adminhtml\Translation\Edit\Tab;

/**
 * Translation edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \TechSolve\TextTranslation\Model\Status
     */
    protected $locale;

    /**
     * [$_translation description]
     * @var [type]
     */
    protected $_translation;

    /**
     * [$request description]
     * @var [type]
     */
    protected $request;

    /**
     * [__construct description]
     * @param \Magento\Backend\Block\Template\Context            $context      [description]
     * @param \Magento\Framework\Registry                        $registry     [description]
     * @param \Magento\Framework\Data\FormFactory                $formFactory  [description]
     * @param \Magento\Store\Model\System\Store                  $systemStore  [description]
     * @param \Magento\Config\Model\Config\Source\Locale         $locale       [description]
     * @param \TechSolve\TextTranslation\Model\TranslationFactory $_translation [description]
     * @param \Magento\Framework\App\RequestInterface            $request      [description]
     * @param array                                              $data         [description]
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Config\Model\Config\Source\Locale $locale,
        \TechSolve\TextTranslation\Model\TranslationFactory $_translation,
        \Magento\Framework\App\RequestInterface $request,
        array $data = []
        ) {
        $this->_systemStore = $systemStore;
        $this->locale = $locale;
        $this->_translation = $_translation;
        $this->request = $request;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \TechSolve\TextTranslation\Model\Translation */
        
        $model = $this->_translation->create()->load($this->request->getParam('key_id'));

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Translation Information')]);

        if ($model->getId()) {
            $fieldset->addField('key_id', 'hidden', ['name' => 'key_id']);
        }


        $fieldset->addField(
            'string',
            'textarea',
            [
            'name' => 'string',
            'label' => __('Original Text'),
            'title' => __('Original Text'),
            'required' => true,
            'disabled' => $isElementDisabled
            ]
            );

        $fieldset->addField(
            'translate',
            'textarea',
            [
            'name' => 'translate',
            'label' => __(' Translate Text'),
            'title' => __(' Translate Text'),
            'required' => true,
            'disabled' => $isElementDisabled
            ]
            );

        $fieldset->addField(
            'store_id',
            'select',
            [
            'name' => 'store_id',
            'label' => __(' Store View'),
            'title' => __(' Store View'),
            'required' => true,
            'disabled' => $isElementDisabled,
            'values'    => $this->_systemStore->getStoreValuesForForm(false, true)
            ]
            );

        $fieldset->addField(
            'locale',
            'select',
            [
            'name' => 'locale',
            'label' => __(' Locale'),
            'title' => __(' Locale'),
            'required' => true,
            'disabled' => $isElementDisabled,
            'values' => $this->locale->toOptionArray()
            ]
            );

        $fieldset->addField(
            'page_section',
            'select',
            [
            'name' => 'page_section',
            'label' => __(' Page Section'),
            'title' => __(' Page Section'),
            'required' => true,
            'disabled' => $isElementDisabled,
            'values' => ['Header'=>'Header','Footer'=>'Footer','Home page'=>'Home page','Listing page'=>'Listing page','Cart'=>'Cart','My account'=>'My account']
            ]
            );


        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Translation Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Translation Information');
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

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    public function getTargetOptionArray(){
    	return array(
            '_self' => "Self",
            '_blank' => "New Page",
            );
    }
}
