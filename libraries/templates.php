<?php
class Templates{
    var $file;
    var $tmpl;
    var $variables;
    var $head_meta_key;
    var $head_meta_des;
    var $title;
    var $tmpl_name = "default";
    var $style = "";
    var $script_top = "";
    var $script_bottom = "";
    var $array_meta = array();
    var $arr_blocks = array();
    var $display_position = 0;
    function Templates($file = null, $tmpl = null){
        $this->load_all_block();
        global $config;
        global $head_meta_key, $head_meta_des, $title, $array_meta;
        $this->file = $file;
        $this->tmpl = $tmpl;
        $this->head_meta_key = isset($config['mate_key']) ? $config['mate_key'] : '';
        $this->head_meta_des = isset($config['meta_des']) ? $config['meta_des'] : '';
        $title = isset($config['title']) ? $config['title'] : '';
        $this->array_meta = $array_meta;
        $this->title = str_replace(chr(13), '', htmlspecialchars($title));
        $this->style = array();
        $this->script_top = array();
        $this->script_bottom = array();
        //if(md5($_SERVER['SERVER_NAME']) != $config['license'] && $_SERVER['SERVER_NAME'] != 'localhost') die();
        $display_position = FSInput::get('tmpl', 0, 'int');
        $this->display_position = $display_position;
        $this->tmpl_name = 'default';
    }
    function assign($key, $value){
        $this->variables[$key] = $value;
    }
    function assignRef($key, &$value){
        $this->variables[$key] = &$value;
    }
    function get_variables($key){
        return isset($this->variables[$key]) ? $this->variables[$key] : '';
    }
    function addStylesheet($file, $folder = ""){
        if ($folder == "")
            $folder_css = URL_ROOT."templates"."/".$this->tmpl_name."/"."css"."/";
        else
            $folder_css = URL_ROOT . $folder . "/";
        $path = $folder_css . $file . ".css";
        array_push($this->style, $path);
    }
    function addScript($file, $folder = "", $position = 'bottom'){
        if ($folder == "")
            $folder_js = URL_ROOT . "templates" . "/" . $this->tmpl_name . "/" . "js" . "/";
        else{
            if (strpos($folder, 'http') !== false){
                $folder_js = $folder . "/";
            } else{
                $folder_js = URL_ROOT . $folder . "/";
            }
        }
        $path = $folder_js . $file . ".js";
        if ($position == 'top'){
            array_push($this->script_top, $path);
        } else{
            array_push($this->script_bottom, $path);
        }
    }
    function getTypeTemplate($Itemid = 1)
    {
        $sql = "SELECT template
				FROM fs_menus_items AS a 
				WHERE id = '$Itemid' 
				AND published = 1 ";
        global $db;
        $db->query($sql);
        return $db->getResult();
    }
    function loadTemplate($tmpl_name = 'default'){
        ob_start();
        include ('templates/' . $tmpl_name . "/index.php");
        ob_end_flush();
    }
    function loadMainModule()
    {
        if (isset($_SESSION['msg_redirect']))
        {
            $msg_redirect = @$_SESSION['msg_redirect'];
            $type_redirect = @$_SESSION['type_redirect'];
            if (!@$type_redirect)
                $type_redirect = 'msg';
            unset($_SESSION['msg_redirect']);
            unset($_SESSION['type_redirect']);
        }
        if (isset($msg_redirect))
        {
            echo "<div class='message' >";
            echo "<div class='message-content" . $type_redirect . "'>";
            echo $msg_redirect;
            echo "	</div> </div>";
            if (isset($_SESSION['have_redirect']))
            {
                unset($_SESSION['have_redirect']);
            }
        }
        $module = FSInput::get('module');
        if (file_exists(PATH_BASE . DS . 'modules' . DS . $module . DS . $module .
            '.php'))
        {
            require 'modules/' . $module . '/' . $module . '.php';
        }
    }
    function load_position($position = '', $type = '')
    {
        if ($this->display_position)
        {
            echo 'Position : ' . $position;
            return;
        }
        $arr_block = $this->arr_blocks;
        $block_list = isset($arr_block[$position]) ? $arr_block[$position] : array();
        $i = 0;
        $contents = '';
        if (!count($block_list))
            return;
        foreach ($block_list as $item)
        {
            $content = $item->content;
            $showTitle = $item->showTitle;
            $title = $showTitle ? $item->title : '';
            $module_suffix = "";
            $parameters = '';
            include_once 'libraries/parameters.php';
            $parameters = new Parameters($item->params);
            $module_suffix = $parameters->getParams('suffix');
            $title = $item->title;
            $title = $item->showTitle ? $item->title : '';
            $func = 'type' . $type;
            if (method_exists('Templates', $func))
                $round = $this->$func($title, $module_suffix, $item->module, $i);
            else
                $round[0] = $round[1] = "";
            if ($item->module == 'contents')
            {
                echo $round[0];
                echo $content;
                echo $round[1];
            } else
            {
                if (file_exists(PATH_BASE . DS . 'blocks' . DS . $item->module . DS .'controllers' . DS . $item->module . '.php'))
                {
                    echo $round[0];
                    include_once 'blocks/' . $item->module . '/controllers/' . $item->module.'.php';
                    $c = ucfirst($item->module) . 'BControllers' . ucfirst($item->module);
                    $controller = new $c();
                    $controller->display($parameters, $item->title, $item->id);
                    echo $round[1];
                }
            }
            $i++;
        }
        return $contents;
    }
    function load_direct_blocks($module_name = '', $parameters = array())
    {
        if ($this->display_position)
        {
            echo 'Block : ' . $module_name;
            return;
        }
        include_once 'libraries/parameters.php';
        $parameters = new Parameters($parameters, 'array');
        if (file_exists(PATH_BASE . 'blocks' . DS . $module_name . DS . 'controllers' . DS . $module_name . '.php'))
        {
            require_once 'blocks/' . $module_name . '/controllers/' . $module_name . '.php';
            $c = ucfirst($module_name) . 'BControllers' . ucfirst($module_name);
            $controller = new $c();
            $controller->display($parameters, $module_name);
        }
    }
    function count_block($position = '')
    {
        if ($this->display_position)
        {
            return 1;
        }
        $arr_block = $this->arr_blocks;
        if (!isset($arr_block[$position]))
            return 0;
        $block_list = $arr_block[$position];
        return count($block_list);
    }
    function load_all_block()
    {
        $str_where = '';
        $table = FSTable::_('fs_blocks');
        $Itemid = FSInput::get('Itemid', 1, 'int');
        $module = FSInput::get ('module', 'home', '');
		$ccode  = FSInput::get ('ccode', '', 'str');
        if($module != 'home' && $ccode != '')
            $str_where = ' AND (module_categories = \'all\' OR module_categories like \'%,'.$module.'_'.$ccode.',%\')';
        $sql = "SELECT id, title, content, ordering, module, position, showTitle, params , listItemid, module_categories
				FROM " . $table . " AS a 
				WHERE published = 1 
				AND (listItemid = 'all'
				OR listItemid like '%,$Itemid,%') $str_where
				ORDER by ordering";
        global $db;
        $db->query($sql);
        $list = $db->getObjectList();
        $arr_blocks = array();
        foreach ($list as $item)
        {
            $arr_blocks[$item->position][$item->id] = $item;
        }
        $this->arr_blocks = $arr_blocks;
    }
    function loadHeader(){
        global $config;
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
        echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi-vn" lang="vi-vn">'."\n";
        echo '<head>'."\n";
        echo '    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n";
        echo '    <title>'.$this->title.'</title>'."\n";
        echo '    <meta name="keywords" content="'.$this->head_meta_key.'" />'."\n";
        echo '    <meta name="description" content="'.$this->head_meta_des.'" />'."\n"; 
        echo '    <meta name="robots" content="index,follow,all" />'."\n"; 
        echo '    <meta name="language" content="Vietnamese" />'."\n"; 
        echo '    <meta property="og:type" content="article"/>'."\n"; 
        echo '    <meta property="og:title" content="'.$this->title.'"/>'."\n"; 
        echo '    <meta property="og:description" content="'.$this->head_meta_des.'" />'."\n"; 
        echo '    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" />'."\n"; 
        echo '    <meta property="article:published_time" content="2014-09-15" />'."\n"; 
        echo '    <meta property="og:sitename" content="'.$config['title'].'" />'."\n"; 
        echo '    <meta name="revisit-after" content="1 days" />'."\n"; 
        echo '    <meta name="geo.position" content="10.838574,106.672846" />'."\n"; 
        echo '    <meta name="geo.placename" content="TPHCM" />'."\n"; 
        echo '    <meta name="geo.region" content="VN-65" />'."\n"; 
        echo '    <link type="image/x-icon" href="/favicon.ico" rel=\'icon\' />'."\n";
        echo '    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width" />'."\n";
        //echo '    <meta property="fb:app_id" content="941186415895211"/>'."\n";
        echo '    <meta name="copyright" content="Thiết kế web http://finalstyle.com">'."\n";
        echo '    <meta name="developer" content="Trần Văn Giang, vangiangfly@gmail.com">'."\n";
        echo '    <meta name="author" content="www.miski.vn"/>'."\n";
        //echo '    <link href="https://plus.google.com/u/0/104910649080739916783/about" rel="author"/>'."\n";
        //echo '    <link href="https://plus.google.com/u/0/104910649080739916783/posts" rel="publisher"/>'."\n";
        echo '    <link rel="canonical" href="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" />'."\n";
        // echo '    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all">'."\n";
        $array_meta = $this->array_meta;
        for ($i = 0; $i < count($array_meta); $i++)
        {
            $item = $array_meta[$i];
            $type = $item[0];
            $content = $item[1];
            echo '<meta name=\'' . $type . '\' content=\'' . $content . '\' />';
        }
        $arr_style = array_unique($this->style);
        foreach ($arr_style as $item)
        {
            echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"$item\" />\n";
        }
        echo '<script type="text/javascript" src="'.URL_ROOT.'libraries/jquery/jquery.min.js"></script>'."\n";
        echo '<script type="text/javascript" src="/libraries/jquery/jquery-migrate-1.2.1.js"></script>'."\n";
        $this->script_top = array_unique($this->script_top);
        $arr_script_top = $this->script_top;
        if (count($arr_script_top))
        {
            foreach ($arr_script_top as $item)
            {
                echo "<script type=\"text/javascript\" src=\"$item\"></script>\n";
            }
        }
		echo '</head>'."\n";
		echo '<body>'."\n";
    }
    
