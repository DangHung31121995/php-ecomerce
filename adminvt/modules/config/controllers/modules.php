<?php
	class ConfigControllersModules  extends Controllers
	{
		function __construct(){
			parent::__construct(); 
		}
		function display()
		{
			$model  = $this -> model;
			$list = $model->getData();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function edit()
		{
			$model = $this -> model;
			$id = FSInput::get('id',0,'int');
			$data = $model->get_record_by_id($id);
			
			// load config of module
			if(file_exists(PATH_BASE.'modules'.DS.$data -> module.DS.'config.php'))
				include_once '../modules/'.$data -> module.'/config.php';
			FSFactory::include_class('parameters');
			$config_name = $data -> module."_".$data -> view;
			if($data -> task)
				$config_name  = '_'.$data -> task;
			$config = isset($config_module[$config_name])?$config_module[$config_name]:array()  ;	
			
			$current_parameters = new Parameters($data->params);
			$params = isset($config['params'])?$config['params']: null;
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function add(){
			return;
		}
	}
	
?>