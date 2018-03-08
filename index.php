<?php 
$system_path = $_SERVER['DOCUMENT_ROOT'];
if (realpath($system_path) !== FALSE){
    $system_path = realpath($system_path).'/';
}
// ensure there's a trailing slash
$system_path = rtrim($system_path, '/').'/';
define('PATH_BASE', str_replace("\\", "/", $system_path));
//require(PATH_BASE.'libraries/antiddos.php');
if (!isset($_SESSION)){
    session_start();
}
require(PATH_BASE.'config/defines.php');
require(PATH_BASE.'config/config.php');
require(PATH_BASE.'libraries/functions.php');
require(PATH_BASE.'libraries/fsfactory.php');
require(PATH_BASE.'libraries/fsinput.php');
require(PATH_BASE.'libraries/fstext.php');
require(PATH_BASE.'libraries/fstable.php');
require(PATH_BASE.'libraries/fsrouter.php');
require(PATH_BASE.'libraries/fscontrollers.php');
require(PATH_BASE.'libraries/fsmodels.php');
require(PATH_BASE.'libraries/database/mysql.php');
require(PATH_BASE.'libraries/Mobile_Detect.php');
require(PATH_BASE.'libraries/fsuser.php');
require(PATH_BASE.'libraries/PHPExcel/PHPExcel.php');
require(PATH_BASE.'libraries/PhpWord/Autoloader.php');
/* Phiên bản mobile */
$detect = new Mobile_Detect;
if($detect->isMobile() || $detect->isTablet())
    define('IS_MOBILE', 0);
else
    define('IS_MOBILE', 0);
/* Ngôn ngữ website */
$lang_request = FSInput::get('lang');
if($lang_request){
    $_SESSION['lang']  = $lang_request;
} else {
    $_SESSION['lang'] = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';
}
if(MULTI_LANGUAGE){
    define('URL_LANG', URL_ROOT.$_SESSION['lang'] . "/");
}else{
    define('URL_LANG', URL_ROOT);
}

$raw = FSInput::get('raw');
$print = FSInput::get('print');
$db = new Mysql_DB();
$module = FSInput::get('module', 'home');
$translate = FSText::load_languages('fontend', $_SESSION['lang'], $module);
$user = new FSUser();

require(PATH_BASE.'config/common.php');

if($user->userID == 1)
    define('IS_ADMIN', 1);
else
    define('IS_ADMIN', 0);

if ($raw){
    ob_start();
    loadMainContent($module);
    $main_content = ob_get_contents();
    ob_end_clean();
    echo $main_content;
}else{
    require(PATH_BASE.'libraries/counter.php'); //Đếm số người truy cập
    $createCache = false;
    if(USE_CACHE && !isset($_SESSION['cart'])){
        $requestUri = $_SERVER['REQUEST_URI'];
        $fileCache = PATH_BASE.'cache/'.$module.(IS_MOBILE?'-m':'').'-'.md5($module.'-'.$requestUri).'.html';
        if(file_exists($fileCache) && ((time() - filemtime($fileCache)) < 600)){
            require($fileCache);die;
        }else{
            $createCache = true;
        }
    }
    $global_class = FSFactory::getClass('FsGlobal');
    $config = $global_class->get_all_config();
    require(PATH_BASE.'libraries/templates.php');
    global $tmpl;
    $tmpl = new Templates();
    /* Phiên bản mobile */
    if(IS_MOBILE)
        $tmpl->tmpl_name = 'mobile';
    ob_start();
    loadMainContent($module);
    $main_content = ob_get_contents();
    ob_end_clean();
    if ($print){
        require(PATH_BASE.'templates/'.$tmpl->tmpl_name.'/print.php');
        die;
    }
    ob_start();
    require(PATH_BASE.'templates/'.$tmpl->tmpl_name.'/index.php');
    $all_website_content = ob_get_contents();
    ob_end_clean();
    ob_start();
    $tmpl->loadHeader();
    echo $all_website_content;
    $tmpl->loadFooter();
    /* tạo file cache. */
    if($createCache){
        $cacheContent = ob_get_contents();
        writeFile($fileCache, $cacheContent);
    }
}
?>