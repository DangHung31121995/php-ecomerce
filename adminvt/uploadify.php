<?php
$alowTask = array(
                'uploadProductImages',
                'getProductImages',
            );
define('PATH_ADMINISTRATOR', str_replace("\\", "/", rtrim(dirname(__file__), '/') . '/'));
define('PATH_BASE', str_replace("\\", "/", rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/'));
require_once (PATH_BASE.'config/config.php');
require_once (PATH_BASE.'config/defines.php');
require_once (PATH_BASE.'libraries/functions.php');
require_once (PATH_BASE.'libraries/fsinput.php');
require_once (PATH_BASE.'libraries/fstext.php');
require_once (PATH_BASE.'libraries/database/mysql.php');
require_once (PATH_BASE.'libraries/errors.php');
require_once (PATH_BASE.'libraries/fsfactory.php');
require_once (PATH_BASE.'libraries/fsrouter.php');
require_once (PATH_ADMINISTRATOR.'libraries/toolbar/toolbar.php');
require_once (PATH_ADMINISTRATOR.'libraries/pagination.php');
require_once (PATH_ADMINISTRATOR.'libraries/template_helper.php');
require_once (PATH_ADMINISTRATOR.'libraries/controllers.php');
require_once (PATH_ADMINISTRATOR.'libraries/models.php');
$module = FSInput::get('module');
$view = FSInput::get('view', $module);
$path = PATH_ADMINISTRATOR . 'modules' . DS . $module . DS . 'controllers' . DS . $view . ".php";
if (!file_exists($path))
    die(FSText::_("Not found controller"));
require_once($path);
$class = ucfirst($module) . 'Controllers' . ucfirst($view);
$controller = new $class();
$task = FSInput::get('task');
if(!in_array($task, $alowTask))
    $task = 'display';
$controller->$task();