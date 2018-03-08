<?php 
class TemplateHelper
{
	function published($cid, $status)
	{
		if($status != 'published')
		{
			
			$html =  "<a title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"templates/default/images/published.png\"></a>";
		}
		else
		{
			$html =  "<a title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Disable status\" src=\"templates/default/images/unpublished.png\"></a>";
		}		
		return $html;
	}
	
	/*
	 * For special case.
	 * Reserve with published
	 */
	function published2($cid, $status)
	{
		if($status != 'unpublished')
		{
			
			$html =  "<a title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"templates/default/images/published.png\"></a>";
		}
		else
		{
			$html =  "<a title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Disable status\" src=\"templates/default/images/unpublished.png\"></a>";
		}		
		return $html;
	}
	function activated($cid, $status)
	{
		if($status != 'activated')
		{
			
			$html =  "<a title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"templates/default/images/published.png\"></a>";
		}
		else
		{
			$html =  "<a title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Disable status\" src=\"templates/default/images/unpublished.png\"></a>";
		}		
		return $html;
	}
	
	function changeStatus($cid, $status)
	{
		if(substr(trim($status),0,2) == 'un')
		{
			$html =  "<a title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"templates/default/images/published.png\"></a>";
		}
		else
		{
			$html =  "<a title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Disable status\" src=\"templates/default/images/unpublished.png\"></a>";
		}		
		return $html;
	}
	function viewStatus($cid, $status)
	{
		if(substr(trim($status),0,2) == 'un')
		{
			$html =  "<img border=\"0\" alt=\"Enabled status\" src=\"templates/default/images/published.png\">";
		}
		else
		{
			$html =  "<img border=\"0\" alt=\"Disable status\" src=\"templates/default/images/unpublished.png\">";
		}		
		return $html;
	}
	function views($link)
		{
				$html =  "<a title=\"Views\" href=\"$link\">";
				$html .="<img border=\"0\" alt=\"Views\" src=\"templates/default/images/view.jpg\" /></a>";
			return $html;
		}
			function edit($link)
	{
			$html =  "<a title=\"Views\" href=\"$link\">";
			$html .="<img border=\"0\" alt=\"Views\" src=\"templates/default/images/edit_icon.png\" /></a>";
		return $html;
	}
	function reply($link)
	{
			$html =  "<a title=\"reply\" href=\"$link\">";
			$html .="<img border=\"0\" alt=\"reply\" src=\"templates/default/images/icon-reply.png\" /></a>";
		return $html;
	}
	/*
	 * $title_field is Title
	 * field_select is value of fields in thead 
	 * field_sorting is value of fields is sorting.
	 * sort_direct: asc, desc
	 */
	function order_field($title_field,$field_select, $field_sorting  = '', $sort_direct ='')
	{
		$url = $_SERVER['REQUEST_URI'];
		$url =  trim(preg_replace('/&sortby=[a-zA-Z0-9_]+/i', '', $url)); // field
		$url =  trim(preg_replace('/&sort=[a-z]+/i', '', $url));  // direct
		
		$sort_direct = $sort_direct?$sort_direct:'asc';
		$sort_direct_continue = $sort_direct == 'asc' ? 'desc' : 'asc';
		$link = $url.'&sortby='.$field_select.'&sort='.$sort_direct_continue;
		if($field_select == $field_sorting)
		{
			$html  =  "<a title=\"Click to sort by this column\" href=\"$link\">";
			$html .= $title_field ;
			$html .= "<img alt=\"$sort_direct\" src=\"templates/default/images/sort_$sort_direct.png\">";
			$html .= "</a>";
			
		}
		else
		{
			$html =  "<a title=\"Click to sort by this column\" href=\"$link\">$title_field</a>";
		}
		return $html ; 
	}
	/* USE SESSTION
	 * $title_field is Title
	 * field_select is value of fields in thead 
	 * field_sorting is value of fields is sorting.
	 * sort_direct: asc, desc
	 */
	function orderTable($title_field,$field_select, $field_sorting , $sort_direct)
	{
		$sort_direct = $sort_direct?$sort_direct:'asc';
		$sort_direct_continue = $sort_direct == 'asc' ? 'desc' : 'asc';
		if($field_select == $field_sorting)
		{
			$html  =  "<a title=\"Click to sort by this column\" href=\"javascript:tableOrdering('$field_select','$sort_direct_continue','');\">";
			$html .= $title_field ;
			$html .= "<img alt=\"$sort_direct\" src=\"templates/default/images/sort_$sort_direct.png\">";
			$html .= "</a>";
			
		}
		else
		{
			$html =  "<a title=\"Click to sort by this column\" href=\"javascript:tableOrdering('$field_select','$sort_direct_continue','');\">$title_field</a>";
		}
		return $html ; 
	}
	/*
	 * rows > 0 ? textarea: input
	 * name: field_name
	 * display: echo 
	 */
	function edit_text($name,$value,$i,$size = 3,$rows = 1){
		if($rows > 1){
			$html = '<textarea rows="'.$rows.'" cols="'.$size.'" name="'.$name.'_'.$i.'" >'.htmlspecialchars($value).'</textarea>';
		    $html .= '<input type="hidden" name="'.$name.'_'.$i.'_original'.'" value="'.htmlspecialchars($value).'"/>';
		}else{
			$html = '<input type="text" name="'.$name.'_'.$i.'"  value="'.htmlspecialchars($value).'" size="'.$size.'"/>';
		    $html .= '<input type="hidden" name="'.$name.'_'.$i.'_original'.'" value="'.htmlspecialchars($value).'"/>';
		}
		return $html;
	}
    
