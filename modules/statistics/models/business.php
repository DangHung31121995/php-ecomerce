<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class StatisticsModelsBusiness extends FSModels{

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
        $commodity_id = FSInput::get('commodity_id', 0);
        if($commodity_id)
            $where .= ' AND commodity_id = '.$commodity_id; 
        $keyword = FSInput::get('keyword', '');
        if($keyword != '')
            $where .= ' AND (code LIKE \'%'.$keyword.'%\' OR agencies_title LIKE \'%'.$keyword.'%\')'; 
        return $where;
    }
    
    function getList(){
        global $db;
        $query = '  SELECT *
                    FROM fs_members
                    WHERE published = 1 AND type = 5 '.$this->getWhere().'
                    ORDER BY id DESC';
        $result = $db->query_limit($query, $this->limit, $this->page);
        return $db->getObjectList();
    }
    
    function getTotal(){
        global $db;
        $query = '  SELECT count(id)
                    FROM fs_members
                    WHERE published = 1 AND type = 5 '.$this->getWhere().'
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
    
    function getIndustrier($commodity_id = 0, $city_id = 100){
        global $db;
        $query = '  SELECT *
                    FROM fs_members
                    WHERE commodity_id = '.$commodity_id.' AND city_id = '.$city_id.' AND type IN (3,4)
                    LIMIT 1';
        $result = $db->query($query);
        return $db->getObject();
    }
    
    function getReportActivity($program = 0){
        global $db;
        $query = '  SELECT *
                    FROM fs_report_activity
                    WHERE program = '.$program.' AND status = 1
                    LIMIT 1';
        $result = $db->query($query);
        return $db->getObject();
    }
    
    function check_business_results_exists($code, $quarter , $year){
        global $db;
        $query = '  SELECT id
                    FROM fs_business_results
                    WHERE member_code = \''.$code.'\' AND quarter = \''.$quarter.'\' AND year = \''.$year.'\'
                    LIMIT 1';
        $result = $db->query($query);
        $row = $db->getObject();
        if($row)
            return $row->id;
        else
            return 0;
    }
    
    function getActivitiesByBusiness($code){
        global $db;
        $query = '  SELECT ra.id, ra.start_date, ra.activity_type, ra.activity_address, ra.start_date
                    FROM fs_report_activity AS ra
                        INNER JOIN fs_activity_participants AS ap ON ra.id = ap.activity_id
                    WHERE ra.published = 1 AND ap.member_code = \''.$code.'\'
                    GROUP BY ra.id'; 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function check_activity_business_exists($member_code, $activity_id , $activity_type){
        global $db;
        $query = '  SELECT id
                    FROM fs_report_activity_business
                    WHERE member_code = \''.$member_code.'\' AND activity_id = \''.$activity_id.'\' AND activity_type = \''.$activity_type.'\'
                    LIMIT 1'; 
        $result = $db->query($query);
        $row = $db->getObject();
        if($row)
            return $row->id;
        else
            return 0;
    }
    
    function getActivitiesBusinessOutcome($member_code = '', $activity_id = 0){
        global $db;
        $query = '  SELECT *
                    FROM fs_report_activity_business
                    WHERE member_code = \''.$member_code.'\' AND activity_id = \''.$activity_id.'\''; 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function get_report_business(){
        global $db;
        $key = FSInput::get('key');
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter); 
        $query = '  SELECT mb.agencies_title, br.'.$key.'
                    FROM fs_business_results AS br
                        INNER JOIN fs_members AS mb ON br.member_code = mb.code
                    WHERE `'.$key.'` > 0 AND quarter = '.intval($quarter[0]).' AND year = '.intval($quarter[1]).'
                    ORDER BY '.$key.' DESC
                    LIMIT 10';
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function check_business_results_calculated_city_exists($id, $quarter , $year, $key){
        global $db;
        $query = '  SELECT id
                    FROM fs_business_results_calculated_cities
                    WHERE city_id = \''.$id.'\' AND quarter = \''.$quarter.'\' AND year = \''.$year.'\' AND `key` = \''.$key.'\'
                    LIMIT 1'; 
        $result = $db->query($query);
        $row = $db->getObject();
        if($row)
            return $row->id;
        else
            return 0;
    }
    
    function get_business_results_calculated_city($id, $quarter , $year, $key){
        global $db;
        $query = '  SELECT SUM(br.'.$key.')
                    FROM fs_business_results AS br
                        INNER JOIN fs_members AS mb ON br.member_code = mb.code
                    WHERE mb.city_id = '.$id.' AND br.quarter = '.intval($quarter).' AND br.year = '.intval($year);
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    }
    
    function check_business_results_calculated_industry_exists($id, $quarter , $year, $key){
        global $db;
        $query = '  SELECT id
                    FROM fs_business_results_calculated_industries
                    WHERE industry_id = \''.$id.'\' AND quarter = \''.$quarter.'\' AND year = \''.$year.'\' AND `key` = \''.$key.'\'
                    LIMIT 1'; 
        $result = $db->query($query);
        $row = $db->getObject();
        if($row)
            return $row->id;
        else
            return 0;
    }
    
    function get_business_results_calculated_industry($id, $quarter , $year, $key){
        global $db;
        $query = '  SELECT SUM(br.'.$key.')
                    FROM fs_business_results AS br
                        INNER JOIN fs_members AS mb ON br.member_code = mb.code
                    WHERE mb.commodity_id = '.$id.' AND br.quarter = '.intval($quarter).' AND br.year = '.intval($year);
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    }
    
    
} 