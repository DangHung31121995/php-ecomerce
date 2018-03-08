<?php
define('LINK_AMIN', dirname(__file__));
$system_path = $_SERVER['DOCUMENT_ROOT'];
if (realpath($system_path) !== FALSE){
    $system_path = realpath($system_path).'/';
}
// ensure there's a trailing slash
$system_path = rtrim($system_path, '/').'/';
define('PATH_BASE', str_replace("\\", "/", $system_path));
/* Định nghĩa path admin */
$admin_path = dirname(__file__);
if (realpath($admin_path) !== FALSE){
    $admin_path = realpath($admin_path).'/';
}
$admin_path = rtrim($admin_path, '/');
define('PATH_ADMINISTRATOR', str_replace("\\", "/", $admin_path));
$admin_folder = str_replace(PATH_BASE, "", PATH_ADMINISTRATOR);
define('URL_ADMIN', 'http://'.$_SERVER['HTTP_HOST'].'/'.$admin_folder.'/');
/* Khởi tạo session */
ini_set('session.gc_maxlifetime', 1000000);
session_start();
/* if(!empty($_SESSION['ad_logged'])){
	session_regenerate_id(true);
}*/
require(PATH_BASE.'config/config.php');
require(PATH_BASE.'config/defines.php');
require(PATH_BASE.'libraries/functions.php');
require(PATH_BASE.'libraries/fsinput.php');
require(PATH_BASE.'libraries/fstext.php');
require(PATH_BASE.'libraries/fsrouter.php');
require(PATH_BASE.'libraries/database/mysql.php');
require(PATH_BASE.'libraries/errors.php');
require(PATH_BASE.'libraries/fsfactory.php');
require(PATH_BASE.'libraries/ckeditor/fckeditor.php');
$db = new Mysql_DB();
$lang_request = FSInput::get('adlang');
if ($lang_request){
    $_SESSION['adlang'] = $lang_request;
} else{
    $_SESSION['adlang'] = isset($_SESSION['adlang']) ? $_SESSION['adlang'] : 'vi';
}
define('SQL_FILTER_BY_ADLANG', ' AND lang = \''.$_SESSION['adlang'].'\'');
define('URL_LANG', URL_ROOT.$_SESSION['adlang'] . "/");
$module = FSInput::get('module', 'home');
$translate = FSText::load_languages('backend', $_SESSION['adlang'], $module);
require_once ("libraries/toolbar/toolbar.php");
require_once ("libraries/pagination.php");
require_once ("libraries/template_helper.php");
require_once ("libraries/fssecurity.php");
require_once ('libraries/controllers.php');
require_once ('libraries/models.php');
require_once ('libraries/controllers_categories.php');
require_once ('libraries/models_categories.php');
$loginpath = "login.php";
if (!isset($_SESSION["ad_logged"]) || $_SESSION["ad_logged"] != 1){
    header("Location: login.php");
}
function loadMainContent($module){
    if($module){
        if(!isset($_GET['module'])) $_GET['module'] = 'home';
        $view = FSInput::get('view', $module);
        $task = FSInput::get('task', 'display');
        $task = $task ? $task : 'display';
        $path = PATH_ADMINISTRATOR . DS . 'modules' . DS . $module . DS . 'controllers' . DS . $view . ".php";
        if (!file_exists($path))
            die(FSText::_("Not found controller"));
        require_once $path;
        $c = ucfirst($module) . 'Controllers' . ucfirst($view);
        $controller = new $c();
        $permission = FSSecurity::check_permission($module, $view, $task);
        if (!$permission){
            echo FSText::_("Bạn không có quyền thực hiện chức năng này");
            return;
        }
        $controller->$task();
    }
}
$toolbar = new ToolbarHelper();
ob_start();
loadMainContent($module);
$main_content = ob_get_contents();
ob_end_clean();
$raw = FSInput::get('raw');
$print = FSInput::get('print');
if ($raw){
    echo $main_content;
}else{
    if ($print)
        include_once ("templates/default/print.php");
    else
        include_once ("templates/default/index.php");
}
?>