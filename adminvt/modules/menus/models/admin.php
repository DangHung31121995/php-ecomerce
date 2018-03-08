
<?php 
	class MenusModelsAdmin
	{
		function __construct()
		{
		}
		
		function setQuery()
		{
			
			$query = " SELECT *, parent_id as parent_id
						  FROM fs_menus_admin
						  WHERE published = 1
						  ORDER BY ordering 
						 ";
			return $query;
		}
		
		
		function getMenusAdmin()
		{
			$db = new Mysql_DB();
			$query = $this->setQuery();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
	}
	
?>