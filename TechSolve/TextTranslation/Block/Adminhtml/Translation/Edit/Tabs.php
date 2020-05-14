<?php
namespace TechSolve\TextTranslation\Block\Adminhtml\Translation\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('translation_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Translation Information'));
    }
}