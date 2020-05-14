<?php
namespace TechSolve\TextTranslation\Model;

class Translation extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
    	$this->_init('TechSolve\TextTranslation\Model\ResourceModel\Translation');
    }
}
?>