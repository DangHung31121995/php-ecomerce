<?php
/*
 * Huy write
 */

class Controllers
{
	var $module;
	var $gid;
	var $prefix ;
	function __construct()
	{
		$module = FSInput::get('module');
		$view = FSInput::get('view',$module);
		
		$this -> module = $module;
		$this -> view = $view;
		
		$prefix = $this -> module .'_'.$this -> view .'_';
		$this -> prefix = $prefix;
		
		include '../administrator/modules/'.$this -> module .'/models/'.$this -> view .'.php';
		
		$model_name = ucfirst($this -> module).'Models'.ucfirst($this -> view);
		$this -> model = new $model_name();
	}
	function display()
	{
		$sort_field  = FSInput::get('sort_field');
		$sort_direct = FSInput::get('sort_direct');
		$sort_direct = $sort_direct?$sort_direct:'asc';
		
		if(@$sort_field)
		{
			$_SESSION[$this -> prefix.'sort_field']  =  $sort_field  ;
			$_SESSION[$this -> prefix.'sort_direct']  = $sort_direct ;
		}
		
		if(isset($_POST['keysearch']))
		{
			$_SESSION[$this -> prefix.'keysearch']  =  $_POST['keysearch']  ;
		}
		if(	isset($_POST['filter'])){
			$_SESSION[$this -> prefix.'filter']  =  $_POST['filter'] ;
		}
		
		// multi filter
		if(	isset($_POST['text_count'])){
			$_SESSION[$this -> prefix.'text_count']  =  $_POST['text_count'] ;
			$count = $_SESSION[$this -> prefix.'text_count'] ;
			for($i = 0; $i < $count; $i ++){
				if(isset($_POST['text'.$i]))
					$_SESSION[$this -> prefix.'text'.$i]  =  $_POST['text'.$i] ;
			}
		}
		// multi filter
		if(	isset($_POST['filter_count'])){
			$_SESSION[$this -> prefix.'filter_count']  =  $_POST['filter_count'] ;
			$count = $_SESSION[$this -> prefix.'filter_count'] ;
			for($i = 0; $i < $count; $i ++){
				if(isset($_POST['filter'.$i]))
					$_SESSION[$this -> prefix.'filter'.$i]  =  $_POST['filter'.$i] ;
			}
		}
		
		$this -> sort_field = '';
		$this -> sort_direct = 'asc';
		if(isset($_SESSION[$this -> prefix.'sort_field']))
		{
			$this -> sort_field = $_SESSION[$this -> prefix.'sort_field'];
			$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
			$this -> sort_direct = $sort_direct?$sort_direct:'asc';
		}
	}
	
	function add(){
		
		$model = $this -> model;
		$maxOrdering = $model->getMaxOrdering();
		$maxOrdering = $maxOrdering? $maxOrdering  :1;
		include '../libraries/wysiwyg_editor/fckeditor.php'; 
		include '../administrator/modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}
	
	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);
		include '../libraries/wysiwyg_editor/fckeditor.php'; 
		include '../administrator/modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}
	
