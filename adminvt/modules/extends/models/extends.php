<?php 
	class ExtendsModelsExtends  extends FSModels
	{
		function __construct()
		{
			$this -> limit = 30;
			$this -> table_name = 'fs_extends';
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
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
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
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		/*
		 * Get extend tables
		 */
		function get_tablenames(){
			$query = " 	   SELECT DISTINCT(a.table_name)
						  FROM fs_extends_tables AS a 
						 ";
			global $db;
			$db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
	}