    function default_text($name, $value){
        $html = '<div>'.htmlspecialchars($value).'</div>';
		return $html;
	}
	/*
	 * rows > 0 ? textarea: input
	 * name: field_name
	 */
	function edit_selectbox($name,$value,$i,$arry_select = array(),$field_value = 'id', $field_label='name',$size = 1,$multi  = 0){
		if(!$multi){
			$html_sized = $size > 1 ? "size=$size":"" ;
			$html = '<select name="'.$name.'_'.$i.'" id="'.$name.'_'.$i.'" '.$html_sized.'>';
			$compare  = 0;
			if(@$value)
				$compare = $value;
			$j = 0;
			if(count($arry_select)){
				if(is_object(end($arry_select))){
					foreach ($arry_select as $select_item) {
						$checked = "";
						if(!$compare && !$j){
							$checked = "selected=\"selected\"";
						} else {
							if($compare === ($select_item->$field_value))
								$checked = "selected=\"selected\"";
						}
						$html .= '<option value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';	
						$j ++;
					}
				} else {
					foreach ($arry_select as $key => $name) {
						$checked = "";
						if(!$compare && !$j){
							$checked = "selected=\"selected\"";
						} else {
							if($compare == $key)
								$checked = "selected=\"selected\"";
						}
						$html .= '<option value="'.$key.'" '. $checked.'>'.$name.'</option>';	
						$j ++;
					}
				}
			}
			$html .= '</select>';
			$html .= '<input type="hidden" name="'.$name.'_'.$i.'_original'.'" value="'.$value.'"/>';
		} else {
			$html_sized = $size > 1 ? "size=$size":"" ;
			$html = '<select name="'.$name.'_'.$i.'[]" id="'.$name.'_'.$i.'" '.$html_sized.'  multiple="multiple">';
			$array_value  = isset($value)?explode(',',$value):array();
			$j = 0;
			if(count($arry_select)){
				if(is_object(end($arry_select))){
			foreach ($arry_select as $select_item) {
				$checked = "";
						if(in_array($select_item->$field_value,$array_value))
					$checked = "selected=\"selected\"";
					$html .= '<option value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';	
						$j ++;
					}
				} else {
					foreach ($arry_select as $key => $name) {
						if(in_array($name,$array_value))
						$checked = "selected=\"selected\"";
				
						$html .= '<option value="'.$key.'" '. $checked.'>'.$name.'</option>';	
				$j ++;
					}
				}
			}
			$html .= '</select>';
			$html .= '<input type="hidden" name="'.$name.'_'.$i.'_original'.'" value="'.$value.'"/>';
		}
		
		return $html;
	}
	/****
	 * For list
	 * config: array(title,field,ordering,type,col_width,no_col,align,arr_params,display_label)
	 * type: text, datetime, date, image, edit_text,edit_selectbox, published,edit,change_status,
	 * text: display string 
	 * @ordering: ordering this cols
	 * display_label: display title into body 
	 * arr_params by type: edit_text($size,$rows)
	 * 						text (have_link_edit,function)
	 * 						label 
	 * 						image(search,replace,have_link_edit,with,heigh)
	 * 						edit_selectbox(arry_select,field_value,field_label,size,multi)
	 * 						change_status(function)
	 * ==============
	 * $params: the hidden tag name need add in form
	 * 
	 */ 
	function genarate_form_liting($module,$view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination,$params = array(),$first='index.php'){
		if(!count($list_config)){
			return;	
		}
		$prefix = $module.'_'.$view.'_';
		$html_filter = count($fitler_config)? TemplateHelper::create_filter($fitler_config,$prefix) : '';
		$link = $first.'?module='.$this -> module.'&view='.$this -> view;
		if(count($params)){
			foreach($params as $name => $param){
				$link .= '&'.$name.'='.$param;
			}
		}
		$html_begin = '<div class="form_body"><form action="'.$link.'" name="adminForm" method="post">';
		$i = 1;
		$arr_head  = array();
		$arr_config = array();
		$arr_field_change = array();
		foreach($list_config as $item){
			$col = $i;
			if(isset($item['no_col']))
				$col = $item['no_col'];
			if(!isset($arr_head[$col])){
				$col_width = isset($item['col_width'])?'width="'.$item['col_width'].'"':'';
				if(!isset($item['ordering']) || empty($item['ordering'])){
					$arr_head[$col] = '<th class="title" '.$col_width.' >'.FSText :: _($item['title']).'</th>';
				}else{
					$arr_head[$col] = '<th class="title" '.$col_width.' >'.TemplateHelper::orderTable(FSText :: _($item['title']), $item['field'],@$sort_field,@$sort_direct).'</th>';
				}
				$arr_config[$col] = array();
			}
			$arr_config[$col][] = $item;
			$type = isset($item['type'])?$item['type']:'text';
			if($type == 'edit_text' || $type == 'edit_selectbox'){
				$arr_field_change[] = $item['field'];
			}
			$i ++;
		}
		$html_head = '<div class="form-contents"><table border="1" class="tbl_form_contents" cellpadding="5" bordercolor="#CCC"><thead><tr>';
		$html_head .= '<th width="3%">	#</th><th width="3%"><input type="checkbox" onclick="checkAll('.count($list).')" value="" name="toggle"></th>';
		$html_head .= implode($arr_head, '');
		$html_head .= '</tr></thead>';
		$html_body = '<tbody>';
		if(!count($list)){
		}else{
			$i = 0;
			foreach($list as $row){
				$link_view = "index.php?module=".$this -> module."&view=".$this -> view."&task=edit&id=".$row->id;
				$html_body .= '<tr class="row'.($i%2).'">';
				$html_body .= '<td>'.($i+1).'<input type="hidden" name="id_'.$i.'" value="'.$row->id.'"/> </td>';
				$html_body .= '<td><input type="checkbox" onclick="isChecked(this.checked);" value="'.$row->id.'"  name="id[]" id="cb'.$i.'"> </td>';
				 
				foreach($arr_config as $col){
					if(!count($col)){
						continue;
					}
					if(isset($col[0]['align']))
						$html_body .= '<td align = "'.$col[0]['align'].'">';
					else 
						$html_body .= '<td>';
					$j = 0;
					foreach($col as $item){
						if($j > 0)
							$html_body .= '<br/><div class="break_line">&nbsp;</div>';
						$type = isset($item['type'])?$item['type']:'text';
						$display_label = isset($item['display_label'])?$item['display_label']:0;
						if($display_label)
							$html_body .= $item['title'].': ';
							
						switch($type){
							case 'published':
								$html_body .= TemplateHelper::published("cb".($i),$row->published?"unpublished":"published");
								break;
							case 'label':
								$j --;
								break;
							case 'change_status':
								$function = isset($item['arr_params']['function'])?$item['arr_params']['function']: $item['field'];
								$html_body .= TemplateHelper::changeStatus("cb".($i),$row->$item['field']?"un".$function:$function);
								break;
							case 'edit':
								$html_body .= TemplateHelper::edit($link_view);
								break;
                            case 'reply':
								$html_body .= TemplateHelper::reply("index.php?module=".$this -> module."&view=".$this -> view."&task=reply&id=".$row->id);
								break;
							case 'datetime':
								$html_body .= date('d/m/Y H:i',strtotime($row->$item['field']));
								break;
							case 'date':
								$html_body .= date('d/m/Y',strtotime($row->$item['field']));
								break;
							case 'edit_text':
								$size = isset($item['arr_params']['size'])?$item['arr_params']['size']: 10;
								$rows = isset($item['arr_params']['rows'])?$item['arr_params']['rows']: 1;
								$html_body .= TemplateHelper::edit_text($item['field'],$row->$item['field'],$i,$size,$rows);
								break;
							case 'edit_selectbox':
								$arry_select = isset($item['arr_params']['arry_select'])?$item['arr_params']['arry_select']: array();
								$field_value = isset($item['arr_params']['field_value'])?$item['arr_params']['field_value']: 'id';
								$field_label = isset($item['arr_params']['field_label'])?$item['arr_params']['field_label']: 'name';
								$multi = isset($item['arr_params']['multi'])?$item['arr_params']['multi']: 0;
								$size = isset($item['arr_params']['size'])?$item['arr_params']['size']: 1;
								$html_body .= TemplateHelper::edit_selectbox($item['field'],$row->$item['field'],$i,$arry_select,$field_value,$field_label,$size,$multi);
								break;
							case 'image':
								$link_img = $row -> $item['field'];
								if(isset($item['arr_params']['search']) && isset($item['arr_params']['replace'])){
									$link_img = str_replace($item['arr_params']['search'], $item['arr_params']['replace'], $link_img);
								}
								//with,height
								$html_size = '';
								$width = isset($item['arr_params']['width'])?$item['arr_params']['width']:0;
								$height = isset($item['arr_params']['height'])?$item['arr_params']['height']:0;
								if($width)
									$html_size .= ' width = "'.$width.'"'; 
								if($height)
									$html_size .= ' height = "'.$height.'"'; 
								//link
								$have_link_edit = isset($item['arr_params']['have_link_edit'])?$item['arr_params']['have_link_edit']:0;
								if($have_link_edit)
									$html_body .= '<a href="'.$link_view.'"><img src="'.URL_ROOT.$link_img.'" '.$html_size.' /></a>';
								else
									$html_body .= '<img src="'.URL_ROOT.$link_img.'" '.$html_size.' />';
								break;
							case 'text':
							default:
								if(isset($item['arr_params']['function']) && !empty($item['arr_params']['function'])){
									$function = $item['arr_params']['function'];
									$html_body .= 	$this -> $function($row -> $item['field']);								
								}else{
									if(isset($item['arr_params']['have_link_edit']) && !empty($item['arr_params']['have_link_edit']))
										$html_body .= '<a href="'.$link_view.'" >'.$row -> $item['field'].'</a>';
									else 
										$html_body .= $row -> $item['field'];
									break;									
								}
						}
						$j ++;
					}
					$html_body .= '</td>';
				}
				$html_body .= '</tr>';
				$i++;
			}
		}
		$html_body .= '</tbody></table>';
		$html_footer = '<div class="footer_form">';
		if(isset($pagination)) {
			$html_footer .=  $pagination->showPagination();
		} 
		$html_footer .= '</div>';
		$html_field_change =  count($arr_field_change)?implode($arr_field_change, ','):'';
		
		$html_footer .='<input type="hidden" value="'.@$sort_field.'" name="sort_field" />';
		$html_footer .='<input type="hidden" value="'.@$sort_direct.'" name="sort_direct" />';
		$html_footer .='<input type="hidden" value="'.$module.'" name="module" />';
		$html_footer .='<input type="hidden" value="'.$view.'" name="view" />';
		$html_footer .='<input type="hidden" value="'.($i+1).'" name="total">';
		$html_footer .='<input type="hidden" value="'.FSInput::get('page',0,'int').'" name="page">';
		$html_footer .='<input type="hidden" value="'.$html_field_change.'" name="field_change">';
		$html_footer .='<input type="hidden" value="" name="task">';
		$html_footer .='<input type="hidden" value="0" name="boxchecked">';
		
		$html = $html_begin.$html_filter.$html_head.$html_body.$html_footer.'</form></div></div>';
//		$html = '<xmp>'.$html_begin.$html_filter.$html_head.$html_body.$html_footer.'</form></div>'.'</xmp>';
		echo $html;
	}
	
