<?php
namespace TechSolve\TextTranslation\Model\ResourceModel;

class Translation extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
    	$this->_init('translation', 'key_id');
    }
}
?>