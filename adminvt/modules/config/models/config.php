<?php 
	class ConfigModelsConfig   extends FSModels
	{

		function __construct()
		{
			parent::__construct();
		}
		
		function getData()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
			$sql = $db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		function setQuery()
		{
			$query = " SELECT *
						  FROM 
						  	fs_config
						  WHERE published = 1
						  ORDER BY id
						 ";
						
			return $query;
		}
		
		/*
		 * 
		 * Save
		 */
		function save()
		{
			$data = $this->getData();
			global $db;
			foreach($data as $item)
			{
                if($item->name == 'license')
                    continue;
				if($item->data_type == 'editor')
					$value =htmlspecialchars_decode(FSInput::get("$item->name"));
				else 
					$value = FSInput::get("$item->name");
				
				$sql = " UPDATE fs_config SET 
						value = '$value'
						WHERE name = '$item->name' ";
				$db->query($sql);
				$rows = $db->affected_rows();
			}
			return true;
			
		}
		
		
	}
	
?>