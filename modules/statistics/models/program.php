<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class StatisticsModelsProgram extends FSModels{
    var $start_date;
    var $finish_date;
    
    function __construct(){
        parent::__construct();
        $this->start_date = OPERATING_SYSTEM;
        $this->finish_date = date('Y-m-d H:i:s');
    }
    
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

    function getList(){
        global $db;
        $query = '  SELECT *
                    FROM fs_activity_plan
                    WHERE published = 1
                    ORDER BY id DESC';
        $result = $db->query_limit($query, $this->limit, $this->page);
        return $db->getObjectList();
    }
    
    function get_report_activity(){
        global $db;
        $query = '  SELECT program, activity_type
                    FROM fs_report_activity'; 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function get_report_activity_quarter(){
        global $db;
        $arrMonth = array(
            1 => '01,02,03',
            2 => '04,05,06',
            3 => '07,08,09',
            4 => '10,11,12'
        ); 
        $cQuarter = ceil(date('m') / 3);
        
        $quarter = FSInput::get('quarter', '1/2015');
        $quarter = explode('/', $quarter); 
        
        $arrMonth =  explode( ',',$arrMonth[$quarter[0]]);
        $sqlWhere = '';
        foreach($arrMonth as $m){
            if($sqlWhere == '')
                $sqlWhere = ' start_date LIKE \'%-'.$m.'-%\'';
            else
                $sqlWhere .= ' OR start_date LIKE \'%-'.$m.'-%\'';
        }
        $query = '  SELECT program, activity_type
                    FROM fs_report_activity
                    WHERE '.$sqlWhere; 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    function get_plan_quarter(){
        global $db;
        $arrMonth = array(
            1 => '01,02,03',
            2 => '04,05,06',
            3 => '07,08,09',
            4 => '10,11,12'
        ); 
        $cQuarter = ceil(date('m') / 3);
        $quarter = FSInput::get('quarter', '1/2015');
        $quarter = explode('/', $quarter); 
        $query = '  SELECT activity_type
                    FROM fs_activity_plan
                    WHERE activity_month IN ('.$arrMonth[$quarter[0]].') AND activity_year = '.$quarter[1]; 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function get_city_report_program(){
        global $db;
        $key = FSInput::get('key');
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter); 
        $query = '  SELECT mb.agencies_title, cb.value AS '.$key.'
                    FROM fs_capacity_building_calculated AS cb
                        INNER JOIN fs_members AS mb ON cb.member_code = mb.code
                    WHERE `key` = \''.$key.'\' AND `rise` = 1 AND quarter = '.intval($quarter[0]).' AND year = '.intval($quarter[1]);
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function get_city_outcome_program(){
        global $db;
        $key = FSInput::get('key');
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter); 
        $query = '  SELECT mb.agencies_title, cb.'.$key.', cb.outcome
                    FROM fs_capacity_building AS cb
                        INNER JOIN fs_members AS mb ON cb.member_code = mb.code
                    WHERE `'.$key.'` > 0 AND quarter = '.intval($quarter[0]).' AND year = '.intval($quarter[1]);
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function getActivityByCity($id, $quarter = ''){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        if($quarter == '')
            $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT ap.program AS program, ap.activity_type AS activity_type, ra.budget_reciprocal AS budget_reciprocal
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                    WHERE me.city_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getActivityByActivity($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT ap.program AS program, ap.activity_type AS activity_type, ra.budget_reciprocal AS budget_reciprocal
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                    WHERE ra.commodity_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getActivityByRegion($id, $quarter = ''){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        if($quarter == '')
            $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT ap.program AS program, ap.activity_type AS activity_type, ra.budget_reciprocal AS budget_reciprocal
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                        INNER JOIN fs_local_cities AS lc ON lc.id = me.city_id
                    WHERE lc.region ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getStaffByCity($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT ap.program AS program, ap.activity_type AS activity_type, me.code AS code
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                    WHERE me.type = 3 AND me.city_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getStaffByActivity($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT ap.program AS program, ap.activity_type AS activity_type, me.code AS code
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                    WHERE me.type = 3 AND ra.commodity_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getStaffByRegion($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT ap.program AS program, ap.activity_type AS activity_type, me.code AS code
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                        INNER JOIN fs_local_cities AS lc ON lc.id = me.city_id
                    WHERE me.type = 3 AND lc.region ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getStaffDistinctByCity($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT DISTINCT me.code, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                    WHERE me.type = 3 AND me.city_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getStaffDistinctByActivity($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT DISTINCT me.code, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                    WHERE me.type = 3 AND ra.commodity_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getStaffDistinctByRegion($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT DISTINCT me.code, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                        INNER JOIN fs_local_cities AS lc ON lc.id = me.city_id
                    WHERE me.type = 3 AND lc.region ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getPersonByCity($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT ap.program AS program, ap.activity_type AS activity_type, me.code AS code
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                    WHERE me.type = 5 AND me.city_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getPersonByIndustry($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT ap.program AS program, ap.activity_type AS activity_type, me.code AS code
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                    WHERE me.type = 5 AND ra.commodity_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getPersonByRegion($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT ap.program AS program, ap.activity_type AS activity_type, me.code AS code
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                        INNER JOIN fs_local_cities AS lc ON lc.id = me.city_id
                    WHERE me.type = 5 AND lc.region ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getPersonDistinctByCity($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT DISTINCT me.code, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                    WHERE me.type = 5 AND me.city_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getPersonDistinctByIndustry($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT DISTINCT me.code, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                    WHERE me.type = 5 AND ra.commodity_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getPersonDistinctByRegion($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT DISTINCT me.code, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                        INNER JOIN fs_local_cities AS lc ON lc.id = me.city_id
                    WHERE me.type = 5 AND lc.region ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getActivityByIndustry($id, $quarter = ''){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        if($quarter == '')
            $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT me.type AS type, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                    WHERE ra.commodity_id = '.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function selfDeploymentActivityByCity($id, $quarter =''){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        if($quarter == '')
            $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT me.type AS type, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_members AS me ON ap.member_code = me.code
                    WHERE ap.program = 3 AND me.city_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function selfDeploymentActivityByIndustry($id, $quarter = ''){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        if($quarter == '')
            $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT me.type AS type, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_members AS me ON ap.member_code = me.code
                    WHERE ap.program = 3 AND ra.commodity_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function selfDeploymentActivityByRegion($id, $quarter = ''){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        if($quarter == '')
            $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT me.type AS type, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_members AS me ON ap.member_code = me.code
                        INNER JOIN fs_local_cities AS lc ON lc.id = me.city_id
                    WHERE ap.program = 3 AND lc.region ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function getPersonDistinctSelfDeploymentActivityByCity($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT DISTINCT me.code, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                        INNER JOIN fs_members AS mea ON ap.member_code = mea.code
                    WHERE ap.program = 3 AND me.type = 5 AND mea.city_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getPersonDistinctSelfDeploymentActivityByIndustry($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT DISTINCT me.code, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                        INNER JOIN fs_members AS mea ON ap.member_code = mea.code
                    WHERE ap.program = 3 AND me.type = 5 AND ra.commodity_id ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function getPersonDistinctSelfDeploymentActivityByRegion($id){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter);
        $query = '  SELECT DISTINCT me.code, ap.program AS program, ap.activity_type AS activity_type
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                        INNER JOIN fs_members AS mea ON ap.member_code = mea.code
                        INNER JOIN fs_local_cities AS lc ON lc.id = mea.city_id
                    WHERE ap.program = 3 AND me.type = 5 AND lc.region ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter[0])].') AND ap.activity_year = '.intval($quarter[1]); 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function get_city_synthesis_report($key){
        global $db;
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter); 
        $query = '  SELECT count(id)
                    FROM fs_capacity_building_calculated
                    WHERE `key` = \''.$key.'\' AND `rise` = 1 AND quarter = '.intval($quarter[0]).' AND year = '.intval($quarter[1]);
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    }
    
    function get_export_sales(){
        global $db;
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter); 
        $year = intval($quarter[1]);
        $quarter = intval($quarter[0]);
        
        $query = '  SELECT SUM(br.export_sales)
                    FROM fs_business_results AS br
                    WHERE  br.quarter = '.intval($quarter).' AND br.year = '.intval($year);
        $result = $db->query($query);
        $cTotal = $db->getResult();
        if($quarter == 1){
            $quarter = 4;
            $year--;
        }else
            $quarter--;
        
        $query = '  SELECT SUM(br.export_sales)
                    FROM fs_business_results AS br
                    WHERE  br.quarter = '.intval($quarter).' AND br.year = '.intval($year);
        $result = $db->query($query);
        $total = $db->getResult();
        if($total == 0 || $total >= $cTotal){ 
            return 0;
        }else{ 
            $sub = $cTotal - $total;
            return round(($sub/$cTotal)*100, 0);
        }
    }
    
    function get_new_markets(){
        global $db;
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter); 
        $year = intval($quarter[1]);
        $quarter = intval($quarter[0]);
        
        $query = '  SELECT SUM(br.new_markets)
                    FROM fs_business_results AS br
                    WHERE  br.quarter = '.intval($quarter).' AND br.year = '.intval($year);
        $result = $db->query($query);
        return $db->getResult();
    }
    
    function get_new_clients(){
        global $db;
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter); 
        $year = intval($quarter[1]);
        $quarter = intval($quarter[0]);
        
        $query = '  SELECT SUM(br.new_clients)
                    FROM fs_business_results AS br
                    WHERE  br.quarter = '.intval($quarter).' AND br.year = '.intval($year);
        $result = $db->query($query);
        return $db->getResult();
    }
    
    function get_report_business_cities(){
        global $db;
        $key = FSInput::get('key');
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter); 
        $query = '  SELECT lc.name
                    FROM fs_business_results_calculated_cities AS cc
                        INNER JOIN fs_local_cities AS lc ON lc.id = cc.city_id
                    WHERE `key` = \''.$key.'\' AND quarter = '.intval($quarter[0]).' AND year = '.intval($quarter[1]).'
                    ORDER BY `value` DESC
                    LIMIT 3';
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function get_report_business_industries(){
        global $db;
        $key = FSInput::get('key');
        $quarter = FSInput::get('quarter');
        $quarter = explode('/', $quarter); 
        $query = '  SELECT industry_id
                    FROM fs_business_results_calculated_industries
                    WHERE `key` = \''.$key.'\' AND quarter = '.intval($quarter[0]).' AND year = '.intval($quarter[1]).'
                    ORDER BY `value` DESC
                    LIMIT 3';
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function get_business_results_rise_city($id, $quarter, $year, $key, $percent = 1){
        global $db;
        
        $query = '  SELECT `value`
                    FROM fs_business_results_calculated_cities
                    WHERE `key` = \''.$key.'\' AND city_id = '.$id.' AND quarter = '.intval($quarter).' AND year = '.intval($year);
        $result = $db->query($query);
        $cTotal = $db->getResult();
        
        if($quarter == 1){
            $quarter = 4;
            $year--;
        }else
            $quarter--;
        
        $query = '  SELECT `value`
                    FROM fs_business_results_calculated_cities
                    WHERE `key` = \''.$key.'\' AND city_id = '.$id.' AND quarter = '.intval($quarter).' AND year = '.intval($year);
        $result = $db->query($query);
        $total = $db->getResult();
        
        if($total == 0 || $total >= $cTotal){ 
            return 0;
        }else{ 
            $sub = $cTotal - $total;
            if($percent)
                return round(($sub/$cTotal)*100, 0);
            else
                return $sub;
        }
    }
    
    function get_business_results_rise_industry($id, $quarter, $year, $key, $percent = 1){
        global $db;
        
        $query = '  SELECT `value`
                    FROM fs_business_results_calculated_industries
                    WHERE `key` = \''.$key.'\' AND industry_id = '.$id.' AND quarter = '.intval($quarter).' AND year = '.intval($year);
        $result = $db->query($query);
        $cTotal = $db->getResult();
        
        if($quarter == 1){
            $quarter = 4;
            $year--;
        }else
            $quarter--;
        
        $query = '  SELECT `value`
                    FROM fs_business_results_calculated_industries
                    WHERE `key` = \''.$key.'\' AND industry_id = '.$id.' AND quarter = '.intval($quarter).' AND year = '.intval($year);
        $result = $db->query($query);
        $total = $db->getResult();
        
        if($total == 0 || $total >= $cTotal){ 
            return 0;
        }else{ 
            $sub = $cTotal - $total;
            if($percent)
                return round(($sub/$cTotal)*100, 0);
            else
                return $sub;
        }
    }
    
    function get_business_results_rise_region($id, $quarter, $year, $key, $percent = 1){
        global $db;
        
        $query = '  SELECT rc.`value`
                    FROM fs_business_results_calculated_cities AS rc
                        INNER JOIN fs_local_cities AS lc ON lc.id = rc.city_id
                    WHERE rc.`key` = \''.$key.'\' AND lc.region = '.$id.' AND rc.quarter = '.intval($quarter).' AND rc.year = '.intval($year);
        $result = $db->query($query);
        $cTotal = $db->getResult();
        
        if($quarter == 1){
            $quarter = 4;
            $year--;
        }else
            $quarter--;
        
        $query = '  SELECT rc.`value`
                    FROM fs_business_results_calculated_cities AS rc
                        INNER JOIN fs_local_cities AS lc ON lc.id = rc.city_id
                    WHERE rc.`key` = \''.$key.'\' AND lc.region = '.$id.' AND rc.quarter = '.intval($quarter).' AND rc.year = '.intval($year);
        $result = $db->query($query);
        $total = $db->getResult();
        
        if($total == 0 || $total >= $cTotal){ 
            return 0;
        }else{ 
            $sub = $cTotal - $total;
            if($percent)
                return round(($sub/$cTotal)*100, 0);
            else
                return $sub;
        }
    }
    
    function get_business_results_calculated_city($id, $quarter, $year, $key){
        global $db;
        $query = '  SELECT SUM(br.'.$key.')
                    FROM fs_business_results AS br
                        INNER JOIN fs_members AS mb ON br.member_code = mb.code
                    WHERE mb.city_id = '.$id.' AND br.quarter = '.intval($quarter).' AND br.year = '.intval($year);
        $result = $db->query($query);
        $total = $db->getResult();
		return intval($total);
    }
    
    function get_business_results_calculated_industry($id, $quarter, $year, $key){
        global $db;
        $query = '  SELECT SUM(br.'.$key.')
                    FROM fs_business_results AS br
                        INNER JOIN fs_members AS mb ON br.member_code = mb.code
                    WHERE mb.commodity_id = '.$id.' AND br.quarter = '.intval($quarter).' AND br.year = '.intval($year);
        $result = $db->query($query);
        $total = $db->getResult();
		return intval($total);
    }
    
    function get_business_results_calculated_region($id, $quarter, $year, $key){
        global $db;
        $query = '  SELECT SUM(br.'.$key.')
                    FROM fs_business_results AS br
                        INNER JOIN fs_members AS mb ON br.member_code = mb.code
                        INNER JOIN fs_local_cities AS lc ON lc.id = mb.city_id
                    WHERE lc.region = '.$id.' AND br.quarter = '.intval($quarter).' AND br.year = '.intval($year);
        $result = $db->query($query);
        $total = $db->getResult();
		return intval($total);
    }
    
    function get_lessons_learned(){
        global $db;
        
        $where = '';
        $city_id = FSInput::get('activity_city', 0);
        if($city_id)
            $where .= ' AND mb.city_id = '.$city_id;
        
        $activity_type = FSInput::get('activity_type', 0);
        if($activity_type)
            $where .= ' AND ra.activity_type = '.$activity_type;
        
        $commodity_id = FSInput::get('commodity_id', 0);
        if($commodity_id)
            $where .= ' AND ra.commodity_id = '.$commodity_id;
        $program = FSInput::get('program', 1);     
        $query = '  SELECT ra.activity_type AS activity_type, ra.commodity_id AS commodity_id, ra.number_participants AS number_participants, ra.number_participants_females AS number_participants_females, ra.booth_number AS booth_number, ra.number_visitors AS number_visitors, ra.number_transactions AS number_transactions,
                        ao.outcome AS outcome, 
                        mb.city_id AS city_id
                    FROM fs_report_activity AS ra
                        INNER JOIN fs_report_activity_outcome AS ao ON ra.id = ao.activity_id
                        INNER JOIN fs_members AS mb ON ra.member_code = mb.code
                    WHERE ra.program = '.$program.' AND ao.activity_type = \'after\''.$where; //echo $query;
        // $result = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function get_list_programs(){
        
        $start_date = explode('/', FSInput::get('start_date', date('d/m/Y')));
        $start_date = @$start_date[2].'-'.@$start_date[1].'-'.@$start_date[0].' 00:00:00';
        
        $finish_date = explode('/', FSInput::get('finish_date', date('d/m/Y')));
        $finish_date = $finish_date[2].'-'.$finish_date[1].'-'.$finish_date[0].' 23:59:59';
        
        $program = FSInput::get('program', 1);
        
        global $db;
        $query = '  SELECT ra.*, ap.outcome_code AS outcome_code, ap.activity_code AS activity_code
                    FROM fs_report_activity AS ra
                        LEFT JOIN fs_activity_plan AS ap ON ap.id = ra.activity_plan_id
                    WHERE ra.published = 1 AND ra.program = '.$program.' AND (ra.start_date BETWEEN \''.$start_date.'\' AND \''.$finish_date.'\') 
                    ORDER BY ra.id DESC'; 
        $result = $db->query($query); 
        return $db->getObjectList();
    }
    
    function get_members_edp_logframe(){
        global $db;
        $query = '  SELECT mb.id, mb.code, mb.agencies_title, mb.type, mb.commodity_id, mb.edp, lc.region
                    FROM fs_members AS mb
                        LEFT JOIN fs_local_cities AS lc ON lc.id = mb.city_id
                    WHERE type = 5';
        $result = $db->query($query);
        $list = $db->getObjectListByKey('id');
        if($list){
            $arrCode = array();
            $listIds = '\'-1\'';
            foreach($list as $item){
                $list[$item->id]->outcome = array();
                $listIds .= ',\''.$item->code.'\'';
                $arrCode[$item->code] = $item->id;
            }
            
            $query = '  SELECT member_code, year, export_sales, sales, new_markets, new_clients 
                        FROM fs_business_results
                        WHERE quarter = 4 AND member_code IN ('.$listIds.')';
            $result = $db->query($query);
            $listOutcome = $db->getObjectList();
            foreach($listOutcome as $item){
                $list[$arrCode[$item->member_code]]->outcome[$item->year] = array(
                    'export_sales' => $item->export_sales,
                    'sales' => $item->sales,
                    'new_markets' => $item->new_markets,
                    'new_clients' => $item->new_clients
                );
            }
        }
        return $list;
    }
    
    function get_other_plan_logframe(){
        global $db;
        $query = '  SELECT ap.id, ap.activity_year, ap.activity_type, lc.region
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_members AS mb ON mb.code = ap.member_code
                        INNER JOIN fs_local_cities AS lc ON lc.id = mb.city_id
                    WHERE ap.program = 3';
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function get_xttm_open_new_logframe(){
        global $db;
        $query = '  SELECT cb.xttm_open_new, cb.year, cb.quarter, lc.region
                    FROM fs_capacity_building AS cb
                        INNER JOIN fs_members AS mb ON mb.code = cb.member_code
                        INNER JOIN fs_local_cities AS lc ON lc.id = mb.city_id
                    WHERE cb.quarter = 4';
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function get_activity_logframe(){
        global $db;
        $query = '  SELECT ra.id, ra.created_time, ra.start_date,activity_address, ra.title, ra.number_center, ra.number_business_staff, ra.number_businesses, ra.number_vietrade, ra.commodity_id, ra.activity_type, lc.region 
                    FROM fs_report_activity AS ra
                        LEFT JOIN fs_members AS mb ON mb.code = ra.member_code
                        LEFT JOIN fs_local_cities AS lc ON lc.id = mb.city_id
                    WHERE ra.published = 1 AND (ra.start_date BETWEEN \''.$this->start_date.'\' AND \''.$this->finish_date.'\') ';
        $result = $db->query($query);
        $list = $db->getObjectListByKey('id');
        if($list){
            $listIds = '-1';
            foreach($list as $item){
                $list[$item->id]->outcome = array();
                $listIds .= ','.$item->id;
            }
            
            $query = '  SELECT * 
                        FROM fs_report_activity_outcome
                        WHERE activity_id IN ('.$listIds.')';
            $result = $db->query($query);
            $listOutcome = $db->getObjectList();
            foreach($listOutcome as $item){
                $list[$item->activity_id]->outcome[$item->activity_type] = $item->outcome;
            }
        }
        return $list;
    }
    
    function get_training_organised_by_TPOs_TSIs(){
        global $db;
        $query = '  SELECT ra.id, ra.created_time, ra.start_date, ra.activity_address, ra.title, ra.number_center, ra.number_business_staff, ra.number_businesses, ra.number_vietrade, ra.commodity_id, ra.activity_type, lc.region, mb.agencies_title 
                    FROM fs_report_activity AS ra
                        INNER JOIN fs_activity_plan AS ap ON ra.activity_plan_id = ap.id
                        LEFT JOIN fs_members AS mb ON mb.code = ra.member_code
                        LEFT JOIN fs_local_cities AS lc ON lc.id = mb.city_id
                    WHERE ra.published = 1 AND ra.activity_type = 10 AND ap.outcome_code = \'3\' AND (ra.start_date BETWEEN \''.$this->start_date.'\' AND \''.$this->finish_date.'\') ';
        $result = $db->query($query);
        $list = $db->getObjectListByKey('id');
        if($list){
            $listIds = '-1';
            foreach($list as $item){
                $list[$item->id]->outcome = array();
                $listIds .= ','.$item->id;
            }
            
            $query = '  SELECT * 
                        FROM fs_report_activity_outcome
                        WHERE activity_id IN ('.$listIds.')';
            $result = $db->query($query);
            $listOutcome = $db->getObjectList();
            foreach($listOutcome as $item){
                $list[$item->activity_id]->outcome[$item->activity_type] = $item->outcome;
            }
        }
        return $list;
    }
    
    function get_training_organised_by_PROMOCEN(){
        global $db;
        $query = '  SELECT ra.id, ra.created_time, ra.start_date, ra.activity_address, ra.title, ra.number_center, ra.number_business_staff, ra.number_businesses, ra.number_vietrade, ra.commodity_id, ra.activity_type, lc.region, mb.agencies_title 
                    FROM fs_report_activity AS ra
                        INNER JOIN fs_activity_plan AS ap ON ra.activity_plan_id = ap.id
                        INNER JOIN fs_members AS mb ON mb.code = ra.member_code
                        LEFT JOIN fs_local_cities AS lc ON lc.id = mb.city_id
                    WHERE ra.published = 1 AND mb.id = 195 AND ap.outcome_code = \'3\' AND (ra.start_date BETWEEN \''.$this->start_date.'\' AND \''.$this->finish_date.'\') ';
        $result = $db->query($query);
        $list = $db->getObjectListByKey('id');
        if($list){
            $listIds = '-1';
            foreach($list as $item){
                $list[$item->id]->outcome = array();
                $listIds .= ','.$item->id;
            }
            
            $query = '  SELECT * 
                        FROM fs_report_activity_outcome
                        WHERE activity_id IN ('.$listIds.')';
            $result = $db->query($query);
            $listOutcome = $db->getObjectList();
            foreach($listOutcome as $item){
                $list[$item->activity_id]->outcome[$item->activity_type] = $item->outcome;
            }
        }
        return $list;
    }
} 