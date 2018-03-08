<?php
class FSSecurity
{
	function __construct(){
		
	}
	function check_permission($module,$view='',$task=''){
		if(!$module)
			return;
		if(!$view)
			$view = $module;
		if(!$task)
			$task = 'display';
		if($module == 'users' && $view == 'log' && $task == 'logout' )
			return true;
			
		if(!isset($_SESSION['ad_userid']))
			return false;
			
		global $db;
		$user_id = $_SESSION['ad_userid'];
		// get groupid
		$sql_group = 'SELECT groupid as group_id FROM fs_users_groups WHERE userid = '.$user_id ;
		$db->query($sql_group);
		$result = $db->getObjectList();
		if(!count($result))
			return ;
		$str_group_ids= '';
		for($i = 0; $i < count($result);  $i ++ ){	
			if($result[$i]->group_id == 1) // administrator group
				return true;
			if($i > 0)
				$str_group_ids .= ',';
			$str_group_ids .= 	$result[$i]->group_id;
		}
		if(!$str_group_ids)	
			return;
			
		// get permission follow module
		$query = ' SELECT max(a.permission) 
					FROM fs_groups_permission AS a 
					WHERE a.module_type_id = 
						( SELECT id FROM fs_modules_admin WHERE module_type =\''.$module.'\' )
						AND a.group_id IN ('.$str_group_ids.') ';
		$db->query($query);
		$result = $db->getResult();
		// not set: return true;
		if(!isset($result))
			return true;
		if(!$result)
			return false;
		// view	
		if(($task == 'display' || $task =='detail' || $task == 'edit' || $task== 'add') && $result < 3)
			return false;
		if(($task == 'save' || $task =='published' || $task == 'unpublished' || $task== 'apply' || $task== 'add' || $task== 'save_new' ||  $task== 'save_all' ) && $result < 5)
			return false;
		if(($task == 'remove' || $task =='delete' || $task == 'del' ) && $result < 7)
			return false;
			
		return true;
	}
}