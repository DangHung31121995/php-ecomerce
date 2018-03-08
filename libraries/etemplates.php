<?php 
	/*
	 * Write by Pham Van Huy
	 */
?>
<?php 
	class ETemplates
	{
		var $file;
		var $tmpl;
		var $variables;
		var $head_meta_key ;
		var $head_meta_des ;
		var $title;
		var $tmpl_name ;
		var $style = "";
		var $script_top = "";
		var $script_bottom = "";
		var $array_meta = array();
		var $arr_blocks = array();
	    
	    function ETemplates($file = null,$tmpl = null) {
//	    	$global  = new FsGlobal();
			$this -> load_all_block();
			global $econfig;
	    	global $head_meta_key,$head_meta_des,$title,$array_meta;
			$etemplate = $econfig -> etemplate?$econfig -> etemplate:'default';
	    	$this -> tmpl_name =  'estores/'.$etemplate;
	        $this->file = $file;
	        $this->tmpl = $tmpl;
	        $this->head_meta_key = $econfig ->keywords; 
	        $this->head_meta_des = $econfig -> estore_intro; 
	        
	        $title = $econfig -> estore_name;
			$this -> array_meta = $array_meta;
	        $this->title = str_replace(chr(13),'',htmlspecialchars( $title));
	         
	        // default:
	        $this->style = array(); 
	        $this->script_top = array(); 
	        $this->script_bottom = array(); 
	        
			$file_css = URL_ROOT."templates"."/".$this->tmpl_name."/"."css"."/templates.css";
	        array_push($this->style, $file_css);
			
   	  		array_push($this->script_bottom,URL_ROOT."libraries/jquery/jquery_1.4.1.min.js");
//	        array_push($this->script_bottom,URL_ROOT."templates/default/js/main.js");

	        //add plugin
//	        include_once 'plugins/counter/counter.php';
//	        $counter = Counter::updateHit();
	    }
	    function assign($key, $value) {
	        $this->variables[$key] = $value;
	    }
	    function assignRef($key, &$value) {
	        $this->variables[$key] = &$value;
	    }
	    
		function addStylesheet($file,$folder = "")
		{
			if($folder == "")
				$folder_css = URL_ROOT."templates"."/".$this->tmpl_name."/"."css"."/";
			else
				$folder_css = URL_ROOT.$folder."/";
			$path = $folder_css.$file.".css";
			array_push($this->style, $path); 
		}
		function addScript($file,$folder = "",$position  = 'bottom')
		{
			if($folder == "")
				$folder_js = URL_ROOT."templates"."/".$this->tmpl_name."/"."js"."/";
			else
				$folder_js = URL_ROOT.$folder."/";
			$path = $folder_js.$file.".js";	
			
			if($position == 'top'){
				array_push($this->script_top,$path);
	
			} else {
				array_push($this->script_bottom,$path);
			}
		}
		function removeScript($file,$folder = "",$position  = 'bottom'){
			
		}
		
		/*
		 * for site uses multi template
		 * get Template from Itemid in table menus_items 
		 */
//		function getTypeTemplate($Itemid = 1)
//		{
//			$sql = " SELECT template
//						FROM fs_menus_items AS a 
//						WHERE id = '$Itemid' 
//							AND published = 1 ";
//			global $db;
//			$db->query($sql);
//			return   $db->getResult();
//		}
		
		/*
		 * now die
		 */
//		function loadTemplate($tmpl_name = 'default')
//		{
//			ob_start();
//			include('templates/'.$tmpl_name."/index.php");
//			ob_end_flush();
//		}

		function loadMainModule()
		{
			
			//  message when redirect
//			if(isset($_SESSION['msg_redirect']))
//			{
//				$msg_redirect = @$_SESSION['msg_redirect'];
//				$type_redirect = @$_SESSION['type_redirect'];
//				if(!@$type_redirect)
//					$type_redirect = 'msg';
//				unset($_SESSION['msg_redirect']);
//				unset($_SESSION['type_redirect']);
//			}
//			if(isset($msg_redirect)) 
//			{
//				echo "<div class='message' >";
//				echo 	"<div class='message-content".$type_redirect."'>";
//				echo	$msg_redirect; 
//				echo "	</div> </div>";
//				if(isset($_SESSION['have_redirect']))
//				{
//					unset($_SESSION['have_redirect']);
//				}
//			}
			// end message when redirect
	
			$module = FSInput::get('module');
			if(file_exists(PATH_BASE . DS . 'emodules' . DS . $module . DS . $module . '.php'))
			{
				require 'emodules/'.$module.'/'.$module.'.php';
			}
		}
		/*
		 * load Module follow position
		 * type: xhtml, round,... => show around module.
		 */
	
		function load_position($position = '',$type = '')
		{
			$arr_block = $this -> arr_blocks;
			$block_list = isset($arr_block[$position])?$arr_block[$position]:array();
			$i = 0;
			if(!count($block_list))
				return;
			foreach ($block_list as $item) {
				
				$content = $item->content;
				$showTitle = $item -> showTitle;
				$title = $showTitle?$item -> title:'';
				$module_suffix = "";
				
				// load parameters
				$parameters = '';
				include_once 'libraries/parameters.php';
				$parameters = new Parameters($item->params);
				$module_suffix = $parameters->getParams('suffix');
				$title = $item->title;
				$title = $item -> showTitle? $item->title:'';
				$func = 'type'.$type;
				
				if(method_exists('ETemplates',$func))
					$round = $this->$func($title,$module_suffix,$item -> module,$i);
				else 
					$round[0] = $round[1] = "";

				if($item -> module == 'contents'){
					echo $round[0];
					echo $content;
					echo $round[1];
				} else {
					if(file_exists(PATH_BASE . DS . 'eblocks' . DS . $item->module . DS .'controllers' .DS. $item->module . '.php'))
					{
						echo $round[0];
						include_once 'eblocks/'.$item->module.'/controllers/'.$item->module.'.php';
						$c =  ucfirst($item->module).'BControllers'.ucfirst($item->module);
						$controller = new $c();
						$controller->display($parameters,$title);
						echo $round[1];
					}
				}
				$i++;
			}
			
		}
		
		/*
		 * load direct Block , do not use database
		 * this  parameters not use class Paramenters 
		 */
		function load_direct_blocks($module_name = '', $parameters = array())
		{
			include_once 'libraries/parameters.php';
			$parameters = new Parameters($parameters,'array');
			if(file_exists(PATH_BASE .  'eblocks' . DS . $module_name . DS .'controllers' .DS. $module_name . '.php')){
				require_once 'eblocks/'.$module_name.'/controllers/'.$module_name.'.php';
				$c =  ucfirst($module_name).'BControllers'.ucfirst($module_name);
				$controller = new $c();
				$controller->display($parameters,$module_name);
			}
//			if(file_exists(PATH_BASE . DS . 'blocks' . DS . $module_name . DS . $module_name . '.php'))
//				require 'blocks/'.$module_name.'/'.$module_name.'.php';
		}
		
		function count_block($position = '')
		{
			$arr_block = $this -> arr_blocks;
			if(!isset($arr_block[$position]))
				return 0;
			$block_list = $arr_block[$position];
			return count($block_list);
		}
		/*
		 * Load all block by Itemid
		 */
		function load_all_block(){
			global $econfig;
			$estore_id = $econfig ->id;
			$table = 'fs_eblocks';
			$Itemid = FSInput::get('Itemid',1);
			$sql = " SELECT id,title,content, ordering, module, position, showTitle, params
						FROM ".$table ." AS a 
						WHERE published = 1 
							AND estore_id = $estore_id
							AND ( is_buy = 1 OR  buy_expired_time >= NOW() )
							AND (listItemid = 'all'
							OR listItemid = $Itemid
							OR listItemid like '%,$Itemid'
							OR listItemid like '$Itemid,%'
							OR listItemid like '%,$Itemid,%')
							ORDER by ordering";
			global $db;
			$db->query($sql);
			$list =  $db->getObjectList();
			$arr_blocks = array();
			foreach ($list as $item) {
				$arr_blocks[$item -> position ][$item->id] = $item;
			}
			$this -> arr_blocks = $arr_blocks;
		}
		
		
		function loadHeader()
		{
			?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title><?php echo $this->title ; ?></title>
				<meta name='keywords' content='<?php echo $this->head_meta_key; ?>' />
				<meta name='description' content='<?php echo $this->head_meta_des; ?>' /> 
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<link type='image/x-icon' href='<?php echo URL_ROOT."/images/favicon.ico"; ?>' rel='icon' />
				<meta http-equiv='content-language' content='vi'/>
				<meta content='INDEX,FOLLOW' name='robots'>
	            <meta http-equiv='X-UA-Compatible' content='IE=7' />
	            <meta name='CODE_LANGUAGE' content='PHP' />
	            <meta http-equiv='REFRESH' content='3600' />
	          <?php 
			$array_meta = $this -> array_meta ;
			for($i = 0; $i < count($array_meta); $i ++){
				$item = $array_meta[$i];
				$type = $item[0];
				$content = $item[1];
				echo '<meta name=\''.$type.'\' content=\''.$content.'\' />';
			}
			$arr_style = array_unique($this -> style);
			foreach ($arr_style as $item){
				echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"$item\" /> ";
			}
			?>
			<!--[if lte IE 6]>
			<link href="<?php echo URL_ROOT.'templates'.'/'.$this->tmpl_name.'/'; ?>css/ie6.css" media="screen" type="text/css" rel="stylesheet" />
			<![endif]--> 
			
			<!--[if lte IE 7]>
			<link href="<?php echo URL_ROOT.'templates'.'/'.$this->tmpl_name.'/'; ?>css/ie7.css" media="screen" type="text/css" rel="stylesheet" />
			<![endif]--> 
		
			<?php 
			$this -> script_top = array_unique($this -> script_top);
			$arr_script_top = $this -> script_top;
			if(count($arr_script_top)){
				foreach ($arr_script_top as $item){
					echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$item\"></script>";
				}
			}
			 
			global $econfig;
			$style = 'background: ';
			if($econfig->background_style > 1){
				if($econfig->background_style == 2)
					$img = EGlobal::get_background($econfig->background_id);
				else 
					$img = $econfig->background_image;
				$style .= " url('".URL_IMG_BACKGROUND.$img."') ";
			} 
			$style .= $econfig->background_color;
			if($econfig -> background_repeat)
				$style .= ' repeat';		
			else 
				$style .= ' no-repeat fixed ';
				
			?>
			</head>
				<body style="<?php echo $style;?>">
			<?php
			
		}
		function loadFooter(){
			$arr_script_bottom = array_unique($this -> script_bottom);
			$arr_script_top = $this -> script_top;
			$arr_script_bottom = array_diff_assoc($arr_script_bottom, $arr_script_top);
			if(count($arr_script_bottom)){
				foreach ($arr_script_bottom as $item){
					echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$item\"></script>";
				}
			}
			echo '</body></html>';
		}
		
		function typeRound($title = '',$module_suffix = '',$module_name = 'contents', $special_class = '')
		{
			$class = $module_name.' '. $module_name.'_'.$special_class.' blocks'.$module_suffix. ' blocks'.$special_class;
			// head
			$str_top = "<div class='$class'><div><div>" ;
			if($title)
				$str_top .='<h2><span>'.$title.'</span></h2>';
			$html[] = $str_top ;
			$html[] = "</div></div></div>" ;
			return $html;
		}
		
		function typeXHTML($title = '',$module_suffix = '',$module_name = 'contents',$special_class = '')
		{
			$class = $module_name.' '. $module_name.'_'.$special_class.' blocks'.$module_suffix. ' blocks'.$special_class;
			// head
			$str_top = "<div class='$class block'>" ;
			if($title)
				$str_top .='<h2 class="block_title"><span>'.$title.'</span></h2>';
			$html[] = $str_top ;
			$html[] = "</div>" ;
			return $html;
		}
		function typeXHTML1($title = '',$module_suffix = '',$module_name = 'contents',$special_class = '')
		{
			$class = $module_name.' '. $module_name.'_'.$special_class.' blocks'.$module_suffix. ' blocks'.$special_class;
			// head
			$str_top = "<div class='$class block'>" ;
			if($title)
				$str_top .='<h2 class="block_title"><span>'.$title.'</span></h2>';
			$html[] = $str_top ;
			$html[] = "	<div class='content-bottom-left'></div>
						<div class='content-bottom-right'></div></div>" ;
			return $html;
			 
		}
		
		function setTitle($title)
		{
			$this->title = $title; 
		}
		
		/*
		 * add Tittle
		 * if $auto_calculate == 1: 
		 *      calculate: if(new title + old title > 70) : new title 
		 */
		function addTitle($title,$auto_calculate = 1)
		{
			// 65 characters,  15 words.
			global $config;
			if($auto_calculate){
				if((strlen($config['main_title'])+strlen($title)) > 70)
				     $this->title = $title;
				else 
				     $this->title = $title. $config['main_title'];
			} else {
				 $this->title = $title. $config['main_title'];
			}
		}
		function setMetakey($meta_key)
		{
			$this->head_meta_key = $meta_key;
		}
		function setMetades($meta_des)
		{
			$this->head_meta_des = $meta_des;
		}
		// pos: end , begin
		// character: lower
		function addMetakey($meta_key,$pos = 'end',$auto_calculate = 1 )
		{
			// max: 10 words
			// You should only use keywords which can be found in the content of the page
//            $meta_key_word_count = 10;
            if(!$auto_calculate){
                if($pos == 'end')
                    $this->head_meta_key .= ", ".$meta_key;
	            else 
	                $this->head_meta_key = $meta_key.", ".$this->head_meta_key ;
            } else {
                
	            $meta_key_char_count = 80;
	            $str_title = '';
	            $meta_key = str_replace(', ',',',$meta_key);
	            if(strlen($meta_key) > $meta_key_char_count){
	            	$arr_metakey = explode(',',$meta_key);
	            	array_unique($arr_metakey);
	            	$i = 0;
	            	while($i < count($arr_metakey) &&  strlen($str_title) < $meta_key_char_count ){
	            		if(!$i)
	            		      $str_title .=  trim($arr_metakey[$i]);
	            		else {
	            			if(strlen($str_title.','.trim($arr_metakey[$i])) >  $meta_key_char_count)
	            			    break;  
	            		    $str_title .=  ','.trim($arr_metakey[$i]);	
	            		}
	            		$i ++;
	            	}
	            } else {
	            	$str_title = $meta_key;
	                $arr_metakey_old = explode(',',$this->head_meta_key);
	                $i = 0;
	                while($i < count($arr_metakey_old) &&  strlen($str_title) < $meta_key_char_count ){
	                    if(strlen($str_title.','.$arr_metakey_old[$i]) >  $meta_key_char_count)
	                       break;  
	                    if($pos == 'end')
	                        $str_title .=  ','.trim($arr_metakey_old[$i]);  
	                    else 
	                        $str_title .=  trim($arr_metakey_old[$i]).','.$str_title;       
	                    $i ++;
	                }
	            }
	            $this->head_meta_key = mb_strtolower($str_title,'UTF-8');
            }
		}
		// pos: end , begin
		function addMetades($meta_des,$pos = 'pre')
		{
			//maximum  30 keywords or 150 characters.
			if($pos == 'pre'){
				if($meta_des)
			         $this->head_meta_des = $meta_des.",".$this->head_meta_des ;
			    else 
			          $this->head_meta_des = $this->head_meta_des ;       
			}else{ 
                $this->head_meta_des .= ",".$meta_des;
			}				
		    $meta_key_char_count = 30;
		    
		    $this->head_meta_des = getWord ($meta_key_char_count,$this->head_meta_des); 
		}
		
		function setMeta($type,$content){
			$array_meta = isset($this -> array_meta)?$this -> array_meta:array();
			$new_meta = array();
			$new_meta[0] = $type;
			$new_meta[1] = $content;
			$array_meta[] = $new_meta;
			$this -> array_meta = $array_meta;
		}
		
		
	}
?>