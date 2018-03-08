<?php
class ModuleControllersModule extends Controllers
{
    var $arrModule;
    function __construct()
    {
        parent::__construct();
        $positions = array(
            'logo-position',
            'featured-position',
            'default-position',
            'content-position',
            'sidebar-position',
            'adleft-position',
            'adright-position');
        $this->position = $positions;
        $this->arrModule = array(
            array(
                'label' => 'Sản phẩm',
                'module' => 'product',
                //'categories' => array()
                'categories' => $this->model->getModuleCategories('fs_products_categories')
            )
        );
    }
    function display()
    {
        $sort_field = FSInput::get('sort_field');
        $sort_direct = FSInput::get('sort_direct');
        $sort_direct = $sort_direct ? $sort_direct : 'asc';
        $positions = $this->position;
        if (@$sort_field)
        {
            $_SESSION['module_sort_field'] = $sort_field;
            $_SESSION['module_sort_direct'] = $sort_direct;
        }
        if (isset($_POST['search']))
        {
            $_SESSION['module_search'] = $_POST['search'];
        }
        $model = $this->model;
        $listmodule = $model->getModuleList();
        $pagination = $model->getPagination();
        $listmoduletype = $model->getModuleTypeList();
        include 'modules/module/views/list.php';
    }
    function add()
    {
        $module_categories = $this->arrModule;
        $positions = $this->position;
        $model = $this->model;
        $menus_items_all = $model->getMenuItems();
        $listmoduletype = $model->getModuleTypeList();
        //$products_categories = $model->getModuleCategories();
        include 'modules/module/views/detail.php';
    }
    function edit()
    {
        $module_categories = $this->arrModule;
        $positions = $this->position;
        $model = $this->model;
        $menus_items_all = $model->getMenuItems();
        $cids = FSInput::get('cid', array(), 'array');
        $cid = $cids[0];
        $data = $model->getModuleById($cid);
        $listmoduletype = $model->getModuleTypeList();
        //$products_categories = $model->getModuleCategories();
        if (@$data->module && @$data->module != 'contents')
            if (file_exists(PATH_BASE . 'blocks' . DS . $data->module . DS . 'config.php'))
                include_once '../blocks/' . $data->module . '/config.php';
        FSFactory::include_class('parameters');
        $current_parameters = new Parameters($data->params);
        $params = isset($params) ? $params : array('suffix' => array('name' => 'Hậu tố',
                    'type' => 'text'));
        include 'modules/module/views/detail.php';
    }
    function remove()
    {
        $model = $this->model;
        $rows = $model->remove();
        if ($rows)
        {
            setRedirect('index.php?module=module', $rows . ' ' . FSText::_('record was deleted'));
        } else
        {
            setRedirect('index.php?module=module', FSText::_('Not delete'), 'error');
        }
    }
    function published()
    {
        $model = $this->model;
        $rows = $model->published(1);
        if ($rows)
        {
            setRedirect('index.php?module=module', $rows . ' ' . FSText::_('record was published'));
        } else
        {
            setRedirect('index.php?module=module', FSText::_('Error when published record'),
                'error');
        }
    }
    function unpublished()
    {
        $model = $this->model;
        $rows = $model->published(0);
        if ($rows)
        {
            setRedirect('index.php?module=module', $rows . ' ' . FSText::_('record was published'));
        } else
        {
            setRedirect('index.php?module=module', FSText::_('Error when published record'),
                'error');
        }
    }
    function save()
    {
        $model = $this->model;
        $cid = $model->save();
        if ($cid)
        {
            setRedirect('index.php?module=module&task=edit&cid=' . $cid, FSText::_('Saved'));
        } else
        {
            setRedirect('index.php?module=module', FSText::_('Not save'), 'error');
        }
    }
    function cancel()
    {
        setRedirect('index.php?module=module');
    }
}
?>