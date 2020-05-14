<?php

namespace TechSolve\TextTranslation\Controller\Adminhtml\translation;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{


    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * [$translation description]
     * @var [type]
     */
    protected $translation;
    /**
     * [$session description]
     * @var [type]
     */
    protected $session;

    /**
     * [__construct description]
     * @param Action\Context                                     $context           [description]
     * @param \Magento\Framework\View\Result\PageFactory         $resultPageFactory [description]
     * @param \TechSolve\TextTranslation\Model\TranslationFactory $translation       [description]
     * @param \Magento\Backend\Model\Session                     $session           [description]
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \TechSolve\TextTranslation\Model\TranslationFactory $translation,
        \Magento\Backend\Model\Session $session
        ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->translation = $translation;
        $this->session = $session;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('TechSolve_TextTranslation::Translation')
        ->addBreadcrumb(__('TechSolve TextTranslation'), __('TechSolve TextTranslation'))
        ->addBreadcrumb(__('Manage Item'), __('Manage Item'));
        return $resultPage;
    }

    /**
     * Edit Item
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('key_id');
        $model = $this->translation->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This item no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        // 3. Set entered data if was error when we do save
        $data = $this->session->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }


        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->setActiveMenu('TechSolve_TextTranslation::translation');
        $resultPage->addBreadcrumb(__('TechSolve'), __('TechSolve'));
        $resultPage->addBreadcrumb(
            $id ? __('Edit Item') : __('New Item'),
            $id ? __('Edit Item') : __('New Item')
            );
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Item') : __('New Item'));

        return $resultPage;
    }
}