	/*
	 * FOR DETAIL PAGE
	 * name: field_name
	 */
	function dt_edit_selectbox($title,$name,$value,$default = '',$arry_select = array(),$field_value = 'id', $field_label='name',$size = 1,$multi  = 0,$add_fisrt_option=0,$comment = ''){
		$html = '<tr><td valign="top" class="label key" valign="top">'.$title.'</td><td class="value">';
		if(!$multi){
			$html_sized = $size > 1 ? "size=$size":"" ;
			$html .= '<select name="'.$name.'" id="'.$name.'" '.$html_sized.'>';
			$compare  = 0;
			if(isset($value))
				$compare = $value;
			else 
				$compare = $default;
				
			if($add_fisrt_option){
				$checked = "";
				if(!$compare)
					$checked = "selected=\"selected\"";
				$html .= '<option  value="0" '.$checked.'>--'.$title.'--</option>';
			}	
			$j = 0;
			if(count($arry_select)){
				
				if(is_object(end($arry_select))){
					
					foreach ($arry_select as $select_item) {
						$checked = "";
						if(!$compare && !$j && !$add_fisrt_option){
							$checked = "selected=\"selected\"";
						} else {
							if($compare === ($select_item->$field_value))
								$checked = "selected=\"selected\"";
						}
						$html .= '<option value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';	
						$j ++;
					}
				} else {
					foreach ($arry_select as $key => $name) {
						$checked = "";
						if(!$compare && !$j && !$add_fisrt_option){
							$checked = "selected=\"selected\"";
						} else {
							if($compare == $key)
								$checked = "selected=\"selected\"";
						}
						$html .= '<option value="'.$key.'" '. $checked.'>'.$name.'</option>';	
						$j ++;
					}
				}
			}
			$html .= '</select>';
		}else{
			// not working
			$html_sized = $size > 1 ? "size=$size":"" ;
			$html .= '<select name="'.$name.'[]" id="'.$name.'" '.$html_sized.' multiple="multiple">';
			$array_value  = isset($value)?explode(',',$value):array();
//			$compare  = 0;
//			if(@$value)
//				$compare = $value;
			$j = 0;
			if(count($arry_select)){
				if(is_object(end($arry_select))){
					foreach ($arry_select as $select_item) {
						$checked = "";
						if(in_array($select_item->$field_value,$array_value))
							$checked = "selected=\"selected\"";
						$html .= '<option value="'.$select_item->$field_value.'" '. $checked.'>'.$select_item -> $field_label.'</option>';	
						$j ++;
					}
				} else {
					foreach ($arry_select as $key => $name) {
						if(in_array($name,$array_value))
							$checked = "selected=\"selected\"";
						$html .= '<option value="'.$key.'" '. $checked.'>'.$name.'</option>';	
						$j ++;
					}
				}
			}
			$html .= '</select>';
		}
		if($comment)
			$html .= '<span class=\'comment\'>'.$comment.'</span>';
		$html .= '</td></tr>';
		echo $html;
	}
	/*
	 * FOR DETAIL PAGE
	 * tag: input, textarea, editor
	 * in case editor: width => size, height => rows
	 */
	function dt_edit_text($title,$name,$value,$default = '',$size = 60,$rows = 1,$editor = 0,$comment=''){
		if(!isset($value))
			$value = $default;
		echo '<tr><td valign="top" class="label key" valign="top">'.$title.'</td><td class="value">';
		if($rows > 1){
			if(!$editor){
				echo  '<textarea rows="'.$rows.'" cols="'.$size.'" name="'.$name.'" id="'.$name.'" >'.$value.'</textarea>';
			} else {
//				echo  '<textarea rows="10" cols="10" name="'.$name.'" id="'.$name.'" >'.$value.'</textarea>';
//				echo "<script>CKEDITOR.replace( '".$name."');</script>";
				$k = 'oFCKeditor_'.$name;
				$oFCKeditor[$k] = new FCKeditor($name) ;
				$oFCKeditor[$k]->BasePath	=  '../libraries/wysiwyg_editor/' ;
				$oFCKeditor[$k]->Value		= stripslashes(@$value);
				$oFCKeditor[$k]->Width = $size;
				$oFCKeditor[$k]->Height = $rows;
				$oFCKeditor[$k]->Create() ;
			}
		}else{
			echo '<input type="text" name="'.$name.'" id="'.$name.'" value="'.htmlspecialchars($value).'" size="'.$size.'"/>';
		}
		if($comment)
			echo '<span class=\'comment\'>'.$comment.'</span>';
		echo  '</td></tr>';
	}
    
