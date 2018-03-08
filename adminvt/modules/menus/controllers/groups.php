<?php
include 'modules/' . $module . '/models/groups.php';
class MenusControllersGroups{
    var $module;
    function __construct(){
        $module = 'menus';
        $this->module = $module;
    }
    function display(){
        $sort_field = FSInput::get('sort_field');
        $sort_direct = FSInput::get('sort_direct');
        $sort_direct = $sort_direct ? $sort_direct : 'asc';
        if (@$sort_field) {
            $_SESSION['menusgroup_sort_field'] = $sort_field;
            $_SESSION['menusgroup_sort_direct'] = $sort_direct;
        }
        $model = new MenusModelsGroups();
        $list = $model->getMenuGroups();
        $pagination = $model->getPagination();
        include 'modules/' . $this->module . '/views/groups/list.php';
    }
    function add(){
        include 'modules/' . $this->module . '/views/groups/detail.php';
    }
    function edit(){
        $model = new MenusModelsGroups();
        $cids = FSInput::get('cid', array(), 'array');
        $cid = $cids[0];
        $data = $model->getMenuGroupById($cid);
        include 'modules/' . $this->module . '/views/groups/detail.php';
    }
    function remove(){
        $model = new MenusModelsGroups();
        $rows = $model->remove();
        if ($rows) {
            setRedirect('index.php?module=menus&view=groups', $rows . ' ' . FSText::_('record was deleted'));
        } else {
            setRedirect('index.php?module=menus&view=groups', FSText::_('Not delete'),
                'error');
        }
    }
    function published(){
        $model = new MenusModelsGroups();
        $rows = $model->published(1);
        if ($rows) {
            setRedirect('index.php?module=menus&view=groups', $rows . ' ' . FSText::_('record was published'));
        } else {
            setRedirect('index.php?module=menus&view=groups', FSText::_('Error when published record'),
                'error');
        }
    }
    function unpublished(){
        $model = new MenusModelsGroups();
        $rows = $model->published(0);
        if ($rows) {
            setRedirect('index.php?module=menus&view=groups', $rows . ' ' . FSText::_('record was published'));
        } else {
            setRedirect('index.php?module=menus&view=groups', FSText::_('Error when published record'),
                'error');
        }
    }
    function save(){
        $model = new MenusModelsGroups();
        $cid = $model->save();
        if ($cid) {
            setRedirect('index.php?module=menus&view=groups', FSText::_('Saved'));
        } else {
            setRedirect('index.php?module=menus&view=groups', FSText::_('Not save'), 'error');
        }
    }
    function cancel(){
        setRedirect('index.php?module=menus&view=groups');
    }
}