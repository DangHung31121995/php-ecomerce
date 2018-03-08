<?php
		  
	class LocationControllersCommune extends Controllers
	{
		function __construct()
		{
			$this->view = 'commune' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$countries = $model->get_all_record('fs_countries');
			$cities = $model->get_cities_by_country_session();
			$districts = $model->get_districts_by_city_session();
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$countries = $model->get_all_record('fs_countries');
//			$cities = $model->get_all_record('fs_cities');
			$maxOrdering = $model->getMaxOrdering();
			$cities = $model->get_cities_by_country_id(66);
			$districts = $model->get_districts_by_city_id(1473);
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$countries = $model->get_all_record('fs_countries');
			$data = $model->get_record_by_id($id);
			$cities = $model->get_cities_by_country_id($data -> country_id);
			$districts = $model->get_districts_by_city_id($data -> city_id);
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
			
		}
	}
	
?>