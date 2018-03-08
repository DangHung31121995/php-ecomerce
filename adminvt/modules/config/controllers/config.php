<?php
class ConfigControllersConfig extends Controllers
{
    function __construct()
    {
        parent::__construct();
    }
    function display()
    {
        $model = $this->model;
        $data = $model->getData();
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }
    function save()
    {
        $model = $this->model;
        $cid = $model->save();
        if ($cid)
        {
            setRedirect('index.php?module=config', FSText::_('Saved'));
        } else
        {
            setRedirect("index.php?module=config", FSText::_('Not save'), 'error');
        }
    }
    function delete_cache(){
        recursiveDelete(PATH_BASE.'cache/');
        setRedirect('index.php?module=config&view=config', FSText::_('Xóa cache thành công!'));
    }
}
?>