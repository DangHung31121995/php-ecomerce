<?php 
	class ProductsModelsOrigins extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'origins';
			//$this -> arr_img_paths = array();
			$this -> table_name = 'fs_products_origins';
			$this -> img_folder = 'images/origins/'.date('Y/m/d');
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			parent::__construct();
		}
	}
?>