<?php

class ProductsModelsComments extends FSModels
{
    var $limit;
    var $prefix;
    function __construct()
    {
        $this->limit = 20;
        $this->view = 'comments';
        $this->table_name = 'fs_products_comments';
        parent::__construct();
    }
    function setQuery()
    {
        $ordering = "";
        $where = "  ";
        if (isset($_SESSION[$this->prefix . 'sort_field']))
        {
            $sort_field = $_SESSION[$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            $ordering = '';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
        }
        if (isset($_SESSION[$this->prefix . 'text0']))
        {
            $record_id = $_SESSION[$this->prefix . 'text0'];
            $record_id = intval($record_id);
            if ($record_id)
            {
                $where .= ' AND d.id =  "' . $record_id . '" ';
            }
        }
        if (isset($_SESSION[$this->prefix . 'filter0']))
        {
            $filter = $_SESSION[$this->prefix . 'filter0'];
            if ($filter)
            {
                $where .= ' AND (d.category_id_wrapper like  "%,' . $filter . ',%")';
            }
        }
        if (!$ordering)
            $ordering .= " ORDER BY created_time DESC , id DESC ";
        if (isset($_SESSION[$this->prefix . 'keysearch']))
        {
            if ($_SESSION[$this->prefix . 'keysearch'])
            {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND a.comment LIKE '%" . $keysearch . "%' ";
            }
        }
        $query = " SELECT a.*, d.name as title, d.category_name
						  FROM 
						  	fs_products_comments AS a
						  	INNER JOIN fs_products AS d ON a.product_id = d.id
						  	WHERE admin_reply = 0 " . $where . $ordering . " ";
        return $query;
    }
    
    function save()
    {
        $reply = FSInput::get('reply', 0);
        if($reply)
            $this->save_reply();
        else
            return parent::save();
    }
    
    function save_reply(){
        $row = array();
        $reply_id = FSInput::get('reply_id', 0);
        $row['product_id'] = FSInput::get('reply_product', 0);
        $row['parent_id'] = FSInput::get('reply_parent', 0);
        $row['name'] = 'admin';
        $row['email'] = 'adminemail';
        $row['admin_reply'] = 1;
        $row['comment'] = htmlspecialchars_decode(FSInput::get('comment'));
        $row['created_time'] = date('Y-m-d H:i:s');
        if($reply_id)
            return $this->_update($row, 'fs_products_comments', ' id = '.$reply_id);
        else
            return $this->_add($row, 'fs_products_comments');
    }
    
    function get_categories_tree()
    {
        global $db;
        $query = "  SELECT a.*
					FROM 
					fs_products_categories AS a
					ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $list;
    }
    
    function getCommentByParentId($id){
        global $db;
        $query = "  SELECT *
					FROM fs_products_comments
                    where parent_id = '".$id."'
					ORDER BY id";
        $sql = $db->query($query);
        return $db->getObject();
    }
}
?>