<?php 
	class StatisticModelsStatistic
	{
		var $limit;
		var $page;
		function __construct()
		{
		}
		
		function getData()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
			$sql = $db->query($query);
			$result = $db->getObjectListByKey('name');
			
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
	}
	
?>