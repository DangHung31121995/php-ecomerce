<?php 
function login(){
	$db = new Mysql_DB();
	$password = md5(FSInput::get('password'));
	$username = FSInput::get('username');
	$db->query('SELECT u.id, u.username, u.email, g.groupid
                FROM fs_users AS u
                    INNER JOIN fs_users_groups AS g ON u.id = g.userid
                WHERE u.username = \''.$username.'\' AND u.password = \''.$password.'\'
                LIMIT 1');
	$user = $db->getObject();
	if(!$user){
		return false;
	}
	$_SESSION['ad_logged']     = 1;
	$_SESSION['ad_userid']     = $user->id;
    $_SESSION['ad_groupid']    = $user->groupid;
    $_SESSION['ad_username']   = $user->username;
    $_SESSION['ad_useremail']  = $user->email;
	return true;
}
$system_path = $_SERVER['DOCUMENT_ROOT'];
if (realpath($system_path) !== FALSE){
    $system_path = realpath($system_path).'/';
}
// ensure there's a trailing slash
$system_path = rtrim($system_path, '/').'/';
define('PATH_BASE', str_replace("\\", "/", $system_path));
define('URL_ROOT', "http://" . $_SERVER['HTTP_HOST'] . "/");
session_start();
if(isset($_SESSION['ad_logged']) && $_SESSION['ad_logged']==1)
    header("Location: index.php");
require_once(PATH_BASE.'config/config.php');
require_once(PATH_BASE.'libraries/database/mysql.php');
require_once(PATH_BASE.'libraries/fsinput.php');
$action		= FSInput::get('action');
if($action == "login"){
	if(!login()){
        echo '<script type="text/javascript">alert(\'Tên đăng nhập hoặc mật khẩu không đúng!\')</script>';
	}	
	else{
		header( "Location: index.php" );
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="copyright" content="© 2013 FinalStyle, Thiết kế website Phong Cách Số" /> 
    <meta name="robots" content="noindex, nofollow"/>
    <link rel="shortcut icon" href="templates/default/images/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="templates/default/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="templates/default/css/login.css" />
    <script type="text/javascript" src="<?php echo URL_ROOT; ?>libraries/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="templates/default/js/helper.js"></script>
    <script type="text/javascript" src="templates/default/js/charCount/charCount.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#usermane').focus();
            init_position_box($('#login-from'));
        	$(window).resize(function () {	 
                init_position_box($('#login-from'));
        	});
        });
    </script>
</head>
<body>
    <div id="login-from">
        <form action="login.php" method="post" name="frm_login" id="frm_login" autocomplete="off">
            <input class="txt_login" type="text" name="username" id="usermane" autocomplete="off" />
            <input class="txt_login" type="password" name="password" id="password" autocomplete="off" />
            <input name="action" type="hidden" value="login"/>
            <input type="submit" value="Login" />
        </form>
        <div class="copyright">Copyright © 2005-<?php echo date('Y');?> <a href="http://finalstyle.com" title="Thiết kế website, Thiết kế website chuyên nghiệp">FinalStyle</a>. Version 2.0</div>
    </div><!--end: #login-from-->
</body>
</html>