    function dt_date_pick($title, $name, $value, $default = '', $size = 60, $comment = '') {
		if (! isset ( $value )) $value = $default;
		//$value = escape($value);
		echo '<tr>';
		echo '	<td class="label key" valign="top"><span>' . $title . '</span></td>';
		echo '	<td class="value">';
		echo '		<input type="text" name="' . $name . '"  readonly="true" id="' . $name . '" value="' . htmlspecialchars ( $value ) . '" size="' . $size . '"/>';	
		echo '		<a href="javascript:void(0)" onclick="javascript:NewCssCal (\''.$name.'\',\'YYYYmmdd\',\'arrow\',true,\'24\')">';
		echo '			<img border="0" alt="Calenda" src="templates/default/images/cal.gif">';
		echo '		</a>';
		if ($comment) echo '<span class=\'comment\'>' . $comment . '</span>';
		echo '	</td>';
		echo '</tr>';
	}
    
	/*
	 * FOR DETAIL PAGE
	 */
	function dt_text($title,$value,$default = '',$comment=''){
		if(!isset($value))
			$value = $default;
		echo '<tr><td valign="top" class="label key" valign="top">'.$title.'</td><td class="value">';
		echo htmlspecialchars($value);
		if($comment)
			echo '<span class=\'comment\'>'.$comment.'</span>';
		echo  '</td></tr>';
	}
	
