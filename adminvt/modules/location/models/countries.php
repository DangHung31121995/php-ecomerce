<?php 
	class LocationModelsCountries extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 50;
			$this -> view = 'countries';
			$this -> arr_img_paths = array(array('resized',21,17,'resized_not_crop'));
			$this -> table_name = 'fs_local_countries';
			$this -> img_folder = 'images/countries';
			$this -> check_alias = 0;
			$this -> field_img = 'flag';
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
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
					
			}
			if(!$ordering)
				$ordering .= " ORDER BY  id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' ";
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
		function save(){
			$record_id =  parent::save();
			if($record_id){
				$record = $this -> get_record('id = '.$record_id.'',$this -> table_name);
				// update bảng fs_manufactories
				$this -> update_table_manufactories($record_id,$record);
				// update bảng sp
				$this -> update_table_products($record_id,$record);
				// update bảng mở rộng
				$this -> update_table_products_extend($record_id,$record);
				return $record_id;
			}
			return false;
		}
		
		/*
		 * Update table  table fs_manufactories
		 */
		function update_table_manufactories($cid,$country){
				$row['country_name'] = $country->name;
				$row['country_flag'] = $country->flag;
				return $this -> _update($row,'fs_manufactories',' country_id = '.$cid.' ');
		}
		/*
		 * Update table  table fs_products
		 * Chú ý: toàn bộ các bảng con của sp phải đồng bộ lại hết
		 */
		function update_table_products($cid,$country){
				$row['manufactory_country_name'] = $country->name;
				$row['manufactory_country_flag'] = $country->flag;
				return $this -> _update($row,'fs_products',' manufactory_country_id = '.$cid.' ');
		}
		/*
		 * Update manufactory tại các bảng mở rộng
		 */
		function update_table_products_extend($cid,$manufactory){
			$tables = $this -> get_records(' manufactory_country_id = '.$cid.' ','fs_products',' DISTINCT(tablename) ');
			if(!count($tables))
				return true;
			foreach($tables as $table){
				$table_name = $table -> tablename;
				if(!$table_name)
					continue;
				$row['manufactory_country_name'] = $country->name;
				$row['manufactory_country_flag'] = $country->flag;
				return $this -> _update($row,$table_name,' manufactory_country_id = '.$cid.' ');
			}
		}
	}
	
?>