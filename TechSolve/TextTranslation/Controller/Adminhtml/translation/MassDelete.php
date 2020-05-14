<?php
namespace TechSolve\TextTranslation\Controller\Adminhtml\translation;

use Magento\Backend\App\Action;

/**
 * Class MassDelete
 */
class MassDelete extends \Magento\Backend\App\Action
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
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $itemIds = $this->getRequest()->getParam('translation');
        if (!is_array($itemIds) || empty($itemIds)) {
            $this->messageManager->addErrorMessage(__('Please select item(s).'));
        } else {
            try {
                foreach ($itemIds as $itemId) {
                    $post = $this->_translation->create()->load($itemId);
                    $post->delete();
                }
                $this->messageManager->addSuccessMessage(
                    __('A total of %1 record(s) have been deleted.', count($itemIds))
                    );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        return $this->resultRedirectFactory->create()->setPath('texttranslation/*/index');
    }
}