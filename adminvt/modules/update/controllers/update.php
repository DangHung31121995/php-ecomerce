<?php
	class UpdateControllersUpdate  extends Controllers
	{
		function __construct()
		{
			$this->view = 'update' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function save(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->save();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
			
//			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
//				
//			if($id)
//			{
//				setRedirect($link,FSText :: _('Saved'));	
//			}
//			else
//			{
//				setRedirect($link,FSText :: _('Not save'),'error');	
//			}
		}
		
		function syn_products(){
			$model = $this -> model;
			// check password and repass
			// call Models to save
			$arr_result = $model->syn_products();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_cats(){
			$model = $this -> model;
			$arr_result = $model->syn_cats();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_manufactories(){
			$model = $this -> model;
			$arr_result = $model->syn_manufactories();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_author(){
			$model = $this -> model;
			$arr_result = $model->syn_author();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_pagenumber(){
			$model = $this -> model;
			$arr_result = $model->syn_pagenumber();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_translator(){
			$model = $this -> model;
			$arr_result = $model->syn_translator();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function update_home_cats(){
			$model = $this -> model;
			$arr_result = $model->update_home_cats();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function syn_images(){
			$model = $this -> model;
			$arr_result = $model->syn_images();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		function add_main_images(){
			$model = $this -> model;
			$arr_result = $model->add_main_images();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function repair_products(){
			$model = $this -> model;
			$arr_result = $model->repair_products();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function add_other_images(){
			$model = $this -> model;
			$arr_result = $model->add_other_images();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function new_resize_images(){
			$model = $this -> model;
			$arr_result = $model->new_resize_images();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function valid_manufactory(){
			$model = $this -> model;
			$arr_result = $model->valid_manufactory();
			parent::display();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
	
?>