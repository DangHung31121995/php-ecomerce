<?php
/*
 * For estore
 */
class EGlobal
{
	
	function __construct(){
	}
	function getConfig(){
		$ename= FSInput::get('ename');
		if(!$ename)
			return;
		$query = " SELECT username,estore_name,estore_url,etemplate,background_id,keywords,estore_intro,id,background_style,background_color,background_repeat,banner,banner_width,banner_height,logo,logo_width,logo_height,copyring,hits,is_guarantee,created_time
				FROM fs_estores
				WHERE estore_url = '$ename' 
				AND published = 1
				AND activated = 1 ";
		global $db;
		$db->query($query);
		$result = $db->getObject();
		return $result;
	}
	
	function get_info_in_estore($field){
		$ename= FSInput::get('ename');
		if(!$ename)
			return;
        $query = " SELECT $field
                FROM fs_estores
                WHERE estore_url = '$ename' 
                AND published = 1
                AND activated = 1 ";
        global $db;
        $db->query($query);
        $result = $db->getResult();
        return $result;
	}
	
	
	/*
	 * update Hit for estore
	 * update fs_estores
	 * Not update fs_estores_hit
	 */
//	function updateHit($eid){
//		if(!$eid)
//			return false;
//		
//	}
	
	/*
	 * Save databsae fs_estores_hit
	 *  NOT update fs_estores
	 */
	function updateHit($eid){
		
		if(!$eid)
			return false;
		$time_space = 15; // 3 hour to update
		$time_unique = 'MINUTE';
		$ip_address=$_SERVER['REMOTE_ADDR'];
		$time = date('Y-m-d H:i:s');
		global $db;
		
		// count
		$sql = " SELECT count(*) FROM fs_estores_hits 
							WHERE ip_address = 	'$ip_address'
							AND estore_id = '$eid'
							AND DATE_SUB('".$time."',
    		               INTERVAL $time_space $time_unique) < visited_time ";
		$db -> query($sql);
		$count = $db -> getResult();
		// insert
		if(!$count){
			$sql = " INSERT INTO fs_estores_hits
							(estore_id,`ip_address`,visited_time)
							VALUES ('$eid','$ip_address','$time')
							";
				$db->query($sql);
				$id = $db->insert();
				
				
				if($id){
					$this -> update_hit_table_estores($eid);
				}
				return $id;
		}		
		return;
	}
	
	function update_hit_table_estores($estore_id){
		// count
		global $db;
		$sql = " UPDATE fs_estores 
				SET hits = hits + 1 
				WHERE  id = '$estore_id' ";
		$db->query($sql);
		$rows = $db->affected_rows();
		return $rows;
	}
	
	/*
	 * get All title of Products
	 */
	function getProductsName()
	{
		global $db;
		$sql = " SELECT name FROM fs_products 
				WHERE published = 1   ";
		$db -> query($sql);
		$list_products_name = $db -> getObjectList();
		return $list_products_name;
	}
	
	function get_background($background_id){
		if(!$background_id)
			return;
		global $db;
		$sql = " SELECT image FROM fs_backgrounds
				WHERE id = $background_id   ";
		$db -> query($sql);
		$background = $db -> getResult();
		return $background;
	}
}