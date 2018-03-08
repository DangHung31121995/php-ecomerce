<?php
include 'blocks/products_filter/models/products_filter.php';
class Products_filterBControllersProducts_filter{
    function __construct(){
        
    }

    function display($parameters, $title, $blockId = 0){
        $this->filter_has_cal($parameters, $title, $blockId = 0);
    }
    
    function filter_no_cal($parameters, $title){
        $model = new Products_filterBModelsProducts_filter();
        $cat = $model->get_category();
        $list = $model->get_filters_no_calculate($cat);
        if (!count($list))
            return;

        $arr_fields_current = array(); // mảng đang duyệt trên URL
        $arr_filter_by_field = array();
        foreach ($list as $item) {
            if (!isset($arr_filter_by_field[$item->field_name])) {
                $arr_filter_by_field[$item->field_name] = array();
            }
            $arr_filter_by_field[$item->field_name][] = $item;
            if (isset($arr_filter_is_browing) && count($arr_filter_is_browing) && in_array($item->
                alias, $arr_filter_is_browing))
                $arr_fields_current[] = $item;
        }

        if (!count($list))
            return;
        $style = $parameters->getParams('style');
        $style = $style ? $style : 'default';
        include 'blocks/products_filter/views/' . $style . '.php';
    }
    
    function filter_has_cal_auto($parameters, $title){
        $model = new Products_filterBModelsProducts_filter();
        $cat = $model->get_category();
        $fields_in_table_has_filter = $model->get_filter_by_tablename($cat->tablename ?
            $cat->tablename : 'fs_products');
        if (!$fields_in_table_has_filter)
            return;
        $list = $model->get_filters_has_calculate($cat);
        $arr_filter_by_field = array();
        foreach ($fields_in_table_has_filter as $field) {
            foreach ($list as $item) {
                if ($item->record_id == $field->id) {
                    if (!isset($arr_filter_by_field[$item->field_name])) {
                        $arr_filter_by_field[$item->field_name] = array();
                    }
                    $arr_filter_by_field[$item->field_name][] = $item;
                }
            }
        }
        $style = $parameters->getParams('style');
        $style = $style ? $style : 'default';
        $arr_fields_current = $model->get_filter_is_browing($cat);
        $filter_request = FSInput::get('filter');
        $arr_filter_request = $filter_request ? explode(',', $filter_request) : null;
        include 'blocks/products_filter/views/' . $style . '.php';
    }
    
    function filter_has_cal($parameters, $title, $blockId = 0){
        $model = new Products_filterBModelsProducts_filter();
        $cat = $model->get_category(); 
        $tablename = $cat->tablename ? $cat->tablename : 'fs_products';
        $fields_in_table_has_filter = $model->get_filter_by_tablename($tablename);
        if (!$fields_in_table_has_filter)
            return;
        $where_url = $model->set_query_from_url($cat->id, $tablename);
        $filter = FSInput::get('filter');
        $filter_request = $filter;
        $arr_filter_is_browing = array();
        if ($filter) {
            $arr_filter_is_browing = explode(',', $filter);
        }
        $arr_filter_by_field = array();
        foreach ($fields_in_table_has_filter as $field) {
            if (count($arr_filter_is_browing) && in_array(str_replace('_', '-', $field->field_name) . '-' . $field->alias, $arr_filter_is_browing)) {
                $field->has_selected = 1;
                $arr_filter_by_field[$field->field_show][] = $field;
            } else {
                $field->has_selected = 0;
                $arr_filter_by_field[$field->field_show][] = $field;
            }
        }
        $style = $parameters->getParams('style');
        $style = $style ? $style : 'default';
        $arr_filter_request = $filter_request ? explode(',', $filter_request) : null;
        include 'blocks/products_filter/views/' . $style . '.php';
    }
    
    function create_link($filter){
        global $tmpl, $filter_request, $arr_filter_request;
        $field_name_alias = str_replace('_','-',$filter->field_name);
        if($arr_filter_request){
            $arr_filter_request = preg_replace('/'.$field_name_alias.'-(.*)/',$field_name_alias.'-'.$filter->alias,$arr_filter_request);
            // loại bỏ phần tử giống nhau
            $buff_filter_id = array_unique($arr_filter_request);
    		$str_filter_id = implode(",",$buff_filter_id);
    		$link = FSRoute::addParameters('filter',$str_filter_id);
        } else {
            $str_filter_id = $filter_request?$filter_request.",".$field_name_alias.'-'.$filter -> alias:$field_name_alias.'-'.$filter -> alias;
            $link = FSRoute::addParameters('filter',$str_filter_id);
        }
        return $link;
    }
}
