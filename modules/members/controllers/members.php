<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class MembersControllersMembers extends FSControllers{
    function __construct(){
        parent::__construct();
    }

    function display(){
        $cities = $this->model->getCitiesArray();
        $list = $this->model->getList();
        $total = $this->model->getTotal();
        $totalBusiness = $this->model->getTotalBusiness();
		$pagination = $this->model->getPagination($total); 
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/default.php');
    }

    function create(){
        global $user;
        if(!$user->userID)
            setRedirect(FSRoute::_('index.php?module=members&view=members&task=login'), 'Bạn chưa đăng nhập!');
		if(!IS_ADMIN)
            setRedirect(FSRoute::_('index.php?module=members&view=members'), 'Liên hệ admin để thực hiện thao tác này!');
        $cities = $this->model->getCitiesArray();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/create.php');
    }
    
    function login(){
        global $user;
        if($user->userID)
            setRedirect(URL_ROOT, 'Bạn đã đăng nhập!');
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/login.php');
    }
    
    function add_members(){
        global $user;
        $json = array(
            'error' => true,
            'msg' => 'Có lỗi trong quá trình xử lý. Bạn vui lòng kiểm tra lại!',
            'url' => URL_ROOT
        );
        $username = FSInput::get('username', '');
        if($user->checkUsernameExists($username)){
            $json['msg'] = 'Tài khoản đã có ngươi sử dụng. Bạn vui lòng chọn tài khoản khác.';
            echo json_encode($json); return;
        }
        $id = $this->model->add_members();
        if($id){
            $code = 'VT'.str_pad($id, 6, "0", STR_PAD_LEFT);
            $this->model->_update(array('code'=>$code), 'fs_members', 'id='.$id);
            $json = array(
                'error' => false,
                'msg' => 'Thêm thành viên thành công!',
                'url' => FSRoute::_('index.php?module=members&view=members')
            );
        }
        echo json_encode($json);
    }
    
    function update_members(){
        $json = array(
            'error' => true,
            'msg' => 'Có lỗi trong quá trình xử lý. Bạn vui lòng kiểm tra lại!',
            'url' => URL_ROOT
        );
        $id = $this->model->update_members();
        if($id){
            $json = array(
                'error' => false,
                'msg' => 'Cập nhật thành viên thành công!',
                'url' => FSRoute::_('index.php?module=members&view=members')
            );
        }
        echo json_encode($json);
    }
    
    function get_members_json(){
        $result =  array();
        $listTopics = $this->model->get_members_json();
        if($listTopics){
            foreach($listTopics as $item){
                $result[] = array(
                    'id' => $item->code,
                    'label' => $item->agencies_title,
                    'value' => $item->agencies_title,
                    'agencies_title' => $item->agencies_title,
                    'participants_title' => $item->agencies_title,
                    'email' => $item->email,
                    'mobile' => $item->mobile,
                    'sex' => $item->sex
                );
            }
        }
        echo json_encode($result); exit();
    }
    
    function login_save(){
        global $user;
        $json = array(
            'error' => true,
            'message' => 'Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.',
            'redirect' => URL_ROOT
        );
        $username = FSInput::get('username', '', 'str');
        $password = FSInput::get('password', '', 'str');
        $redirect = FSInput::get('redirect', '');
        $loged = $user->login($username, $password);
        if($loged){
            $json['error'] = false;
            $json['message'] = 'Bạn đã đăng nhập thành công.';
            if($redirect != '')
                $json['redirect'] = fsDecode($redirect);
        }else{
            $json['message'] = 'Tên đăng nhập hoặc mật khẩu không đúng.';
        }
        echo json_encode($json);exit();
    }
    
    function do_login(){
        global $user;
        $username = FSInput::get('username', '', 'str');
        $password = FSInput::get('password', '', 'str');
        $redirect = FSInput::get('redirect', '');
        $loged = $user->login($username, $password);
        if($loged){
            setRedirect(URL_ROOT);
        }else{
            setRedirect(FSRoute::_('index.php?module=members&view=members&task=login'), 'Tên đăng nhập hoặc mật khẩu không đúng!');
        }
    }
    
    function logout(){
        global $user;
        $user->logout(URL_ROOT);
    }
    
    function published(){
        global $user;
        if(!$user->userID || $user->userInfo->username != 'admin'){
            setRedirect(FSRoute::_('index.php?module=members&view=members'), 'Liên hệ admin để thực hiện thao tác này!');
            return;
        }
        $this->model->_update(array('published'=>FSInput::get('value', 0)), 'fs_members', 'id='.FSInput::get('id', 0));
        setRedirect(FSRoute::_('index.php?module=members&view=members'));
    }
    
    function edit(){
        global $user;
        if(!$user->userID || $user->userInfo->username != 'admin'){
            setRedirect(FSRoute::_('index.php?module=members&view=members'), 'Liên hệ admin để thực hiện thao tác này!');
            return;
        }
        $cities = $this->model->getCitiesArray();
        $data = $this->model->getData();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/edit.php');
    }
    
    function delete(){
        global $user;
        if(!$user->userID || $user->userInfo->username != 'admin'){
            setRedirect(FSRoute::_('index.php?module=members&view=members'), 'Liên hệ admin để thực hiện thao tác này!');
            return;
        }
        $id = FSInput::get('id', 0);
        $this->model->_remove('id='.$id, 'fs_members');
        setRedirect(FSRoute::_('index.php?module=members&view=members'));
    }
} 