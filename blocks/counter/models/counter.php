<?php
class CounterBModelsCounter{
    function getTotalVisited(){
        global $db;
        $query = '  SELECT vis_count
                    FROM fs_visited
                    WHERE vis_id = 1';
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    }
    
    function getCountOnline(){
        global $db;
        $query = '  SELECT count(au_session_id) AS count
                    FROM fs_users_online';
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    }
} 