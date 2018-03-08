<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class StatisticsControllersBusiness extends FSControllers{
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
    
    function list_business(){
        $cities = $this->model->getCitiesArray();
        $list = $this->model->getList();
        $total = $this->model->getTotal();
		$pagination = $this->model->getPagination($total);
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/list_business.php');
    }
    
    function view(){
        global $tmpl, $arrIndustries, $arrProgram, $arrActivityKeyTime, $arrActivityType, $arrBusinessResults;
        $data = $this->model->getData();
        $industrier = $this->model->getIndustrier($data->commodity_id, $data->city_id);
        $industrierTQ = $this->model->getIndustrier($data->commodity_id);
        $program = FSInput::get('program', 1);
        
        /* Tính các quý kinh doanh */
        $arrCurrentOutcome = getQuarterToCurrent();
        
        $dataBusinessResults = array();
        $list = $this->model->get_records('member_code=\''.$data->code.'\'', 'fs_business_results');
        foreach($list as $item){
            foreach($arrBusinessResults as $key=>$val){
                $dataBusinessResults[$key][$item->year][$item->quarter] = $item->$key;
            }
        }
        
        $listActivities = $this->model->getActivitiesByBusiness($data->code);
        $dataBusinessOutcome = array();
        foreach($listActivities as $item){
            $listBusinessOutcome = $this->model->getActivitiesBusinessOutcome($data->code, $item->id);
            foreach($listBusinessOutcome as $btem){
                $dataBusinessOutcome[$item->id][$btem->activity_type] = array(
                    'outcome' => $btem->outcome,
                    'customers' => $btem->customers,
                    'contracts' => $btem->contracts,
                    'contractsvalue' => $btem->contractsvalue
                );
            }
        }
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/view.php');
    }
    
    function detail(){
        global $tmpl, $arrIndustries, $arrProgram, $arrActivityKeyTime, $arrActivityType, $arrBusinessResults;
        $data = $this->model->getData();
        $industrier = $this->model->getIndustrier($data->commodity_id, $data->city_id);
        $industrierTQ = $this->model->getIndustrier($data->commodity_id);
        $program = FSInput::get('program', 1);
        
        /* Tính các quý kinh doanh */
        $arrCurrentOutcome = getQuarterToCurrent();
        
        $arrCurrentOutcome = array_merge(array(array(
            'quarter' => 4,
            'year' => 2014,
            'text' => '4/2014'
        )), $arrCurrentOutcome);
        
        $dataBusinessResults = array();
        $list = $this->model->get_records('member_code=\''.$data->code.'\'', 'fs_business_results');
        foreach($list as $item){
            foreach($arrBusinessResults as $key=>$val){
                $dataBusinessResults[$key][$item->year][$item->quarter] = $item->$key;
            }
        }
        
        $listActivities = $this->model->getActivitiesByBusiness($data->code);
        $dataBusinessOutcome = array();
        foreach($listActivities as $item){
            $listBusinessOutcome = $this->model->getActivitiesBusinessOutcome($data->code, $item->id);
            foreach($listBusinessOutcome as $btem){
                $dataBusinessOutcome[$item->id][$btem->activity_type] = array(
                    'outcome' => $btem->outcome,
                    'customers' => $btem->customers,
                    'contracts' => $btem->contracts,
                    'contractsvalue' => $btem->contractsvalue,
                    'verify' => $btem->verify
                );
            }
        }
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/detail.php');
    }
    
    function save_activity_outcome(){
        $value = FSInput::get('value', 0);
        $value = str_replace('.', '', $value);
        $data = FSInput::get('id', 0);
        $data = explode('|', $data);
        $id = $this->model->check_activity_business_exists($data[0], $data[1], $data[2]);
        if($id)
            $this->model->_update(array($data[3]=>$value), 'fs_report_activity_business', 'id='.$id);
        else{
            $row = array(
                'member_code' => $data[0],
                'activity_id' => $data[1],
                'activity_type' => $data[2],
                $data[3] => $value,
                'year' => $data[4],
                'quarter' => $data[5],
                'created_time' => date('Y-m-d H:i:s')
            );
            $this->model->_add($row, 'fs_report_activity_business');
        }
        echo $value;
    }
    
    function save_business_results(){
        $data = FSInput::get('id', 0);
        $data = explode('|', $data);
        $gValue = FSInput::get('value', 0);
        $value = $gValue;
        if($data[3] != 'named_limited_view')
            $value = str_replace('.', '', $gValue);
        $id = $this->model->check_business_results_exists($data[0], $data[1], $data[2]);
        if($id)
            $this->model->_update(array($data[3]=>$value), 'fs_business_results', 'id='.$id);
        else{
            $row = array(
                'member_code' => $data[0],
                'quarter' => $data[1],
                'year' => $data[2],
                'created_time' => date('Y-m-d H:i:s'),
                $data[3]=>$value
            );
            $this->model->_add($row, 'fs_business_results');
        }
        echo $value;
        
        $mem = $this->model->get_record('code=\''.$data[0].'\'', 'fs_members');
        if($mem){
            /* Thống kê tỉnh */
            $id = $this->model->check_business_results_calculated_city_exists($mem->city_id, $data[1], $data[2], $data[3]);
            $total = $this->model->get_business_results_calculated_city($mem->city_id, $data[1], $data[2], $data[3]);
            if($id)
                $this->model->_update(array('value'=>$total), 'fs_business_results_calculated_cities', 'id='.$id);
            else{
                $row = array(
                    'city_id' => $mem->city_id,
                    'quarter' => $data[1],
                    'year' => $data[2],
                    'created_time' => date('Y-m-d H:i:s'),
                    'key' => $data[3],
                    'value'=>$total
                );
                $this->model->_add($row, 'fs_business_results_calculated_cities');
            }
            
            /* Thống kê ngành */
            $id = $this->model->check_business_results_calculated_industry_exists($mem->commodity_id, $data[1], $data[2], $data[3]);
            $total = $this->model->get_business_results_calculated_industry($mem->commodity_id, $data[1], $data[2], $data[3]);
            if($id)
                $this->model->_update(array('value'=>$total), 'fs_business_results_calculated_industries', 'id='.$id);
            else{
                $row = array(
                    'industry_id' => $mem->commodity_id,
                    'quarter' => $data[1],
                    'year' => $data[2],
                    'created_time' => date('Y-m-d H:i:s'),
                    'key' => $data[3],
                    'value'=>$total
                );
                $this->model->_add($row, 'fs_business_results_calculated_industries');
            }
        }
    }
    
    function show_report_business(){
        $key = FSInput::get('key');
        $list = $this->model->get_report_business();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/report_business.php');
    }
} 