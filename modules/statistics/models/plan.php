<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class StatisticsModelsPlan extends FSModels{
    function __construct(){
        parent::__construct();
        $this->limit = 15;
    }
    
    function addPlan(){
        global $user;
        $row = array();
        $row['member_code'] = $user->userInfo->code;
        $row['outcome_code'] = FSInput::get('outcome_code', '');
        $row['activity_code'] = FSInput::get('activity_code', '');
        $row['activity_title'] = FSInput::get('activity_title', '');
        $row['activity_address'] = FSInput::get('activity_address', '');
        $row['activity_type'] = FSInput::get('activity_type', 0);
        $row['program'] = FSInput::get('program', 1);
        $row['activity_month'] = FSInput::get('activity_month', 0);
        $row['activity_year'] = FSInput::get('activity_year', 0);
        $row['activity_city'] = FSInput::get('activity_city', 0);
        $row['budget_expected'] = FSInput::get('budget_expected', 0);
        $row['created_time'] = date('Y-m-d H:i:s');
        return $this->_add($row, 'fs_activity_plan');
    }

    function updatePlan(){
        $data_id = FSInput::get('data_id', 0);
        $row = array();
        $row['outcome_code'] = FSInput::get('outcome_code', '');
        $row['activity_code'] = FSInput::get('activity_code', '');
        $row['activity_title'] = FSInput::get('activity_title', '');
        $row['activity_address'] = FSInput::get('activity_address', '');
        $row['activity_type'] = FSInput::get('activity_type', 0);
        $row['program'] = FSInput::get('program', 1);
        $row['activity_month'] = FSInput::get('activity_month', 0);
        $row['activity_year'] = FSInput::get('activity_year', 0);
        $row['activity_city'] = FSInput::get('activity_city', 0);
        $row['budget_expected'] = FSInput::get('budget_expected', 0);
        return $this->_update($row, 'fs_activity_plan', 'id='.$data_id);
    }
    
    function getWhere(){
        global $user;
        
        $where = '';
        $sprogram = FSInput::get('sprogram', 0);
        if($sprogram)
            $where .= ' AND program = '.$sprogram; 
            
        $sactivity_type = FSInput::get('sactivity_type', 0);
        if($sactivity_type)
            $where .= ' AND activity_type = '.$sactivity_type; 
        
        $sactivity_month = FSInput::get('sactivity_month', 0);
        if($sactivity_month)
            $where .= ' AND activity_month = '.$sactivity_month; 
        
        $sactivity_month = FSInput::get('sactivity_month', 0);
        if($sactivity_month)
            $where .= ' AND activity_month = '.$sactivity_month; 
        
        $my_plan = FSInput::get('my_plan', 0);
        if($my_plan && $user->userID){
            $where .= ' AND member_code = \''.$user->userInfo->code.'\'';
        }   
             
        return $where;
    }
    
    function getList(){
        global $db;
        $query = '  SELECT *
                    FROM fs_activity_plan
                    WHERE published = 1 '.$this->getWhere().'
                    ORDER BY id DESC';
        $result = $db->query_limit($query, $this->limit, $this->page);
        return $db->getObjectList();
    }
    
    /**
     * Lấy tổng số tin
     * @return Int
     */
    function getTotal(){
        global $db;
        $query = '  SELECT count(id)
                    FROM fs_activity_plan
                    WHERE published = 1 '.$this->getWhere().'
                    ';
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
} 