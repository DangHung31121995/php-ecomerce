<?php 
	class LocationModelsCities extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 50;
			$this -> view = 'cities';
			$this -> table_foreign = 'fs_local_countries';
			$this -> table_name = 'fs_local_cities';
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, id DESC ";
					
			}
			if(!$ordering)
				$ordering .= " ORDER BY  id DESC ";
			
			$where = "  ";
				if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.country_id =  '.$filter.' ';
				}
			}	
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
        
        
		
	}
	
?>