	function dt_sepa(){
		echo  '<tr><td colspan="2"><hr class="sepa"/></td></tr>';
	}
	/*
	 * FOR DETAIL PAGE
	 * tag: input, textarea, editor
	 * in case editor: width => size, height => rows
	 */
	function dt_edit_image($title,$name,$value,$width  = 0,$height = 0,$comment=''){
		$html = '<tr><td valign="top" class="label key" valign="top">'.$title.'</td><td class="value">';
		
		if($value){
				$html_w = $width?' width="'.$width.'" ':'';
				$html_h = $height?' height="'.$height.'" ':'';
			$html .= '<img src="'.$value.'" '.$html_w.' '.$html_h.' /><br/>';
		}
		$html .= '<input type="file" name="'.$name.'" />';
		if($comment)
			$html .= '<span class=\'comment\'>'.$comment.'</span>';
		$html .= '</td></tr>';
		echo $html;
	}
	/*
	 * FOR DETAIL PAGE
	 * tag: input, textarea, editor
	 * in case editor: width => size, height => rows
	 */
	function dt_edit_file($title,$name,$value,$comment=''){
		$html = '<tr><td valign="top" class="label key" valign="top">'.$title.'</td><td class="value">';
		
		if($value){
			$html .= $value.'<br/>';
		}
		$html .= '<input type="file" name="'.$name.'" />';
		if($comment)
			$html .= '<span class=\'comment\'>'.$comment.'</span>';
		$html .= '</td></tr>';
		echo $html;
	}
	/*
	 * FOR DETAIL PAGE
	 * tag: radio
	 * in case editor: width => size, height => rows
	 */
	function dt_checkbox($title,$name,$value,$default = 1,$array_value = array(1 => 'Có', 0 => 'Không' ) ){
		$html = '<tr><td valign="top" class="label key" valign="top">'.$title.'</td><td class="value">';
		$compare = isset($value)?$value:$default;
		foreach($array_value as $key => $item){
			if($compare == $key){
				$html .= '<input type="radio" name="'.$name.'" value="'.$key.'" checked="checked" />'.$item.'&nbsp;&nbsp;';
			}else{
				$html .= '<input type="radio" name="'.$name.'" value="'.$key.'" />'.$item.'&nbsp;&nbsp;';
			}
		}
		$html .= '</td></tr>';
		echo $html;
	}
/*
	 * Genarate filter
	 * News solution
	 */
	function create_filter($row,$prefix){
		if(!count($row))
			return;
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
					
					
					$selected_no = $ss_filter === 0? "selected='selected'":"";
					$selected_yes = $ss_filter === 1? "selected='selected'":"";
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
	
    /**
     * Thêm input[type="hidden"]
     */ 
    function addInputHidden($name = '', $key = ''){
        echo '<input type="hidden" name="'.$name.'" value="'.$key.'" />';
    }
}
?>
