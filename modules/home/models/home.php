<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class HomeModelsHome extends FSModels{
    
    function get_business_results_by_region($region, $quarter, $year, $key){
        global $db;
        $query = '  SELECT SUM(br.'.$key.')
                    FROM fs_business_results AS br
                        INNER JOIN fs_members AS me ON me.code = br.member_code
                        INNER JOIN fs_local_cities AS lc ON lc.id = me.city_id
                    WHERE lc.region = '.$region.' AND br.quarter = '.intval($quarter).' AND br.year = '.intval($year);
        $result = $db->query($query);
        return intval($db->getResult());
    }
    
    function get_business_results_by_industry($industry, $quarter, $year, $key){
        global $db;
        $query = '  SELECT SUM(br.'.$key.')
                    FROM fs_business_results AS br
                        INNER JOIN fs_members AS me ON me.code = br.member_code
                    WHERE me.commodity_id = '.$industry.' AND br.quarter = '.intval($quarter).' AND br.year = '.intval($year);
        $result = $db->query($query);
        return intval($db->getResult());
    }
    
    function get_statistics_cities_region($id, $quarter, $year){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $query = '  SELECT COUNT(me.id)
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON ra.member_code = me.code
                        INNER JOIN fs_local_cities AS lc ON lc.id = me.city_id
                    WHERE me.type = 3 AND lc.region ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter)].') AND ap.activity_year = '.intval($year); 
        $result = $db->query($query); 
        return intval($db->getResult());
    }
    
    function get_statistics_business_region($id, $quarter, $year){
        global $db;
        $arrMonth = array(
            1 => '1,2,3',
            2 => '4,5,6',
            3 => '7,8,9',
            4 => '10,11,12'
        ); 
        $query = '  SELECT COUNT(me.id)
                    FROM fs_activity_plan AS ap
                        INNER JOIN fs_report_activity AS ra ON ap.id = ra.activity_plan_id
                        INNER JOIN fs_activity_participants AS pa ON ra.id = pa.activity_id
                        INNER JOIN fs_members AS me ON pa.member_code = me.code
                        INNER JOIN fs_local_cities AS lc ON lc.id = me.city_id
                    WHERE me.type = 5 AND lc.region ='.$id.' AND ap.activity_month IN ('.$arrMonth[intval($quarter)].') AND ap.activity_year = '.intval($year); 
        $result = $db->query($query); 
        return intval($db->getResult());
    }
} 