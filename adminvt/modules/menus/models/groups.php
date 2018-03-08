<?php
class MenusModelsGroups{
    var $limit;
    var $page;
    function __construct(){
        $page = FSInput::get('page');
        $this->limit = 30;
        $this->page = $page;
    }
    
    function setQuery(){
        $ordering = '';
        if (isset($_SESSION['menusgroup_sort_field'])) {
            $sort_field = $_SESSION['menusgroup_sort_field'];
            $sort_direct = $_SESSION['menusgroup_sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct ";
        }
        $query = "  SELECT *
                    FROM fs_menus_groups
                    WHERE 1=1 ".SQL_FILTER_BY_ADLANG."
                    $ordering";
        return $query;
    }
    
    function getMenuGroups(){
        global $db;
        $query = $this->setQuery();
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();
        return $result;
    }
    
    function getTotal(){
        global $db;
        $query = $this->setQuery();
        $sql = $db->query($query);
        $total = $db->getTotal();
        return $total;
    }
    
    function getPagination(){
        $total = $this->getTotal();
        $pagination = new Pagination($this->limit, $total, $this->page);
        return $pagination;
    }
    
    function getMenuGroupById($cid){
        $query = "  SELECT *
					FROM fs_menus_groups
				    WHERE id = $cid ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function save(){
        global $db;
        $group_name = FSInput::get('group_name');
        $published = FSInput::get('published');
        $ordering = FSInput::get('ordering');
        $id = FSInput::get('id');
        if (@$id) {
            $sql = "UPDATE fs_menus_groups SET 
						group_name = '$group_name',
						published = '$published',
						ordering = '$ordering'
					WHERE id = 	$id";
            $db->query($sql);
            $rows = $db->affected_rows();
            if ($rows) {
                return $id;
            }
            return 0;
        } else {
            $sql = "INSERT INTO fs_menus_groups(group_name, published, ordering, lang)
					VALUES ('$group_name', '$published', '$ordering', '".$_SESSION['adlang']."')";
            $db->query($sql);
            $id = $db->insert();
            return $id;
        }
    }

    function remove(){
        $cids = FSInput::get('cid', array(), 'array');
        if (count($cids)) {
            global $db;
            $str_cids = implode(',', $cids);
            $sql = "DELETE FROM fs_menus_groups 
					WHERE id IN ( $str_cids ) ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        return 0;
    }

    function published($value){
        $cids = FSInput::get('cid', array(), 'array');
        if (count($cids)) {
            global $db;
            $str_cids = implode(',', $cids);
            $sql = "UPDATE fs_menus_groups
					SET published = $value WHERE id IN ( $str_cids ) ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        return 0;
    }
}