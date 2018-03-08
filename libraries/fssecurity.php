<?php
class FSSecurity
{
	function __construct()
	{
		
	}
	function checkLogin()
	{
		if(!isset($_SESSION['username']))
		{
			$Itemid = 11;
			$url = FSRoute::_("index.php?module=users&task=login&Itemid=$Itemid");
			$msg = FSText :: _("Bạn phải đăng nhập để sử dụng tính năng này");
			setRedirect($url,$msg,'error');
		}
		else 
			return true;
	}
	
	function check_permission($module,$view='',$task=''){
		$this -> checkLogin();
		if(!$module)
			return;
		if(!$view)
			$view = $module;
		if(!$task)
			$task = 'display';
		if(($module == 'users' && $view == 'user' ) || $module == 'home')
			return true;
		
		global $db;
		$user_id = $_SESSION['user_id'];
		if($_SESSION['user_default'])
			return true;
		
		// get task_id
		$sql = 'SELECT id,`trigger` FROM fs_permission_tasks WHERE module = "'.$module.'" AND `view` = "'.$view.'" AND task = "'.$task.'"' ;
		$db->query($sql);
		$result = $db->getObject();
		if(!$result)
			return true;
		$task_id = $result -> id;
		if($result -> trigger){
			$sql_tr = 'SELECT id FROM fs_permission_tasks WHERE module = "'.$module.'" AND view = "'.$view.'" AND task = "'.$result -> trigger.'"' ;
			$db->query($sql_tr);
			$result_tr = $db->getObject();
			if($result_tr)
				$task_id .= ','.$result_tr -> id;
		}
		
		$sql_permission = 'SELECT Max(permission) FROM fs_members_permission WHERE member_id = "'.$user_id.'" AND task_id IN ('.$task_id.')' ;
		$db->query($sql_permission);
		$permission = $db->getResult();
		return $permission;
	}
}