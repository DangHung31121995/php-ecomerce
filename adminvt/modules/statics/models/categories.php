<?php
class StaticsModelsCategories extends ModelsCategories
{
    function __construct()
    {
        $this->limit = 20;
        $this->table_items = 'fs_statics';
        $this->table_name = 'fs_statics_categories';
        $this->check_alias = 1;
        $this->call_update_sitemap = 1;
        // exception: key (field need change) => name ( key change follow this field)
        $this->field_except_when_duplicate = array(array('list_parents', 'id'), array('alias_wrapper',
                    'alias'));
        parent::__construct();
    }
}
?>