	function remove()
	{
		$id = FSInput::get('id',0,'int');
		$model = $this -> model;

		$rows = $model->remove();
		if($rows)
		{
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,$rows.' '.FSText :: _('record was deleted'));	
		}
		else
		{
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,FSText :: _('Not delete'),'error');	
		}
	}
	function published()
	{
		$model = $this -> model;
		$rows = $model->published(1);
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		if($rows)
		{
			setRedirect($link,$rows.' '.FSText :: _('record was published'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Error when published record'),'error');	
		}
	}
	function unpublished()
	{
		$model = $this -> model;
		$rows = $model->published(0);
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		if($rows)
		{
			setRedirect($link,$rows.' '.FSText :: _('record was unpublished'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Error when unpublished record'),'error');	
		}
	}
	function apply()
	{
		$model = $this -> model;
		$id = $model->save();
		
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		
		// call Models to save
		if($id)
		{
			setRedirect($link.'&task=edit&id='.$id,FSText :: _('Saved'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Not save'),'error');	
		}
		
	}
	function save()
	{
		$model = $this -> model;
		// check password and repass
		// call Models to save
		$id = $model->save();
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			
		if($id)
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
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		setRedirect($link);	
	}
	function back()
	{
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		setRedirect($link);	
	}
	
	/*
	 * Genarate filter
	 * Old solution
	 */
	function genarate_filter($row){
		if(!count($row))
			return;
		$prefix = $this -> prefix;		
		$ss_keysearch  = isset($_SESSION[$prefix.'keysearch']) ? $_SESSION[$prefix.'keysearch']:'';
		$ss_filter   = isset($_SESSION[$prefix.'filter']) ? $_SESSION[$prefix.'filter']:'';
		
		$html = '';
		$html .= '<div  class="filter_area">';
		$html .= '	<table>';
		$html .= '		<tr>';
		if(isset($row['search'])){
			$html .= '			<td align="left" width="100%">';
			$html .= 				FSText :: _( 'Search' ).':';
			$html .= '				<input type="text" name="keysearch" id="search" value="'.$ss_keysearch.'" class="text_area" onchange="document.adminForm.submit();" />';
			$html .= '				<button onclick="this.form.submit();">'.FSText :: _( 'Search' ) . '</button>';
			$html .= '				<button onclick="document.getElementById(\'search\').value=\'\';this.form.getElementById(\'filter_state\').value=\'\';this.form.submit();">'.FSText :: _( 'Reset' ).'</button>';
			$html .= '			</td>';
		}
		if(isset($row['filter']['title'])){
			$field = isset($row['filter']['field'])?$row['filter']['field']:'name';
			$html .= '			<td nowrap="nowrap">';
			$html .= '				<select name="filter" class="type" onChange="this.form.submit()">';
			$html .= '					<option value="0"> -- '.$row['filter']['title'].' -- </option>';
								
								foreach($row['filter']['list'] as $item){
									if($item->id == $ss_filter){
										$html .= "<option value='" . $item->id . "'  selected='selected'> ". $item->$field . "</option>";
									}
									else{
										$html .= "<option value='" . $item->id . "'>" . $item->$field . "</option>";
									}
								}
			$html .= '				</select>';
			$html .= '			</td>';
		}
		$html .= '		</tr>';
		$html .= '	</table>';
		$html .= '</div>';
		return $html;
	}
	
	/*
	 * Genarate filter
	 * News solution
	 */
	function create_filter($row){
		if(!count($row))
			return;
		$prefix = $this -> prefix;		
		$ss_keysearch  = isset($_SESSION[$prefix.'keysearch']) ? $_SESSION[$prefix.'keysearch']:'';
		
		
		$html = '';
		$html .= '<div  class="filter_area">';
		$html .= '	<table>';
		$html .= '		<tr>';
		
		$html_text = '';
		if(isset($row['text_count'])){ 
			$count = $row['text_count'];
			for($i = 0; $i < $count; $i ++) {
				$text_item = $row['text'][$i];
				$ss_text   = isset($_SESSION[$prefix.'text'.$i]) ? $_SESSION[$prefix.'text'.$i]:'';
				$type = isset($text_item['type'])?$text_item['type']:'';
				$html_text .= '			<td align="left" >';
				$html_text .= 	$text_item['title'];
				$html_text .= 	'<input type="text" name="text'.$i.'" id="text'.$i.'" value="'.$ss_text.'" />';
				
				$html_text .= '			</td>';
			}
			$html .= '			<input type="hidden" name="text_count" value="'.$count.'" />';
		}
		
		if(isset($row['search'])){
			$html .= '			<td align="left" >';
			$html .= 				FSText :: _( 'Search' ).':';
			$html .= '				<input type="text" name="keysearch" id="search" value="'.$ss_keysearch.'" class="text_area"  />';
			
			$html .= '</td>';
			$html .= $html_text;
			$html .= '<td>';
			$html .= '				<button onclick="this.form.submit();">'.FSText :: _( 'Search' ) . '</button>';
			$html .= '				<button onclick="document.getElementById(\'search\').value=\'\';';
			if(isset($row['text_count'])){ 
				$count = $row['text_count'];
				for($i = 0; $i < $count; $i ++) {
					$html .= '				document.getElementById(\'text'.$i.'\').value=\'\'; ';
				}
			}
			$html .= '				this.form.getElementById(\'filter_state\').value=\'\';this.form.submit();">'.FSText :: _( 'Reset' ).'</button>';
			$html .= '			</td>';
		}
		if(isset($row['filter_count'])){ 
			$count = $row['filter_count'];
			$html .= '			<input type="hidden" name="filter_count" value="'.$count.'" />';
			for($i = 0; $i < $count; $i ++) {
				$filter_item = $row['filter'][$i];
				$ss_filter   = isset($_SESSION[$prefix.'filter'.$i]) ? $_SESSION[$prefix.'filter'.$i]:'';
				$type = isset($filter_item['type'])?$filter_item['type']:'';
				if($type == 'yesno'){
					$field = isset($filter_item['field'])?$filter_item['field']:'name';
					$html .= '			<td nowrap="nowrap">';
					$html .= '				<select name="filter'.$i.'" class="type" onChange="this.form.submit()">';
					$html .= '					<option value="2"> -- '.$filter_item['title'].' -- </option>';
					
					
					$selected_no = $ss_filter == 0? "selected='selected'":"";
					$selected_yes = $ss_filter == 1? "selected='selected'":"";
					$html .= "<option value='1'  ".$selected_yes."> ". FSText::_('Yes') . "</option>";
					$html .= "<option value='0'  ".$selected_no."> ". FSText::_('No') . "</option>";
					
					$html .= '				</select>';
					$html .= '			</td>';
					continue;
				}
				
				$field = isset($filter_item['field'])?$filter_item['field']:'name';
				$html .= '			<td nowrap="nowrap">';
				$html .= '				<select name="filter'.$i.'" class="type" onChange="this.form.submit()">';
				$html .= '					<option value="0"> -- '.$filter_item['title'].' -- </option>';
				if(isset($filter_item['list']))		
					if($filter_item['list'])							
						foreach($filter_item['list'] as $item){
							if($item->id == $ss_filter){
								$html .= "<option value='" . $item->id . "'  selected='selected'> ". $item->$field . "</option>";
							}
							else{
								$html .= "<option value='" . $item->id . "'>" . $item->$field . "</option>";
							}
						}
				$html .= '				</select>';
				$html .= '			</td>';
			}	
		}
		$html .= '		</tr>';
		$html .= '	</table>';
		$html .= '</div>';
		return $html;
	}
	
	function load_view($file_name = '',$view = ''){
		if(!$file_name)
			return;
		if(!$view)
			$view = $this -> view;
		include '../administrator/modules/'.$this->module.'/views/'.$view.'/'.$file_name.'.php';
	}
	/*
	 * Save all record for list form
	 */
	function save_all(){
	   $model = $this -> model;
        // check password and repass
        // call Models to save
        $id = $model->save_all();
        $link = 'index.php?module='.$this -> module.'&view='.$this -> view;
        $page = FSInput::get('page',0,'int');
        if($page)
              $link .= '&page='.$page;  
        if($id)
        {
            setRedirect($link,FSText :: _('Saved'));    
        }
        else
        {
            setRedirect($link,FSText :: _('Not save'),'error'); 
        }
	}
	function district()
	{
		$model  = $this -> model;
		$cid = FSInput::get('cid');
		$rs  = $model -> get_districts($cid);
		
		$json = '['; // start the json array element
		$json_names = array();
		foreach( $rs as $item)
		{
			$json_names[] = "{id: $item->id, name: '$item->name'}";
		}
		$json .= implode(',', $json_names);
		$json .= ']'; // end the json array element
		echo $json;
	}
		function home()
	{
		$model = $this -> model;
		$rows = $model->home(1);
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		if($rows)
		{
			setRedirect($link,$rows.' '.FSText :: _('record was home'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Error when home record'),'error');	
		}
	}
	function unhome()
	{
		$model = $this -> model;
		$rows = $model->home(0);
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		if($rows)
		{
			setRedirect($link,$rows.' '.FSText :: _('record was unhome'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Error when unhome record'),'error');	
		}
	}
}