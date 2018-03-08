<?php 
	class BackgroundsModelsBackgrounds extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'backgrounds';
			$this -> table_name = 'fs_backgrounds';
			parent::__construct();
		}
		
		function get_data()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function save(){
			$name = FSInput::get('name');
			if(!$name)
				return false;
			$is_default = FSInput::get('is_default',0,'int');
			
			if($is_default){
				$this -> remove_default_all_background();
			}
			$row['is_default'] = $is_default;			
			
			$image = $_FILES["image"]["name"];
			if($image){
				$fsFile = FSFactory::getClass('FsFiles');
				$path = PATH_IMG_BACKGROUND;
				$image = $fsFile -> uploadImage("image", $path ,2000000, '');
				if(!$image)
					return false;
				$row['image'] = 	$image;
			}
			return parent::save($row);
		}
		
		/*
		 * update field "is_default" = 0
		 */
		function remove_default_all_background(){
			$sql = " UPDATE fs_backgrounds
					SET `is_default` = 0 ";
			global $db;
			$db->query($sql);
			$rows = $db->affected_rows();
			return $rows;
		}
		
	}
	
?>