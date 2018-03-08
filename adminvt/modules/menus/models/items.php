<?php
class MenusModelsItems extends FSModels{
    var $limit;
    var $page;
    var $prefix;
    function __construct(){
        parent::__construct();
        $limit = 30;
        $limit_created_link = 30;
        $page = FSInput::get('page');
        $this->limit = $limit;
        $this->limit_created_link = $limit_created_link;
        $this->page = $page;
        $this->view = 'items';
        $this->table_name = 'fs_menus_items';
        $this->table_link = 'fs_menus_createlink';
    }
    
    function getMenuItems(){
        global $db;
        $query = $this->setQuery();
        $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        $limit = $this->limit;
        $page = $this->page ? $this->page : 1;
        $start = $limit * ($page - 1);
        $end = $start + $limit;
        $list_new = array();
        $i = 0;
        foreach ($list as $row){
            if ($i >= $start && $i < $end)
            {
                $list_new[] = $row;
            }
            $i++;
            if ($i > $end)
                break;
        }
        return $list_new;
    }
    
    function getMenuGroups(){
        global $db;
        $query = "  SELECT id, group_name
				    FROM fs_menus_groups 
                    WHERE 1=1 ".SQL_FILTER_BY_ADLANG;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    
    function getMenuByGroups($id = 0){
        global $db;
        $query = "  SELECT id, name, parent_id
					FROM " . $this->table_name . " 
                    WHERE group_id = ".$id.SQL_FILTER_BY_ADLANG.' ORDER BY ordering ASC';
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $fs_tree = FSFactory::getClass('tree', 'tree');
        $list = $fs_tree->indentRows($result);
        return $list;
    }
    
    function getMenuItemsToParent(){
        global $db;
        $query = "  SELECT id, name, parent_id
					FROM " . $this->table_name . " 
                    WHERE show_admin = 1".SQL_FILTER_BY_ADLANG;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $fs_tree = FSFactory::getClass('tree', 'tree');
        $list = $fs_tree->indentRows($result);
        return $list;
    }
    
    function setQuery(){
        $ordering = "";
        $where = "  ";
        if (isset($_SESSION[$this->prefix . 'sort_field']))
        {
            $sort_field = $_SESSION[$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            $ordering = '';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct, a.group_id, created_time DESC, id DESC ";
        }
        if (!$ordering)
            $ordering .= " ORDER BY group_id ASC, created_time DESC , id DESC ";
        if (isset($_SESSION[$this->prefix . 'keysearch']))
        {
            if ($_SESSION[$this->prefix . 'keysearch'])
            {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND a.name LIKE '%" . $keysearch . "%' ";
            }
        }
        if (isset($_SESSION[$this->prefix . 'filter0']))
        {
            $filter = $_SESSION[$this->prefix . 'filter0'];
            if ($filter)
            {
                $where .= ' AND group_id =  "' . $filter . '" ';
            }
        }
        $gid = FSInput::get('gid');
        $query = "  SELECT a.*, parent_id as parent_id, b.group_name 
					FROM " . $this->table_name . " as a
					LEFT JOIN fs_menus_groups as b ON a.group_id  = b.id 
					WHERE show_admin = 1 ".$where." AND a.lang ='".$_SESSION['adlang']."'".$ordering;
        return $query;
    }
    
    function getTotal(){
        global $db;
        $query = $this->setQuery();
        $sql = $db->query($query);
        $total = $db->getTotal();
        return $total;
    }
    
    function getMenuItemById($id){
        $query = "  SELECT *
					FROM " . $this->table_name . "
					WHERE id = $id ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    
    function save(){
        global $db;
        $id = FSInput::get('id', 0, 'int');
        $parent_id = FSInput::get('parent_id');
        if ($id){
            if ($parent_id == $id){
                Errors::_('Parent is not exactly');
                return false;
            }
        }
        $name = FSInput::get('name');
        $alias = FSInput::get('alias');
        if (!$name){
            return false;
        }
        $fsstring = FSFactory::getClass('FSString', '', '../');
        if ($alias){
            $alias = $fsstring->stringStandart($alias);
        } else{
            $alias = $fsstring->stringStandart($name);
        }
        $group_id = FSInput::get('group_id');
        $published = FSInput::get('published');
        $ordering = FSInput::get('ordering');
        $target = FSInput::get('target');
        $link = htmlspecialchars_decode(FSInput::get('link'));
        $default = FSInput::get('default');
        $time = date('Y-m-d H:i:s');
        $show_admin = 1;
        $image = $_FILES["image"]["name"];
        $sql_insert_img_field = "";
        $sql_insert_img_value = "";
        $sql_update_img = " ";
        $is_html = FSInput::get('is_html');
        $html = htmlspecialchars_decode(FSInput::get('html'));
        if ($image){
            $fsFile = FSFactory::getClass('FsFiles');
            $path = PATH_BASE . 'images/menus/';
            $image = $fsFile->uploadImage("image", $path, 2000000, '_' . time());
            if (!$image)
                return false;
            $sql_insert_img_field = "image,";
            $sql_insert_img_value = "'$image',";
            $sql_update_img = "image = '$image', ";
        }
        if (@$id){
            if (!$parent_id)
            {
                $level = 0;
                $list_parent = $id;
            } else{
                $parent_item = $this->getMenuItemById($parent_id);
                $level = ($parent_item->level + 1);
                $list_parent = $parent_item->list_parent . "," . $id;
            }
            $sql = " UPDATE  " . $this->table_name . " SET 
							name = '$name',
							alias = '$alias',
							link = '$link',
							parent_id = '$parent_id'," . $sql_update_img . " group_id = '$group_id',
							published = '$published',
							ordering = '$ordering',
							target = '$target',
							show_admin = '$show_admin',
							`default` = '$default',
							updated_time = '$time',
							list_parent = '$list_parent',
							level = '$level'
						WHERE id = 	$id 
				";
            $db->query($sql);
            $rows = $db->affected_rows();
            if ($rows)
            {
                return $id;
            }
            return 0;
        } else {
            $sql = " INSERT INTO " . $this->table_name . "
							(name,alias," . $sql_insert_img_field .
                "link,parent_id,group_id,published,ordering,target,show_admin,`default`,updated_time,created_time)
							VALUES ('$name','$alias'," . $sql_insert_img_value . "'$link','$parent_id','$group_id','$published','$ordering','$target','$show_admin','$default','$time','$time');
							";
            $db->query($sql);
            $id = $db->insert();
            if (!$id)
                return;
            if (!$parent_id)
            {
                $level = 0;
                $list_parent = $id;
            } else
            {
                $parent_item = $this->getMenuItemById($parent_id);
                $level = ($parent_item->level + 1);
                $list_parent = $parent_item->list_parent . "," . $id;
            }
            $sql = " UPDATE  " . $this->table_name . " SET 
							list_parent = '$list_parent',
							level = '$level'
							WHERE id = " . $id . " ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $id;
        }
    }
    
    function getCreateLinks(){
        global $db;
        $query = "  SELECT *, parent_id as parent_id
					FROM  " . $this->table_link . "
					WHERE published = 1
					ORDER BY parent_id, ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        foreach ($result as $item)
        {
            $item->name = FSText::_($item->name);
        }
        $fs_tree = FSFactory::getClass('tree', 'tree');
        $list = $fs_tree->indentRows($result);
        return $list;
    }
    
    function getParentLink(){
        global $db;
        $query = "  SELECT parent, count(*) as nums_child
					FROM " . $this->table_link . "						 
					WHERE published = 1	
					GROUP BY parent ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    
    function get_linked_id(){
        $id = FSInput::get('id', 0, 'int');
        if (!$id)
            return;
        global $db;
        $query = "  SELECT *
					FROM  " . $this->table_link . "
                    WHERE published = 1 AND id = $id ";
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    
    function set_query_create_link($add_table, $add_field_display, $add_field_value, $add_field_distinct){
        $query = '';
        if ($add_field_distinct)
        {
            if ($add_field_display != $add_field_value)
            {
                echo "Khi đã chọn distinct, duy nhất chỉ xét một trường. Bạn hãy check lại trường hiển thị và trường dữ liệu";
                return false;
            }
            $query .= ' SELECT DISTINCT ' . $add_field_display . ' ';
        } else
        {
            $query .= ' SELECT ' . $add_field_display . ' ,' . $add_field_value . '  ';
        }
        $query .= ' FROM ' . $add_table;
        $query .= '	WHERE published = 1 ';
        return $query;
    }
    
    function get_data_from_table($add_table, $add_field_display, $add_field_value, $add_field_distinct){
        $query = $this->set_query_create_link($add_table, $add_field_display, $add_field_value,
            $add_field_distinct);
        if (!$query)
            return;
        global $db;
        $sql = $db->query_limit($query, $this->limit_created_link, $this->page);
        $result = $db->getObjectList();
        return $result;
    }
    
    function get_total_create_link($add_table, $add_field_display, $add_field_value,$add_field_distinct)
    {
        global $db;
        $query = $this->set_query_create_link($add_table, $add_field_display, $add_field_value,
            $add_field_distinct);
        $sql = $db->query($query);
        $total = $db->getTotal();
        return $total;
    }
    
    function get_pagination_create_link($add_table, $add_field_display, $add_field_value,$add_field_distinct)
    {
        $total = $this->get_total_create_link($add_table, $add_field_display, $add_field_value,
            $add_field_distinct);
        $pagination = new Pagination($this->limit_created_link, $total, $this->page);
        return $pagination;
    }
}