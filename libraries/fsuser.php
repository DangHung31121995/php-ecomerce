<?php
/**
 * @author vangiangfly
 * @copyright 2014
 */
class FSUser{
    /**
     * Thời gian lưu cookie
     * Int
     */ 
    var $remTime = 2592000;//1 tháng
    
    /**
     * Tên được lưu cookie
     * String
     */ 
    var $remCookieName = 'fsSavePass';
    
    /**
    * Domain
    * String
    */
    var $remCookieDomain = '';

    /**
     * Tên được lưu session
     * String
     */ 
    var $sessionVariable = 'userSessionValue';
    
    /**
     * Kiểu mã hóa pas
     */ 
    var $passMethod = 'sha1';
    
    /**
     * ID của user
     * Int
     */ 
    var $userID;
    
    /**
     * Toàn bộ thông tin người dùng
     * Object
     */ 
    var $userInfo;
    
    /**
     * Bảng User
     * String
     */
    var $tbStore = 'fs_members';
     
    /**
     * Hiển thị thông báo lỗi
     * Boolean
     */ 
    var $displayErrors = true;
    
    function __construct(){
        $this->remCookieDomain = $this->remCookieDomain == '' ? $_SERVER['HTTP_HOST'] : $this->remCookieDomain;
        
        if( !isset( $_SESSION ) ) session_start();
        
        if ( !empty($_SESSION[$this->sessionVariable])){
    	    $this->loadUser( $_SESSION[$this->sessionVariable] );
        }
        
        //Maybe there is a cookie?
        if ( isset($_COOKIE[$this->remCookieName]) && !$this->is_loaded()){
          $u = unserialize(base64_decode($_COOKIE[$this->remCookieName]));
          $this->login($u['uname'], $u['password']);
        }
    }
    
    /**
    * Đăng nhập
    * @param string $uname
    * @param string $password
    * @param bool $loadUser
    * @return bool
    */
    function login($uname, $password, $remember = false, $loadUser = true){
        global $db;
    	$uname    = $this->escape($uname);
    	$password = $originalPassword = $this->escape($password);
    	switch(strtolower($this->passMethod)){
    	  case 'sha1':
    	  	$password = "SHA1('$password')"; break;
    	  case 'md5' :
    	  	$password = "MD5('$password')";break;
    	  case 'nothing':
    	  	$password = "'$password'";
    	}
    	$db->query("SELECT * FROM `".$this->tbStore."` 
    	WHERE (`username` = '$uname' OR `email` = '$uname') AND `password` = $password LIMIT 1");
        $user = $db->getObject();
    	if ( !$user )
    		return false;
    	if ( $loadUser )
    	{
            session_regenerate_id();
    		$this->userInfo = $user;
    		$this->userID = $user->id;
    		$_SESSION[$this->sessionVariable] = $this->userID;
    		if ( $remember ){
    		  $cookie = base64_encode(serialize(array('uname'=>$uname,'password'=>$originalPassword)));
    		  $a = setcookie($this->remCookieName, 
    		  $cookie,time()+$this->remTime, '/', $this->remCookieDomain);
    		}
    	}
    	return true;
    }
    
    /**
    * Thoát
    * param string $redirectTo
    * @return bool
    */
    function logout($redirectTo = ''){
        setcookie($this->remCookieName, '', time()-3600);
        $_SESSION[$this->sessionVariable] = '';
        $this->userData = '';
        if ( $redirectTo != '' && !headers_sent()){
            header('Location: '.$redirectTo );
            exit;//To ensure security
        }
    }
    
    /**
    * Thêm tài khoản: 'database field' => 'value'
    * @param array $data
    * @return int
    */ 
    function insertUser($data){
        global $db;
        if (!is_array($data)) $this->error('Data is not an array', __LINE__);
        switch(strtolower($this->passMethod)){
            case 'sha1':
                $password = "SHA1('".$data['password']."')"; break;
            case 'md5' :
                $password = "MD5('".$data['password']."')";break;
            case 'nothing':
                $password = $data[$this->tbFields['pass']];
    	}
        foreach ($data as $k => $v ) $data[$k] = "'".$this->escape($v)."'";
        $data['password'] = $password;
        $db->query("INSERT INTO `".$this->tbStore."` (`".implode('`, `', array_keys($data))."`) VALUES (".implode(", ", $data).")");
        $id = $db->insert ();
        return $id;
    }
    
    /**
    * Kiểm tra email đã tồn tại chưa
    * @param string $email
    * @return bool
    */
    function checkEmailExists($email){
        global $db;
    	$db->query("SELECT * FROM `".$this->tbStore."` 
    	WHERE `email` = '$email' LIMIT 1");
        $user = $db->getObject();
    	if ( !$user )
    		return false;
    	return true;
    }
    
    /**
    * Kiểm tra email đã tồn tại chưa
    * @param string $email
    * @return bool
    */
    function checkUsernameExists($username){
        global $db;
    	$db->query("SELECT * FROM `".$this->tbStore."` 
    	WHERE `username` = '$username' LIMIT 1");
        $user = $db->getObject();
    	if ( !$user )
    		return false;
    	return true;
    }
    
    /**
    * Thêm tài khoản: 'database field' => 'value'
    * @param array $data
    * @return int
    */ 
    function updateUser($data, $user_id = 0){
        global $db;
        $data['updated_time'] = date('Y-m-d H:i:s');
        if (!is_array($data)) $this->error('Data is not an array', __LINE__);
        $strUpdate = "published = '1'";
        foreach ($data as $k => $v )
            $strUpdate .= ",".$k."='".$this->escape($v)."'";
        if($this->userID)
            $user_id = $this->userID;
        $db->query("UPDATE `".$this->tbStore.'` SET '.$strUpdate.' WHERE id = \''.$user_id.'\'');
        $id = $db->affected_rows();
        return $id;
    }
    
    /**
    * Lấy thông tin của user đã đăng nhập
    * @access private
    * @param string $userID
    * @return bool
    */
    private function loadUser($userID){
        global $db;
        $res = $db->query("SELECT * FROM `".$this->tbStore."` WHERE `id` = '".$this->escape($userID)."' LIMIT 1");
        $user = $db->getObject();
        if ( !$user )
            return false;
        $this->userInfo = $user;
        $this->userID = $user->id;
        $_SESSION[$this->sessionVariable] = $this->userID;
        return true;
    }
    
    /**
    * Kiểm tra đã đăng nhập chưa?
    * @ return bool
    */
    function is_loaded(){
        return empty($this->userID) ? false : true;
    }
    
    /**
  	* Produces the result of addslashes() with more safety
  	* @access private
  	* @param string $str
  	* @return string
    */  
    function escape($str) {
        $str = get_magic_quotes_gpc()?stripslashes($str):$str;
        /* $str = mysql_real_escape_string($str); */
        return $str;
    }

    /**
  	* Error holder for the class
  	* @access private
  	* @param string $error
  	* @param int $line
  	* @param bool $die
  	* @return bool
    */  
    function error($error, $line = '', $die = false) {
        if ( $this->displayErrors )
        	echo '<b>Error: </b>'.$error.'<br /><b>Line: </b>'.($line==''?'Unknown':$line).'<br />';
        if ($die) exit;
        return false;
    }
}