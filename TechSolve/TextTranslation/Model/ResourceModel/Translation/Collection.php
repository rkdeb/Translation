<?php

namespace TechSolve\TextTranslation\Model\ResourceModel\Translation;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('TechSolve\TextTranslation\Model\Translation', 'TechSolve\TextTranslation\Model\ResourceModel\Translation');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>