<?php 
	class LocationModelsCommune extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'commune';
			$this -> table_name = 'fs_commune';
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND c.id =  "'.$filter.'" ';
				}
				if(isset($_SESSION[$this -> prefix.'filter1'])){
					$filter = $_SESSION[$this -> prefix.'filter1'];
					if($filter){
						$where .= ' AND b.id =  "'.$filter.'" ';
					}
					if(isset($_SESSION[$this -> prefix.'filter2'])){
						$filter = $_SESSION[$this -> prefix.'filter2'];
						if($filter){
							$where .= ' AND d.id =  "'.$filter.'" ';
						}
					}
				}
			}
			if(!$ordering)
				$ordering .= " ORDER BY  id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*, b.name as city_name, c.name as country_name, d.name as district_name
						  FROM 
						  	".$this -> table_name." AS a
						  	LEFT JOIN fs_cities AS b ON a.city_id = b.id
						  	LEFT JOIN fs_countries AS c ON a.country_id = c.id
						  	LEFT JOIN fs_districts AS d ON a.district_id = d.id
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
			return $query;
		}
		function get_cities_by_country_session(){
			$where = ' 1 = 2 ';
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where = '  country_id =  "'.$filter.'" ';
				}
			}
			
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_cities AS a
						  	WHERE ".$where."
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
		function get_districts_by_city_session(){
			$where = ' 1 = 2 ';
			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					$where = '  city_id =  "'.$filter.'" ';
				}
			}
			
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_districts AS a
						  	WHERE ".$where."
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
		function get_cities_by_country_id($country_id){
			if(!$country_id)
				return;
			$where = '  country_id =  "'.$country_id.'" ';
			
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_cities AS a
						  	WHERE ".$where."
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
			
		}
		function get_districts_by_city_id($city_id){
			if(!$city_id)
				return;
			$where = '  city_id =  "'.$city_id.'" ';
			
				global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_districts AS a
						  	WHERE ".$where."
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
		
	}
	
?>