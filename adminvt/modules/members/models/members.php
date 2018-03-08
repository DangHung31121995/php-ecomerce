<?php 
	class MembersModelsMembers extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$limit = 100;
			$this -> view = 'members';
			$this->limit = $limit;
			$this -> table_name = 'fs_members';
			parent::__construct();
		}
		
		function getMembers()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			if(	isset($_POST['filter'])){
				$_SESSION[$this -> prefix.'filter']  =  $_POST['filter'] ;
			}
		
			return $result;
		}
		function get_member_info($start,$end){
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
			$sql = $db->query_limit_export($query,$start,$end);
			$result = $db->getObjectList();
			if(	isset($_POST['filter'])){
				$_SESSION[$this -> prefix.'filter']  =  $_POST['filter'] ;
			}
		
			return $result;
		}
		
		
		function setQuery()
		{
			// ordering
			$ordering = "";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			$where = "  WHERE 1=1 ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'])){
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				if($keysearch){
					$where .= " AND ( a.full_name LIKE '%".$keysearch."%' OR a.username LIKE '%".$keysearch."%'
										 )
										";
				}
			}
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter < 2){
					$where .= " AND published = $filter ";
				}
			}
//			
//			if(isset($_SESSION[$this -> prefix.'city'] ))
//			{
//				if($_SESSION[$this -> prefix.'city'] )
//				{
//					$city_id = $_SESSION[$this -> prefix.'city'];
//					$where .= " AND a.city_id  =".$city_id." ";
//				}
//			}
//			if(isset($_SESSION[$this -> prefix.'published'] ))
//			{
//				$status= $_SESSION[$this -> prefix.'published'];
//				switch($status)
//				{
//					case 'activated':
//						$where .= " AND a.published = 1 ";
//						break;	
//					case 'unactivated':
//						$where .= " AND a.published = 0 ";
//						break;
//				}
//			}
			
			$query = " SELECT *
						  FROM 
						   fs_members AS a
						 $where
						 $ordering 
						 ";
			return $query;
		}
		
		function getTotal()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$total = $db->getTotal();
			return $total;
		}
		
		
		function getPagination()
		{
			$total = $this->getTotal();			
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
		
		/**************************** end EXPORT *********************/
		/*
		 * Select a Members by Id
		 */
		function getMemberById()
		{
			$ids = FSInput::get('id',array(0),'array');
			$id = $ids[0];
			if(!$id)
				$id = 0;
			$query = " SELECT a.*
						  FROM fs_members AS a
						  WHERE a.id = $id ";
			
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
		function getCity()
		{
			global $db ;
			$sql = " SELECT id, name FROM fs_local_cities ";
			$db->query($sql);
			return $db->getObjectList();
		}
		
		
		
		/******************************** SAVE *****************************************/
		/*
		 * 
		 * Save
		 */
		function save(){
			$username = FSInput::get('username');
			if(!$username)
				return false;

			$image = $_FILES["avatar"]["name"];
			if($image){
				
				// remove old if exists record and img
				$id = FSInput::get('id',0,'int');
				if($id){
					
					$img_paths = array();
					$img_paths[] = PATH_IMG_MEMBER_AVATAR.'original'.DS;
					$img_paths[] = PATH_IMG_MEMBER_AVATAR.'resized'.DS;
					$this -> remove_image($id,$img_paths);
				}
				$fsFile = FSFactory::getClass('FsFiles');
				// upload
				$path = PATH_IMG_MEMBER_AVATAR.'original'.DS;
				$image = $fsFile -> uploadImage("avatar", $path ,2000000, '');
				if(!$image){
					Errors::_(" Not upload successful images");
					return false;
				}
					
					
				
				// rezise to standart : 300x175
				$path_resize = PATH_IMG_MEMBER_AVATAR.'resized'.DS;
				if(!$fsFile ->resize_image($path.$image, $path_resize.$image,IMG_MEMBER_AVATAR_WIDTH, IMG_MEMBER_AVATAR_HEIGHT))
				{
					Errors::_(" Not resize successful images");
					return false;
				}
				$row['image'] = 	$image;
			}
			$edit_pass = FSInput::get('edit_pass');
			if($edit_pass){
				$row['password'] = md5(FSInput::get("password1"));
			}
			return parent::save($row);
		}
		
		
		function remove(){
			$img_paths = array();
			$img_paths[] = PATH_IMG_MEMBER_AVATAR.'original'.DS;
			$img_paths[] = PATH_IMG_MEMBER_AVATAR.'resized'.DS;
			return parent::remove('avatar',$img_paths);
		}

		/*************** ADDRESS *************/
		/*
		 * get list District
		 * default: Ha Noi
		 */
		function getDistricts($city_id = '1473')
		{
			if(!$city_id)
				$city_id = '1473';
			global $db ;
			$sql = " SELECT id, name FROM fs_local_districts
					WHERE city_id = $city_id ";
			$db->query($sql);
			return $db->getObjectList();
		}
		
		/*
		 * Createa folder when create user
		 */
		function create_folder_upload($id){
			$fsFile = FSFactory::getClass('FsFiles','');
			$path = PATH_BASE.'uploaded'.DS.'estores'.DS.$id;
			return $fsFile->create_folder($path);
		}
		
		function get_level(){
			$sql = " SELECT * FROM fs_members_level ";
			global $db ;
			$db->query($sql);
			return $db->getObjectListByKey('level');
		}
	}
	
	
?>