    function loadFooter()
    {
        $arr_script_bottom = array_unique($this->script_bottom);
        $arr_script_top = $this->script_top;
        $arr_script_bottom = array_diff_assoc($arr_script_bottom, $arr_script_top);
        if (count($arr_script_bottom))
        {
            foreach ($arr_script_bottom as $item)
            {
                echo "\n"."<script type=\"text/javascript\" src=\"$item\"></script>";
            }
        }
        $sql = "SELECT value
				FROM fs_config
				WHERE name = 'google_analytics'";
        global $db;
        $db->query($sql);
        $google_analytic = $db->getResult();
        echo $google_analytic . "\n".'</body>'."\n".'</html>';
    }
    function typeRound($title = '', $module_suffix = '', $module_name = 'contents', $special_class = ''){
        $class = $module_name . ' ' . $module_name . '_' . $special_class . ' blocks' .$module_suffix . ' blocks' . $special_class;
        $str_top = "<div class='$class'><div><div>";
        if ($title)
            $str_top .= '<h2><span>' . $title . '</span></h2>';
        $html[] = $str_top;
        $html[] = "</div></div></div>";
        return $html;
    }
    function typeXHTML($title = '', $module_suffix = '', $module_name = 'contents', $special_class = '')
    {
        $class = 'block_' . $module_name . ' ' . $module_name . '_' . $special_class . ' blocks' . $module_suffix . ' blocks' . $special_class;
        $str_top = "<div class='$class block'>";
        if ($title)
            $str_top .= '<h2 class="block_title"><span>' . $title . '</span></h2>';
        $html[] = $str_top;
        $html[] = "</div>";
        return $html;
    }
    function typeXHTML3($title = '', $module_suffix = '', $module_name = 'contents', $special_class = '')
    {
        $class = 'block_' . $module_name . ' ' . $module_name . '_' . $special_class . ' blocks' . $module_suffix . ' blocks' . $special_class;
        $str_top = "<div class='$class block'>";
        if ($title)
            $str_top .= '<h2 class="block_title"><span class="icon">&nbsp;</span><span class="title">' .
                $title . '</span></h2>';
        $html[] = $str_top;
        $html[] = "</div>";
        return $html;
    }
    function typeXHTML2($title = '', $module_suffix = '', $module_name = 'contents', $special_class = '')
    {
        $class = 'block_' . $module_name . ' ' . $module_name . '_' . $special_class .' blocks' . $module_suffix . ' blocks' . $special_class;
        $str_top = "<div class='$class block'>";
        $html[] = $str_top;
        $html[] = "</div>";
        return $html;
    }
    function type3Block($module_suffix = '', $special_class = '')
    {
        $class = 'blocks' . $module_suffix . ' blocks' . $special_class;
        $html[] = "<div class='$class one-column'>";
        $html[] = "</div>  ";
        return $html;
    }
    function setTitle($title)
    {
        $this->title = $title;
    }
    function addTitle($title, $auto_calculate = 1)
    {
        global $config;
        if ($auto_calculate)
        {
            if ((strlen($config['main_title']) + strlen($title)) > 70)
                $this->title = $title;
            else
                $this->title = $title . $config['main_title'];
        } else
        {
            $this->title = $title . $config['main_title'];
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
    function addMetakey($meta_key, $pos = 'end', $auto_calculate = 1){
        if (!$auto_calculate)
        {
            if ($pos == 'end')
                $this->head_meta_key .= ", " . $meta_key;
            else
                $this->head_meta_key = $meta_key . ", " . $this->head_meta_key;
        } else
        {
            $meta_key_char_count = 50;
            $str_title = '';
            $meta_key = str_replace(', ', ',', $meta_key);
            if (strlen($meta_key) > $meta_key_char_count)
            {
                $arr_metakey = explode(',', $meta_key);
                $i = 0;
                while ($i < count($arr_metakey) && strlen($str_title) < $meta_key_char_count)
                {
                    if (!$i)
                        $str_title .= trim($arr_metakey[$i]);
                    else
                    {
                        if (strlen($str_title . ',' . trim($arr_metakey[$i])) > $meta_key_char_count)
                            break;
                        $str_title .= ',' . trim($arr_metakey[$i]);
                    }
                    $i++;
                }
            } else
            {
                $str_title = $meta_key;
                $arr_metakey_old = explode(',', $this->head_meta_key);
                $i = 0;
                while ($i < count($arr_metakey_old) && strlen($str_title) < $meta_key_char_count)
                {
                    if (strlen($str_title . ',' . $arr_metakey_old[$i]) > $meta_key_char_count)
                        break;
                    if ($pos == 'end')
                        $str_title .= ',' . trim($arr_metakey_old[$i]);
                    else
                        $str_title .= trim($arr_metakey_old[$i]) . ',' . $str_title;
                    $i++;
                }
            }
            $this->head_meta_key = mb_strtolower($str_title, 'UTF-8');
        }
    }
    function addMetades($meta_des, $pos = 'pre')
    {
        /*if ($pos == 'pre')
        {
            if ($meta_des)
                $this->head_meta_des = $meta_des . "," . $this->head_meta_des;
            else
                $this->head_meta_des = $this->head_meta_des;
        } else
        {
            $this->head_meta_des .= "," . $meta_des;
        }
        $meta_key_char_count = 30;
        $this->head_meta_des = getWord($meta_key_char_count, $this->head_meta_des);*/
        $this->head_meta_des = $meta_des;
    }
    function setMeta($type, $content)
    {
        $array_meta = isset($this->array_meta) ? $this->array_meta : array();
        $new_meta = array();
        $new_meta[0] = $type;
        $new_meta[1] = $content;
        $array_meta[] = $new_meta;
        $this->array_meta = $array_meta;
    }
    function get_background()
    {
        $sql = "SELECT *
				FROM fs_backgrounds AS a 
				WHERE is_default = 1 
				AND published = 1 ";
        global $db;
        $db->query($sql);
        return $db->getObject();
    }
}
?>