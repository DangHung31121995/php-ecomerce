<?php 
	class ProductsModelsFprice extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'fprice';
			$this -> table_name = 'fs_products_filter_price';
			$this -> check_alias = 0;
			parent::__construct();
		}
	}
?>