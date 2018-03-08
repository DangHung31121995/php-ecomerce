<?php
/**
 * @author vangiangfly
 * @final 21/04/2013
 */ 
class AboutControllersAbout extends Controllers
{
    function __construct()
    {
        $this->view = 'about';
        parent::__construct();
    }
    function display()
    {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;
        $model = $this->model;
        $list = $model->get_data();
        $categories = $model->get_categories_tree();
        $pagination = $model->getPagination();
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }
    function add()
    {
        $model = $this->model;
        $categories = $model->get_categories_tree();
        $categories_home = $model->get_categories_tree();
        $maxOrdering = $model->getMaxOrdering();
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }
    function edit()
    {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $categories = $model->get_categories_tree();
        $data = $model->get_record_by_id($id);
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }
}
?>