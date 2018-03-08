<?php
//Get Seccsion
$value = "";
if(isset($_SESSION["visit"])) $value = $_SESSION["visit"];
//Write hits count
if($value != 1){
	$db->query("UPDATE fs_visited SET vis_count = vis_count + 1 WHERE vis_id = 1");
	unset($db_hit);
	$_SESSION["visit"] = 1;
}
$visited_timeout = 15 * 60; //
$last_visited_time = getdate();
$last_visited_time = $last_visited_time[0];
//Kiem tra co session_id hay ko, neu co
if (session_id() != ""){
	$query = "	REPLACE INTO fs_users_online(au_session_id,au_last_visit) 
				VALUES('" . session_id() . "'," . $last_visited_time . ")";
	$db->query($query);		  
}
// Delete timeout
$query = "	DELETE FROM fs_users_online
			WHERE au_last_visit < " . ($last_visited_time - $visited_timeout);
$db->query($query);	
/* Số người truy cập */
$result = $db->query('SELECT vis_count FROM fs_visited WHERE vis_id = 1');
$totalVisited = $db->getResult();
/* Số người online */
$db->query("SELECT count(au_session_id) AS count FROM fs_users_online");
$totalOnline = $db->getResult();
/* Số thành viên */
$query = '  SELECT count(id) FROM fs_members WHERE published = 1';
$result = $db->query($query);
$totalMember = $db->getResult();
/* Số tham ra lập báo cáo */
$query = '  SELECT COUNT(DISTINCT member_code) FROM fs_report_activity WHERE published = 1';
$result = $db->query($query);
$totalMemberActivity = $db->getResult();