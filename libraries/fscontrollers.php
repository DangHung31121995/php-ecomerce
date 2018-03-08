<?php
class FSControllers
{
	var $module;
	var $view;
	var $model;
	function __construct(){
		$module = FSInput::get('module','home');
		$view = FSInput::get('view',$module);
        /* Phiên bản mobile */
        if(IS_MOBILE)
            $view = 'm'.$view;
		$this -> module = $module;
		$this->view  = $view;
		include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		$model_name = ucfirst($this -> module).'Models'.ucfirst($this -> view);
		$this -> model = new $model_name();
	}
	
	/*
	 * function check Captcha
	 */
	function check_captcha(){
		$captcha = FSInput::get('txtCaptcha');
            if ( $captcha == $_SESSION["security_code"]){
                return true;
            } 
        return false;
	}
	
	function ajax_check_captcha(){
		$result = $this -> check_captcha();
		echo $result?1:0;
	}
	
	function alert_error($msg){
		echo "<script type='text/javascript'>alert('".$msg."'); </script>";
	}
	
	function get_cities_ajax(){
		$model = $this -> model;
		$cid = FSInput::get('cid');
		$rs  = $model -> get_cities($cid);
		
		$json = '['; // start the json array element
		$json_names = array();
		if(count($rs))
		foreach( $rs as $item)
		{
			$json_names[] = "{id: $item->id, name: '$item->name'}";
		}
		$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
		$json .= implode(',', $json_names);
//		$json .= ',{id: 0, name: "Tự nhập nếu không có"}]'; // end the json array element
		$json .= ']'; // end the json array element
		echo $json;
	}
	function get_location_ajax(){
		$model = $this -> model;
		$cid = FSInput::get('cid',0,'int');
		$type = FSInput::get('type');
		$where = '';
		if($type == 'city'){
			$tablename = 'fs_cities';
			$where = ' AND country_id = '.$cid.' ';
		}else if($type == 'district'){
			$where = ' AND city_id = '.$cid.' ';
			$tablename = 'fs_districts';
		}else if($type == 'commune'){
			$where = ' AND district_id = '.$cid.' ';
			$tablename = 'fs_commune';
		}else{
			return;
		}
		$rs  = $model -> get_records(' published = 1'.$where,$tablename, 'id,name',' ordering, id');
		
		$json = '['; // start the json array element
		$json_names = array();
		if(count($rs))
		foreach( $rs as $item)
		{
			$json_names[] = "{id: $item->id, name: '$item->name'}";
		}
		$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
		$json .= implode(',', $json_names);
//		$json .= ',{id: 0, name: "Tự nhập nếu không có"}]'; // end the json array element
		$json .= ']'; // end the json array element
		echo $json;
	}
	
	function get_districts_ajax(){
		$model = $this -> model;
		$cid = FSInput::get('cid');
		$rs  = $model -> get_districts($cid);
		
		$json = '['; // start the json array element
		$json_names = array();
		if(count($rs))
		foreach( $rs as $item)
		{
			$json_names[] = "{id: $item->id, name: '$item->name'}";
		}
		$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
		$json .= implode(',', $json_names);
		$json .= ']'; // end the json array element
		echo $json;
	}
	
}	