<?php
class ProductsModelsDiscount extends FSModels
{
    var $limit;
    var $prefix;
    
    function __construct()
    {
        $this->limit = 20;
        $this->view = 'discount';
        $this->table_name = 'fs_products_discount';
        $this->img_folder = 'images/discount/' . date('Y/m/d');
        $this->check_alias = 0;
        $this->field_img = 'image';
        parent::__construct();
    }
    
    function save(){
        $row['title']       = FSInput::get('title');
        $row['code']        = trim(FSInput::get('code'));
        $row['values_apply']= FSInput::get('values_apply');
        $row['summary']     = FSInput::get('summary');
        $row['published']   = FSInput::get('published');
        $row['ordering']    = FSInput::get('ordering');
        $row['discount']    = FSInput::get('discount');
        $row['discount_unit']= FSInput::get('discount_unit');
        $row['start_date']      = convertDateTime(FSInput::get('start_date'), '00:00');
        $row['expiration_date'] = convertDateTime(FSInput::get('expiration_date'), '23:59');
        return  parent::save($row);
    }
}
?>