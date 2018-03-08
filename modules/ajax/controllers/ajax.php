<?php
class AjaxControllersAjax extends FSControllers{
    function __construct(){
        parent::__construct();
    }
    
    function create_image(){
        ob_start();
        //Let's generate a totally random string using md5 
        $md5_hash = md5(rand(0,999)); 
        //We don't need a 32 character long string so we trim it down to 5 
        $security_code = substr($md5_hash, 15, 5); 
        //Set the session to store the security code
        $_SESSION["security_code"] = $security_code;
        //Set the image width and height 
        $width = 60; 
        $height = 21;  
        //Create the image resource 
        $image = ImageCreate($width, $height);  
        //We are making three colors, white, black and gray 
        $white = ImageColorAllocate($image, 255, 255, 255); 
        $black = ImageColorAllocate($image, 0, 0, 0); 
        $grey = ImageColorAllocate($image, 204, 204, 204); 
        //Make the background black 
        ImageFill($image, 0, 0, $white); 
        //Add randomly generated string in white to the image
        ImageString($image, 3, 15, 3, $security_code, $black); 
        //Throw in some lines to make it a little bit harder for any bots to break 
        ImageRectangle($image,0,0,$width-1,$height-1,$grey); 
    //    imageline($image, 0, $height/2, $width, $height/2, $grey); 
    //    imageline($image, $width/2, 0, $width/2, $height, $grey); 
        //Tell the browser what kind of file is come in 
        header("Content-Type: image/jpeg"); 
        //Output the newly created image in jpeg format 
        ImageJpeg($image); 
        //Free up resources
        ImageDestroy($image); 
        ob_end_flush();
        exit(); 
    }
    
    /**
     * Đăng ký nhận tin
     */ 
    function registerNewsletter(){
        $data = array('message'=>'Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        if($this->model->checkEmailExists()){
            $data['message'] = 'Email đã được đăng ký!';            
            echo json_encode($data);
            return;
        }
        if($this->model->registerNewsletter())
            $data['message'] = 'Bạn đã đăng ký thành công!';
        $email = FSInput::get('email');
        $global_class = FSFactory::getClass('FsGlobal');
        $content = $global_class->getConfig('mail_register_newsletter');
        sendMailFS('Thông báo đã đăng ký nhận tin thành công tại KIVI.VN', $content, $email, $email);
        echo json_encode($data);
        return;
    }
    
    function checkCapcha(){
        $data = array('check'=>false);
        $capcha = FSInput::get('capcha');
        if ($capcha == $_SESSION["security_code"]){
            $data['check'] = true;
        }//echo $_SESSION["security_code"];
        echo json_encode($data);exit;
    }
    
    function select_language(){
        $redirect = base64_decode(FSInput::get('redirect'), '');
        setRedirect($redirect);
    }    
    
    function update_edp(){
        $id = FSInput::get('id', 0);
        $edp = FSInput::get('edp', 0); 
        $return = $this->model->_update(array('edp'=>$edp), 'fs_members', 'id='.$id);
        echo json_encode($return);
    }
}