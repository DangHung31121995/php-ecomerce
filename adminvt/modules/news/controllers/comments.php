<?php

class NewsControllersComments extends Controllers
{
    function __construct()
    {
        $this->view = 'comments';
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
        die;
    }

    function edit()
    {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $data = $model->get_record_by_id($id);
        $record = $model->get_record_by_id($data->record_id, 'fs_news');
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function reply()
    {
        $id = FSInput::get('id', 0);
        $parent = $this->model->get_record_by_id($id);
        $record = $this->model->get_record_by_id($parent->record_id, 'fs_news');
        $data = $this->model->getCommentByParentId($id);
        include 'modules/' . $this->module . '/views/' . $this->view . '/reply.php';
    }
}

?>