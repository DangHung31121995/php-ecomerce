<?php
	// models 
	include 'modules/'.$module.'/models/table.php';
	
	class LanguagesControllersTable
	{
		var $module;
		var $gid;
		function __construct()
		{
			global $module;
			$this->module = 'languages' ; 
			$this->view = 'table' ; 
		}
		function display()
		{
			// call models
			$model = new LanguagesModelsTable();
			
			$table_id = FSInput::get('id',0,'int');
			$table = $model->getTable($table_id);
			$main_field = $table -> main_field_display;
			$language_not_default = $model->get_languages();
			$list = $model->get_list($table,$language_not_default);
			
			$total = $model -> getTotal($table,$language_not_default);
			$pagination = $model->getPagination($total);

			// call views
			include 'modules/'.$this->module.'/views/'.$this-> view.'/list.php';
		}
		
		function back(){
			setRedirect('index.php?module=languages&view=tables');	
		}
		function translate(){
			$model = new LanguagesModelsTable();
			// table
			$table_id = FSInput::get('table',0,'int');
			$table = $model->getTable($table_id);	
			
			// language
			$lang_id = FSInput::get('language',0,'int');
			$language = $model->get_language_by_id($lang_id);

			// create table if not exist
			$create_table = $model ->create_table($table -> table_name , $table -> table_name . '_' . $language-> lang_sort);  
				
			$id = FSInput::get('id',0,'int');	

			$fields_in_table = $model -> get_field_table($table -> table_name);
			
			$data_old  = $model->get_data($table -> table_name,$id);	
			$data_new  = $model->get_data($table -> table_name . '_' . $language-> lang_sort,$id);

			// call views
			include 'modules/'.$this->module.'/views/'.$this-> view.'/translate.php';
		}
		
		function apply()
		{
			$model = new LanguagesModelsTable();
			// check password and repass
			// call Models to save
			$table_id = FSInput::get('table',0,'int');
			$id = FSInput::get('id',0,'id');
			$lang_id = FSInput::get('lang_id',0,'int');
			$rid = $model->save();
			$link = 'index.php?module=languages&view=table&task=translate&id='.$id.'&language='.$lang_id.'&table='.$table_id;
			if($rid)
			{
				setRedirect($link,FSText :: _('Saved'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Not save'),'error');	
			}
			
		}
		
		function save()
		{
			$model = new LanguagesModelsTable();
			// check password and repass
			// call Models to save
			$table_id = FSInput::get('table',0,'int');
			$rid = $model->save();
		
			$link = "index.php?module=languages&view=table&id=".$table_id;
			if($rid)
			{
				setRedirect($link,FSText :: _('Saved'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Not save'),'error');	
			}
			
		}
		
		function cancel()
		{
			$id = FSInput::get('table',0,'int');
			setRedirect('index.php?module=languages&view=table&id='.$id);	
		}
	}
?>