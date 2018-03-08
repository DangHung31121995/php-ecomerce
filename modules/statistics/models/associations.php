<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class StatisticsModelsAssociations extends FSModels{

    function addPlan(){
        $row = array();
        $row['outcome_code'] = FSInput::get('outcome_code', '');
        $row['activity_code'] = FSInput::get('activity_code', '');
        $row['activity_title'] = FSInput::get('activity_title', '');
        $row['activity_type'] = FSInput::get('activity_type', 0);
        $row['activity_month'] = FSInput::get('activity_month', 0);
        $row['activity_city'] = FSInput::get('activity_city', 0);
        $row['activity_city'] = FSInput::get('activity_city', 0);
        $row['created_time'] = date('Y-m-d H:i:s');
        return $this->_add($row, 'fs_activity_plan');
    }

    function getWhere(){
        $where = '';
        $city_id = FSInput::get('city_id', 0);
        if($city_id)
            $where .= ' AND city_id = '.$city_id;
        return $where;
    }
    
    function getList(){
        global $db;
        $query = '  SELECT *
                    FROM fs_members
                    WHERE published = 1 AND type = 1 '.$this->getWhere().'
                    ORDER BY id DESC';
        $result = $db->query_limit($query, $this->limit, $this->page);
        return $db->getObjectList();
    }
    
    function getTotal(){
        global $db;
        $query = '  SELECT count(id)
                    FROM fs_members
                    WHERE published = 1 AND type = 1 '.$this->getWhere().'
                    ORDER BY id DESC';
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
    
    function check_capacity_building_exists($program, $code, $quarter, $year){
        global $db;
        $query = '  SELECT id
                    FROM fs_capacity_building
                    WHERE program = '.$program.' AND member_code = \''.$code.'\' AND quarter = \''.$quarter.'\' AND year = \''.$year.'\'
                    LIMIT 1';
        $result = $db->query($query);
        $row = $db->getObject();
        if($row)
            return $row->id;
        else
            return 0;
    }
    
    function check_capacity_building_calculated_exists($program, $code, $quarter, $year, $key){
        global $db;
        $query = '  SELECT id
                    FROM fs_capacity_building_calculated
                    WHERE program = '.$program.' AND member_code = \''.$code.'\' AND quarter = \''.$quarter.'\' AND year = \''.$year.'\' AND `key` = \''.$key.'\'
                    LIMIT 1';
        $result = $db->query($query);
        $row = $db->getObject();
        if($row)
            return $row->id;
        else
            return 0;
    }
    function check_capacity_building_rise($program, $code, $quarter, $year, $key, $value){
        global $db;
        if($quarter == 1){
            $quarter = 4;
            $year--;
        }else
            $quarter--;
        $query = '  SELECT id, value
                    FROM fs_capacity_building_calculated
                    WHERE program = '.$program.' AND member_code = \''.$code.'\' AND quarter = \''.$quarter.'\' AND year = \''.$year.'\' AND `key` = \''.$key.'\'
                    LIMIT 1';
        $result = $db->query($query);
        $row = $db->getObject();
        if($row){
            if(intval($value) > intval($row->value))
                return 1;
            else
                return 0;
        }else
            return 1;
    }
    
    function getCapacityBuilding($member_code = '', $program = 0){
        global $db;
        $query = '  SELECT *
                    FROM fs_capacity_building
                    WHERE member_code = \''.$member_code.'\' AND program = \''.$program.'\''; 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function get_realtime_statistics(){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $cQuarter = ceil(date('m') / 3);
        $query = '  SELECT pa.id AS id, me.type AS type, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON pa.member_code = me.code
                    WHERE activity_month IN ('.$arrMonth[$cQuarter].') AND activity_year = '.date('Y'); 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function get_list_business(){
        global $db;
        $cQuarter = ceil(date('m') / 3);
        $city_id = FSInput::get('city', 0);
        $key = FSInput::get('key', '');
        $query = '  SELECT me.agencies_title AS agencies_title, me.commodity_id AS commodity_id, br.outcome AS outcome
                    FROM fs_business_results AS br
                        INNER JOIN fs_members AS me ON me.code = br.member_code
                    WHERE br.quarter = '.$cQuarter.' AND br.year = '.date('Y').' AND me.city_id = \''.$city_id.'\'
                    ORDER BY br.'.$key.' DESC
                    LIMIT 5'; 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function save_business(){
        $cr_id = FSInput::get('cr_id', 0);
        if($cr_id){ 
            $key = FSInput::get('key', '');
            $lessons_learned = FSInput::get('lessons_learned', '');
            $this->_update(array($key=>$lessons_learned), 'fs_capacity_building', 'id='.$cr_id);
            return $cr_id;
        }else{ 
            $member_code = FSInput::get('member_code', '');
            $key = FSInput::get('key', '');
            $lessons_learned = FSInput::get('lessons_learned', '');
            $cQuarter = ceil(date('m') / 3);
            $row = array(
                'member_code' => $member_code,
                $key => $lessons_learned,
                'quarter' => $cQuarter,
                'year' => date('Y')
            );
            $row['created_time'] = date('Y-m-d H:i:s'); 
            return $this->_add($row, 'fs_capacity_building');
        }
    }
    
    function get_city_results($code){
        global $db;
        $quarter = ceil(date('m') / 3);
        $query = '  SELECT *
                    FROM fs_capacity_building
                    WHERE member_code = \''.$code.'\' AND quarter = \''.$quarter.'\' AND year = \''.date('Y').'\'
                    LIMIT 1'; 
        $result = $db->query($query);
        return $db->getObject();
    }
} 