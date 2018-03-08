<?php
	class StatisticControllersStatistic extends Controllers
	{
		function __construct(){
			parent::__construct(); 
		}
		function display()
		{
			$model = $this -> model;
			 
			$data = $model->getData();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
?>