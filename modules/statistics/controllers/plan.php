<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class StatisticsControllersPlan extends FSControllers{
    function __construct(){
        parent::__construct();
    }

    function display(){
        $cities = $this->model->getCitiesArray();
        $list = $this->model->getList();
        $total = $this->model->getTotal();
		$pagination = $this->model->getPagination($total);
        $cities = $this->model->getCitiesArray();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/display.php');
    }
    
    function edit(){
        global $user;
        if(!$user->userID)
            setRedirect(FSRoute::_('index.php?module=members&view=members&task=login'), 'Bạn chưa đăng nhập!');
        $id = FSInput::get('id', 0);
        $data = $this->model->get_record('id='.$id,'fs_activity_plan');  
        if(!$data){
            setRedirect(FSRoute::_('index.php?module=statistics&view=plan&task=display'), 'Không tồn tại kế hoạch này!');
        }
        if(($user->userInfo->code == $data->member_code)  || IS_ADMIN){
            $cities = $this->model->getCitiesArray();
            $list = $this->model->getList(); 
            $total = $this->model->getTotal();
            $pagination = $this->model->getPagination($total);
            require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/display.php');
        }else{
            setRedirect(FSRoute::_('index.php?module=statistics&view=plan'), 'Liên hệ admin để thực hiện thao tác này!');
            return;
        }
    }
    
    function create(){
        global $user;
        if(!$user->userID)
            setRedirect(FSRoute::_('index.php?module=members&view=members&task=login'), 'Bạn chưa đăng nhập!');
        if(IS_ADMIN || in_array($user->userInfo->type, array(1,2,3,4))){
            $id = $this->model->addPlan();
            if($id)
                setRedirect(FSRoute::_('index.php?module=statistics&view=plan&task=display'), 'Thêm kế hoạch thành công!');
        }else
            setRedirect(FSRoute::_('index.php?module=statistics&view=plan&task=display'), 'Liên hệ admin để thực hiện thao tác này!');
    }
    
    function update(){
        global $user;
        if(!$user->userID)
            setRedirect(FSRoute::_('index.php?module=members&view=members&task=login'), 'Bạn chưa đăng nhập!');
        $id = $this->model->updatePlan();
        if($id)
            setRedirect(FSRoute::_('index.php?module=statistics&view=plan&task=display'), 'Cập nhật kế hoạch thành công!');
    }
    
    function delete(){
        global $user;
        
        if(!$user->userID){
            setRedirect(FSRoute::_('index.php?module=statistics&view=plan'), 'Bạn chưa đăng nhập!');
            return;
        }
        $id = FSInput::get('id', 0);
        $plan = $this->model->get_record('id='.$id,'fs_activity_plan');             
        if(($user->userInfo->code != $plan->member_code)  || !IS_ADMIN){
            setRedirect(FSRoute::_('index.php?module=statistics&view=plan'), 'Liên hệ admin để thực hiện thao tác này!');
            return;
        }
        $this->model->_remove('id='.$id, 'fs_activity_plan');
        setRedirect(FSRoute::_('index.php?module=statistics&view=plan'), 'Xóa thành công!');
    }
} 