<?php
class ProductsControllersTables extends Controllers{
    function __construct(){
        parent::__construct();
        $this->type = 'products';
    }
    
    function display(){
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;
        $list = $this->model->get_data();
        $group_field = $this->model->get_group_field();
        $foreign_data = $this->model->get_foreign_data();
        $pagination = $this->model->getPagination();
        include 'modules/' . $this->module . '/views/tables/list.php';
    }
    
    function edit(){
        $data = $this->model->getTableFields();
        $group_field = $this->model->get_group_field();
        $foreign_data = $this->model->get_foreign_data();
        $fields_default = $this->model->get_default_fields_in_extends();
        $str_field_default = 'id, record_id';
        foreach ($fields_default as $item)
            $str_field_default .= ', ' . $item->field_name;
        include 'modules/' . $this->module . '/views/tables/detail.php';
    }
    
    function apply_edit(){
        $tablename = FSInput::get('table_name');
        $tablename = strtolower($tablename);
        $tablename = $tablename;
        $rs = $this->model->save_edit();
        if($rs){
            $cid = FSInput::get('cid');
            setRedirect("index.php?module=".$this->module.'&view='.$this->view."&task=edit&tablename=$tablename", FSText::_('Saved'));
        }else{
            setRedirect("index.php?module=".$this->module.'&view='.$this->view."&task=edit&tablename=$tablename", FSText::_('Error'), 'error');
        }
    }
    
    function save_edit(){
        $rs = $this->model->save_edit();
        if ($rs) {
            $cid = FSInput::get('cid');
            setRedirect("index.php?module=" . $this->module . '&view=' . $this->view, FSText::
                _('Saved'));
        } else {
            setRedirect("index.php?module=" . $this->module . '&view=' . $this->view, FSText::
                _('Error'), 'error');
        }
    }
    
    function cancel(){
        setRedirect("index.php?module=" . $this->module . '&view=' . $this->view);
    }
    
    function apply_new(){
        $rs = $this->model->table_new();
        if ($rs) {
            setRedirect("index.php?module=".$this->module.'&view='.$this->view."&task=edit&tablename=$rs", "L&#432;u th&#224;nh c&#244;ng");
        }else{
            setRedirect("index.php?module=" . $this->module . '&view=' . $this->view, FSText::_('Error'), 'error');
        }
    }

    function save_new(){
        $rs = $this->model->table_new();
        if ($rs) {
            setRedirect("index.php?module=" . $this->module . '&view=' . $this->view, "L&#432;u th&#224;nh c&#244;ng");
        } else {
            setRedirect("index.php?module=" . $this->module . '&view=' . $this->view, FSText::_('Error'), 'error');
        }
    }
    
    function table_add(){
        $group_field = $this->model->get_group_field();
        $foreign_data = $this->model->get_foreign_data();
        $fields_default = $this->model->get_default_fields_in_extends();
        $str_field_default = 'id, record_id';
        foreach ($fields_default as $item)
            $str_field_default .= ', ' . $item->field_name;
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function filter(){
        $tablename = FSInput::get('table_name');
        if ($tablename) {
            $tablename = "fs_" . $this->type . "_" . $tablename;
            setRedirect("index.php?module=" . $this->module . "&view=filters&tablename=$tablename");
        } else {
            $this->table_add();
        }
    }
}