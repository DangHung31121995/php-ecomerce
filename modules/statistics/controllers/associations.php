<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class StatisticsControllersAssociations extends FSControllers{
    function __construct(){
        parent::__construct();
    }

    function display(){
        $cities = $this->model->getCitiesArray();
        $list = $this->model->getList();
        $total = $this->model->getTotal();
		$pagination = $this->model->getPagination($total);
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/display.php');
    }

    function detail(){
        global $tmpl, $arrIndustries, $arrProgram, $arrActivityKeyTime, $arrActivityType, $arrBusinessResults, $arrCapacityBuilding;
        $data = $this->model->getData();
        $arrQuarterCurrent = getQuarterToCurrent();

        $arrQuarterCurrent[] = array(
            'quarter' => 4,
            'year' => 2015,
            'text' => '4/2015'
        );
        $arrQuarterCurrent[] = array(
            'quarter' => 4,
            'year' => 2014,
            'text' => '4/2014'
        );
        $arrQuarterCurrent[] = array(
            'quarter' => 4,
            'year' => 2013,
            'text' => '4/2013'
        );
        $program = FSInput::get('program', 1);
        $listCapacityBuilding = $this->model->getCapacityBuilding($data->code, $program);
        $dataCapacityBuilding = array();
        foreach($listCapacityBuilding as $item){
            foreach($arrCapacityBuilding as $key=>$val){
                $dataCapacityBuilding[$item->year][$item->quarter][$key] = $item->$key;
            }
        }
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/detail.php');
    }
    
    function save_capacity_building(){
        $value = FSInput::get('value', 0);
        $data = FSInput::get('id', 0);
        $data = explode('|', $data);
        $id = $this->model->check_capacity_building_exists($data[0], $data[1], $data[2], $data[3]);
        if($id)
            $this->model->_update(array($data[4]=>$value), 'fs_capacity_building', 'id='.$id);
        else{
            $row = array(
                'program' => $data[0],
                'member_code' => $data[1],
                'quarter' => $data[2],
                'year' => $data[3],
                $data[4] => $value,
                'created_time' => date('Y-m-d H:i:s')
            );
            $this->model->_add($row, 'fs_capacity_building');
        }
        
        /* Thêm phần tính toán */
        $cid = $this->model->check_capacity_building_calculated_exists($data[0], $data[1], $data[2], $data[3], $data[4]);
        if($cid)
            $this->model->_update(array('value'=>$value), 'fs_capacity_building_calculated', 'id='.$cid);
        else{
            $row = array(
                'program' => $data[0],
                'member_code' => $data[1],
                'quarter' => $data[2],
                'year' => $data[3],
                'key' => $data[4],
                'value' => $value,
                'created_time' => date('Y-m-d H:i:s')
            );
            $this->model->_add($row, 'fs_capacity_building_calculated');
        }
        
        $rise = $this->model->check_capacity_building_rise($data[0], $data[1], $data[2], $data[3], $data[4], $value);
        $this->model->_update(array('rise'=>$rise), 'fs_capacity_building_calculated', 'id='.$cid);
        
        echo $value;
    }
    
    function get_realtime_statistics(){
        global $arrActivityType;
        $arrReturn = array();
        $list = $this->model->get_realtime_statistics();
        $arrReturn[0] = array(
            'id' => '123',
            'in' => 0,
            'out' => 0,
            'total' => 0
        );
        foreach($arrActivityType as $key=>$val){
            $arrReturn[$key] = array(
                'id' => $key,
                'in' => 0,
                'out' => 0,
                'total' => 0
            );
        }
        $arrReturn[11] = array(
            'id' => 'cb',
            'in' => 0,
            'out' => 0,
            'total' => 0
        );
        $arrReturn[12] = array(
            'id' => 'dn',
            'in' => 0,
            'out' => 0,
            'total' => 0
        );
        foreach($list as $item){
            if($item->type == 5){
                if($item->program == 1)
                    $arrReturn[12]['in']++;
                else
                    $arrReturn[12]['out']++;
                $arrReturn[12]['total']++;
            } 
            $arrReturn[$item->activity_type]['total']++; 
            if($item->program == 1)
                $arrReturn[$item->activity_type]['in']++;
            else
                $arrReturn[$item->activity_type]['out']++;      
        }
        echo json_encode($arrReturn);
    }
    
    function open_business_box(){
        global $arrIndustries;
        $member_code = FSInput::get('member_code', '');
        $key = FSInput::get('key', 'key');
        $list = $this->model->get_list_business(); 
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/business_report.php');
    }
    
    function open_city_box(){
        global $arrIndustries;
        $member_code = FSInput::get('member_code', '');
        $key = FSInput::get('key', 'key');
        $data = $this->model->get_city_results($member_code);
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/city_report.php');
    }
    
    function save_business(){
        $json = array(
            'error' => true, 
            'message' => 'Cập nhật thành công',
            'id' => 0
        );
        $id = $this->model->save_business();
        if($id){
            $json['error'] = false;
            $json['id'] = $id;
        }
        echo json_encode($json);
    }
    
    function show_report_business_by_city(){
        $key = FSInput::get('key');
        $list = $this->model->get_report_business();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/report_business_by_city.php');
    }
} 