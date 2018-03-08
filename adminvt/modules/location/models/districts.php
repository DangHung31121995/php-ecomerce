<?php 
	class LocationModelsDistricts extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'districts';
			$this -> table_name = 'fs_local_districts';
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
					$where .= ' AND b.id =  "'.$filter.'" ';
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
			
			$query = " SELECT a.*, b.name as city_name, c.name as country_name
						  FROM 
						  	fs_local_districts AS a
						  	LEFT JOIN fs_local_cities AS b ON a.city_id = b.id
						  	LEFT JOIN fs_local_countries AS c ON b.country_id = c.id
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
			return $query;
		}
		function get_cities_by_country_session(){
			
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_local_cities AS a
						  	WHERE published = 1
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
						  	fs_local_cities AS a
						  	WHERE ".$where."
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
			
		}
		
	}
	
?>