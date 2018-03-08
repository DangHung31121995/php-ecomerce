<?php 
	class ProductsModelsCategories extends ModelsCategories
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			parent::__construct();
			$this -> limit = 40;
			$this -> type = 'products';
			$this -> table_items = 'fs_'.$this -> type;
			$this -> table_name = 'fs_'.$this -> type.'_categories';
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 1;

			// exception: key (field need change) => name ( key change follow this field)
			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
		}
		
		/*
		 * Show list category of product follow page
		 */
		function get_categories_tree()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			$limit = $this->limit;
			$page  = $this->page?$this->page:1;
			
			$start = $limit*($page-1);
			$end = $start + $limit;
			
			$list_new = array();
			$i = 0;
			foreach ($list as $row){
				if($i >= $start && $i < $end){
					$list_new[] = $row;
				}
				$i ++;
				if($i > $end)
					break;
			}
			return $list_new;
		}
		/*
		 * Select all list category of product
		 */
		function get_categories_tree_all()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			
			return $list;
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
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
					
			}
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*, a.parent_id as parent_id 
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.SQL_FILTER_BY_ADLANG.
						 $ordering. " ";
						
			return $query;
		}
		function get_tablenames(){
			$query = " 	   SELECT DISTINCT(a.table_name) 
						  FROM fs_".$this -> type."_tables AS a 
						 ";
			global $db;
			$db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
	}
	
?>