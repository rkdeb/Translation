<?php
namespace TechSolve\TextTranslation\Controller\Adminhtml\translation;
use Magento\Backend\App\Action;
class Delete extends \Magento\Backend\App\Action
{
    /**
     * [$_translation description]
     * @var [type]
     */
    private $_translation;


    /**
     * [__construct description]
     * @param Action\Context                                     $context      [description]
     * @param \TechSolve\TextTranslation\Model\TranslationFactory $_translation [description]
     */
    public function __construct(
        Action\Context $context,
        \TechSolve\TextTranslation\Model\TranslationFactory $_translation
        )
    {

        $this->_translation = $_translation;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('key_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                // init model and delete
                $model = $this->_translation->create();
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('The item has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['key_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a item to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}