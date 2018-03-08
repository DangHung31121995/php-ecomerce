<?php
class MenusControllersItems extends Controllers{
    var $module;
    var $gid;
    function __construct(){
        parent::__construct();
        $this->view = 'items';
        $this->gid = FSInput::get('gid');
    }
    
    function display(){
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;
        $model = $this->model;
        $list = $model->getMenuItems();
        $groups = $model->getMenuGroups();
        $pagination = $model->getPagination();
        include 'modules/' . $this->module . '/views/items/list.php';
    }
    
    function getMenuItems(){
        global $db;
        $query = $this->setQuery();
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();
        return $result;
    }
    
    function add(){
        $model = new MenusModelsItems();
        $create_link = $model->getCreateLinks();
        $list = $model->getMenuItemsToParent();
        $groups = $model->getMenuGroups();
        $maxOrdering = $model->getMaxOrdering();
        include 'modules/' . $this->module . '/views/items/detail.php';
    }
    
    function edit()
    {
        $model = new MenusModelsItems();
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $data = $model->get_record_by_id($id);
        $create_link = $model->getCreateLinks();
        $list = $model->getMenuItemsToParent();
        $groups = $model->getMenuGroups();
        include 'modules/' . $this->module . '/views/items/detail.php';
    }
    
    function remove(){
        $model = new MenusModelsItems();
        $rows = $model->remove();
        if ($rows) {
            setRedirect('index.php?module=menus&view=items&gid=' . $this->gid, $rows . ' ' .
                FSText::_('record was deleted'));
        } else {
            setRedirect('index.php?module=menus&view=items&gid=' . $this->gid, FSText::_('Not delete'),
                'error');
        }
    }
    
    function save(){
        $model = new MenusModelsItems();
        $cid = $model->save();
        if ($cid) {
            setRedirect('index.php?module=menus&view=items&gid=' . $this->gid, FSText::_('Saved'));
        } else {
            setRedirect('index.php?module=menus&view=items&gid=' . $this->gid, FSText::_('Not save'), 'error');
        }
    }
    
    function cancel(){
        setRedirect('index.php?module=menus&view=items&gid=' . $this->gid);
    }
    
    function add_param(){
        define('URL_LANG', URL_ROOT);
        $model = new MenusModelsItems();
        $created_link = $model->get_linked_id();
        if (!$created_link)
            return;
        $field_display = $created_link->add_field_display;
        $field_value = $created_link->add_field_value;
        $add_param = $created_link->add_parameter;
        $link_menu = $created_link->link_menu;
        $arr_field_value = explode(',', $field_value);
        $arr_add_param = explode(',', $add_param);
        $list = $model->get_data_from_table($created_link->add_table, $field_display, $field_value,
            $created_link->add_field_distinct);
        $pagination = $model->get_pagination_create_link($created_link->add_table, $field_display,
            $field_value, $created_link->add_field_distinct);
        include 'modules/' . $this->module . '/views/items/add_param.php';
    }
    
    function getMenuParent(){
        $group_id = FSInput::get('group_id', 0);
        $parent_id = FSInput::get('parent_id', 0);
        $model = new MenusModelsItems();
        $list = $model->getMenuByGroups($group_id);
        $html = '<option value="">' . FSText::_('Parent') . '</option>';
        if ($list)
            foreach ($list as $item) {
                $selected = ($parent_id == $item->id) ? "selected=\"selected\"" : "";
                $html .= "<option value='" . $item->id . "' " . $selected . " >" . $item->
                    treename . " </option>";
            }
        echo $html;
    }
}