<?php
class ExtendsControllersTables extends Controllers{
    function __construct()
    {
        parent::__construct();
        $this->fields_default = array(
            0 => array('show' => 'Id', 'name' => 'id', 'type' => 'int'),
            1 => array('show' => 'Tên', 'name' => 'name', 'type' => 'varchar'),
            2 => array('show' => 'Tên hiệu', 'name' => 'alias', 'type' => 'varchar'),
            3 => array('show' => 'Thứ tự', 'name' => 'ordering', 'type' => 'int'),
            4 => array('show' => 'Hiển thị', 'name' => 'published', 'type' => 'int'),
            5 => array('show' => 'Ngày tạo', 'name' => 'created_time', 'type' => 'datetime'),
            6 => array('show' => 'Ngày sửa', 'name' => 'edited_time', 'type' => 'datetime'));
    }
    
    function display(){
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;
        $model = $this->model;
        $list = $model->get_data();
        $pagination = $model->getPagination();
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }
    
    function edit(){
        $model = $this->model;
        $data = $model->getTableFields();
        $table_name = FSInput::get('tablename');
        $table_name = strtolower($table_name);
        $default_table = $model->check_enable_default_table($table_name);
        include 'modules/' . $this->module . '/views/tables/detail.php';
    }
    
    function apply_edit(){
        $model = $this->model;
        $tablename = FSInput::get('table_name');
        $tablename = strtolower($tablename);
        $tablename = "fs_extends_" . $tablename;
        $rs = $model->save_edit();
        if ($rs) {
            $cid = FSInput::get('cid');
            setRedirect("index.php?module=" . $this->module . '&view=' . $this->view .
                "&task=edit&tablename=$tablename", FSText::_('Saved'));
        } else {
            setRedirect("index.php?module=" . $this->module . '&view=' . $this->view, FSText::
                _('Error'), 'error');
        }
    }
    
    function save_edit(){
        $model = $this->model;
        $rs = $model->save_edit();
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
        $model = $this->model;
        $rs = $model->table_new();
        if ($rs) {
            setRedirect("index.php?module=" . $this->module . '&view=' . $this->view .
                "&task=edit&tablename=$rs", "L&#432;u th&#224;nh c&#244;ng");
        } else {
            setRedirect("index.php?module=" . $this->module . '&view=' . $this->view, FSText::
                _('Error'), 'error');
        }
    }

    function save_new(){
        $model = $this->model;
        $rs = $model->table_new();
        if ($rs) {
            setRedirect("index.php?module=" . $this->module . '&view=' . $this->view,
                "L&#432;u th&#224;nh c&#244;ng");
        } else {
            setRedirect("index.php?module=" . $this->module . '&view=' . $this->view, FSText::
                _('Error'), 'error');
        }
    }
    
    function table_add(){
        $fields_default = $this->fields_default;
        $model = $this->model;
        include 'modules/' . $this->module . '/views/tables/new.php';
    }
    
    function filter(){
        $tablename = FSInput::get('table_name');
        if ($tablename) {
            $tablename = "fs_extends_" . $tablename;
            setRedirect("index.php?module=" . $this->module . "&view=filters&tablename=$tablename");
        } else {
            $this->table_add();
        }
    }
}