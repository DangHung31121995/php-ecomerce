<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class MembersModelsMembers extends FSModels{
    
    function __construct(){
        parent::__construct();
        $this->limit = 15;
    }
    
    function add_members(){
        $row = array();
        $row['type'] = FSInput::get('type', 0);
        $row['city_id'] = FSInput::get('city_id', 0);
        $row['commodity_id'] = FSInput::get('commodity_id', 0);
        $row['email'] = FSInput::get('email', '');
        $row['email_other'] = FSInput::get('email_other', '');
        $row['username'] = FSInput::get('username', '');
        $row['fullname'] = FSInput::get('fullname', '');
        $row['sex'] = FSInput::get('sex', 0);
        $row['agencies_title'] = FSInput::get('agencies_title', '');
        $row['password'] = sha1(FSInput::get('password', ''));
        $row['created_time'] = date('Y-m-d H:i:s');
        $row['published'] = 1;
        $program = FSInput::get('program', array(0), 'array');
        $row['program'] = implode(',', $program);
        $row['some_staff'] = FSInput::get('some_staff', 0);
        $row['address'] = FSInput::get('address', '');
        $row['mobile'] = FSInput::get('mobile', '');
        return $this->_add($row, 'fs_members');
    }
    
    function update_members(){
        $id = FSInput::get('id', 0);
        $row = array();
        $row['type'] = FSInput::get('type', 0);
        $row['city_id'] = FSInput::get('city_id', 0);
        $row['commodity_id'] = FSInput::get('commodity_id', 0);
        $row['email'] = FSInput::get('email', '');
        $row['email_other'] = FSInput::get('email_other', '');
        $row['username'] = FSInput::get('username', '');
        $row['fullname'] = FSInput::get('fullname', '');
        $row['sex'] = FSInput::get('sex', 0);
        $row['agencies_title'] = FSInput::get('agencies_title', '');
        $row['some_staff'] = FSInput::get('some_staff', 0);
        $row['address'] = FSInput::get('address', '');
        $row['mobile'] = FSInput::get('mobile', '');
        $password = FSInput::get('password', '');
        if($password != '')
            $row['password'] = sha1($password);
        $program = FSInput::get('program', array(0), 'array');
        $row['program'] = implode(',', $program);
        $this->_update($row, 'fs_members', 'id='.$id);
        return $id;
    }
    
    function getWhere(){
        $where = '1 = 1';
        $city_id = FSInput::get('city_id', 0);
        if($city_id)
            $where .= ' AND city_id = '.$city_id; 
        $commodity_id = FSInput::get('commodity_id', 0);
        if($commodity_id)
            $where .= ' AND commodity_id = '.$commodity_id; 
        $type = FSInput::get('type', 0);
        if($type)
            $where .= ' AND type = '.$type; 
        $keyword = FSInput::get('keyword', '');
        if($keyword != '')
            $where .= ' AND (code LIKE \'%'.$keyword.'%\' OR fullname LIKE \'%'.$keyword.'%\' OR agencies_title LIKE \'%'.$keyword.'%\')';
        return $where;
    }
    
    function getList(){
        global $db;
        $query = '  SELECT *
                    FROM fs_members
                    WHERE id <> 1 AND '.$this->getWhere().'
                    ORDER BY id DESC';
        $result = $db->query_limit($query, $this->limit, $this->page);
        //$result = $db->query($query);
        return $db->getObjectList();
    }
    
    /**
     * Lấy tổng số tin
     * @return Int
     */
    function getTotal(){
        global $db;
        $query = '  SELECT count(id)
                    FROM fs_members
                    WHERE '.$this->getWhere().'
                    ';
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    } 
    
    /**
     * Lấy tổng số tin
     * @return Int
     */
    function getTotalBusiness(){
        global $db;
        $query = '  SELECT count(id)
                    FROM fs_members
                    WHERE '.$this->getWhere().' AND type = 5';
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    } 
    
    /**
     * Phân trang
     * @return Object
     */ 
    function getPagination($total){
		FSFactory::include_class('Pagination');
		$pagination = new Pagination($this->limit, $total, $this->page);
		return $pagination;
	}
    
    function get_members_json(){
        global $db;
        $sql_where = '';
        $term = FSInput::get('term', '');
        if($term)
            $sql_where = ' AND (`agencies_title` LIKE \'%'.$term.'%\' OR `code` LIKE \'%'.$term.'%\')';
        $query = '  SELECT id, fullname, agencies_title, email, mobile, code, sex 
                    FROM fs_members 
                    WHERE published = 1 '.$sql_where.'
                    ORDER BY id DESC
                    LIMIT 5'; 
        $sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
    }
    
    function getData(){
        global $db;
        $id = FSInput::get('id', 0);
        $query = '  SELECT *
                    FROM fs_members
                    WHERE id = '.$id.'
                    LIMIT 1';
        $result = $db->query($query);
        return $db->getObject();
    }
} 