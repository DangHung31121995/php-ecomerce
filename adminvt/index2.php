<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
$system_path = $_SERVER['DOCUMENT_ROOT'];
if (realpath($system_path) !== FALSE){
    $system_path = realpath($system_path).'/';
}
// ensure there's a trailing slash
$system_path = rtrim($system_path, '/').'/';
define('PATH_BASE', str_replace("\\", "/", $system_path));
session_start();
require_once (PATH_BASE."config/config.php");
require_once (PATH_BASE."config/defines.php");
require_once (PATH_BASE."libraries/functions.php");
require_once (PATH_BASE."libraries/fsinput.php");
require_once (PATH_BASE."libraries/fstext.php");
require_once (PATH_BASE.'libraries/database/mysql.php');
$db = new Mysql_DB();
// language
$lang_request = FSInput::get('lang');
if ($lang_request)
{
    $_SESSION['lang'] = $lang_request;
} else
{
    $_SESSION['lang'] = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
}
$module = FSInput::get('module');
$translate = FSText::load_languages('backend', $_SESSION['lang'], $module);
require_once ("libraries/toolbar/toolbar.php");
require_once ("../libraries/fsrouter.php");
require_once ("libraries/pagination.php");
require_once ("libraries/template_helper.php");
require_once ('../libraries/errors.php');
require_once ('../libraries/fsfactory.php');
require_once ('libraries/controllers.php');
require_once ('libraries/models.php');
define('PATH_ADMINISTRATOR', dirname(__file__));
/* Task của uploadify */
$freeTask = array(
                'uploadProductImages',
                'getProductImages'
            );
$task = FSInput::get('task');
if(!in_array($task, $freeTask)){
    $loginpath = "login.php";
    if (!isset($_SESSION["ad_logged"]) || ($_SESSION["ad_logged"] != 1))
    {
        header("Location: login.php");
    }
}
/**
* function Load Main content
*/
function loadMainContent($module)
{
    if ($module)
    {
        $view = FSInput::get('view', $module);
        $path = PATH_ADMINISTRATOR . DS . 'modules' . DS . $module . DS . 'controllers' .
            DS . $view . ".php";
        if (!file_exists($path))
            die(FSText::_("Not found controller"));
        require_once $path;
        $c = ucfirst($module) . 'Controllers' . ucfirst($view);
        $controller = new $c();
        $task = FSInput::get('task');
        $task = $task ? $task : 'display';
        $controller->$task();
    }
}
// load main content
ob_start();
loadMainContent($module);
$main_content = ob_get_contents();
ob_end_clean();
$raw = FSInput::get('raw');
if ($raw)
{
    echo $main_content;
} else
{
    include_once ("templates/default/index2.php");
}
?>