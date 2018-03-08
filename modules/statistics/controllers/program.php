<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class StatisticsControllersProgram extends FSControllers{
    function __construct(){
        parent::__construct();
    }

    function display(){
        global $tmpl, $arrRegions, $arrIndustries, $arrActivityType, $arrProgram;
        $program = FSInput::get('program', 1);
        $cArrRegions = $arrRegions;
        unset($cArrRegions[0]);
        $cities = $this->model->getCitiesArray();
        unset($cities[100]);
        $arrQuarterCurrent = getQuarterToCurrent();
        $list = $this->model->getList();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/display.php');
    }

    function create(){
        $id = $this->model->addPlan();
        if($id)
            setRedirect(FSRoute::_('index.php?module=statistics&view=plan&task=display'), 'Thêm kế hoạch thành công!');
    }
    
    function get_program_activity(){
        global $arrActivityType;
        $arrReturn = array();
        $arrReturn[0] = array(
            'class' => '_',
            'in' => 0,
            'quarter' => 0,
            'implemented' => 0,
            'out' => 0
        );
        foreach($arrActivityType as $key=>$val){
            $arrReturn[$key] = array(
                'class' => $key,
                'in' => 0,
                'quarter' => 0,
                'implemented' => 0,
                'out' => 0
            );
        }
        $list = $this->model->get_report_activity();
        foreach($list as $item){
            if($item->program == 1)
                $arrReturn[$item->activity_type]['in']++;
            else
                $arrReturn[$item->activity_type]['out']++;
        }
        $list = $this->model->get_report_activity_quarter();
        foreach($list as $item){
            $arrReturn[$item->activity_type]['implemented']++;
        }
        $list = $this->model->get_plan_quarter();
        foreach($list as $item){
            $arrReturn[$item->activity_type]['quarter']++;
        }
        echo json_encode($arrReturn);
    }
    
    function show_report_city(){
        global $arrActivityType, $arrProgram;
        $id = FSInput::get('id', 0);
        $program = FSInput::get('program', 1);
        $city = $this->model->get_record('id ='.$id, 'fs_local_cities');
        $quarter = FSInput::get('quarter', '1/2015');
        $quarter = explode('/', $quarter); 
        
        $aProgram = array();
        
        $aProgram['export_sales'] = $this->model->get_business_results_rise_city($id, $quarter[0], $quarter[1], 'export_sales').'%';
        $aProgram['sales'] = $this->model->get_business_results_rise_city($id, $quarter[0], $quarter[1], 'sales').'%';
        
        $aProgram['new_markets'] = $this->model->get_business_results_calculated_city($id, $quarter[0], $quarter[1], 'new_markets');
        $aProgram['new_clients'] = $this->model->get_business_results_calculated_city($id, $quarter[0], $quarter[1], 'new_clients');
        $aProgram['new_products'] = $this->model->get_business_results_calculated_city($id, $quarter[0], $quarter[1], 'new_products');
        $aProgram['officials_knowledge'] = $this->model->get_business_results_rise_city($id, $quarter[0], $quarter[1], 'officials_knowledge', 0);
        
        $lActivity = $this->model->getActivityByCity($id);
        $aProgram['activity']['total'] = 0;
        $aProgram['budget_reciprocal']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['activity'][$key] = 0;
            $aProgram['budget_reciprocal'][$key] = 0;
        }
        foreach($lActivity as $item){ 
            $aProgram['activity'][$item->activity_type] ++;
            $aProgram['activity']['total']++;
            
            $aProgram['budget_reciprocal'][$item->activity_type] += $item->budget_reciprocal;
            $aProgram['budget_reciprocal']['total'] += $item->budget_reciprocal;
        }
        
        $lPerson = $this->model->getStaffDistinctByCity($id);
        $aProgram['staffd']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['staffd'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['staffd'][$item->activity_type] ++;
            $aProgram['staffd']['total']++;
        }
        
        $lPerson = $this->model->getStaffByCity($id);
        $aProgram['staff']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['staff'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['staff'][$item->activity_type] ++;
            $aProgram['staff']['total']++;
        }
        
        $lPerson = $this->model->getPersonDistinctByCity($id);
        $aProgram['persond']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['persond'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['persond'][$item->activity_type] ++;
            $aProgram['persond']['total']++;
        }
        
        $lPerson = $this->model->getPersonByCity($id);
        $aProgram['person']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['person'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['person'][$item->activity_type] ++;
            $aProgram['person']['total']++;
        }
        
        $oActivity = $this->model->selfDeploymentActivityByCity($id);
        $aProgram['oActivity']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['oActivity'][$key] = 0;
        }
        foreach($oActivity as $item){
            $aProgram['oActivity'][$item->activity_type] ++;
            $aProgram['oActivity']['total']++;
        }
        
        $oPerson = $this->model->getPersonDistinctSelfDeploymentActivityByCity($id);
        $aProgram['oPerson']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['oPerson'][$key] = 0;
        }
        foreach($oPerson as $item){
            $aProgram['oPerson'][$item->activity_type] ++;
            $aProgram['oPerson']['total']++;
        }
        
        $quarter = FSInput::get('quarter', '1/2015');
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/report_city.php');
    }
    
    function show_report_region(){
        global $arrActivityType, $arrRegions,$arrProgram;
        $id = FSInput::get('id', 0);
        $program = FSInput::get('program', 1);
        $quarter = FSInput::get('quarter', '1/2015');
        
        $aProgram = array();
        
        $aProgram['export_sales'] = $this->model->get_business_results_rise_region($id, $quarter[0], $quarter[1], 'export_sales').'%';
        $aProgram['sales'] = $this->model->get_business_results_rise_region($id, $quarter[0], $quarter[1], 'sales').'%';
        
        $aProgram['new_markets'] = $this->model->get_business_results_calculated_region($id, $quarter[0], $quarter[1], 'new_markets');
        $aProgram['new_clients'] = $this->model->get_business_results_calculated_region($id, $quarter[0], $quarter[1], 'new_clients');
        $aProgram['new_products'] = $this->model->get_business_results_calculated_region($id, $quarter[0], $quarter[1], 'new_products');
        $aProgram['officials_knowledge'] = $this->model->get_business_results_rise_region($id, $quarter[0], $quarter[1], 'officials_knowledge', 0);
        
        $lActivity = $this->model->getActivityByRegion($id);
        $aProgram['activity']['total'] = 0;
        $aProgram['budget_reciprocal']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['activity'][$key] = 0;
            $aProgram['budget_reciprocal'][$key] = 0;
        }
        foreach($lActivity as $item){ 
            $aProgram['activity'][$item->activity_type] ++;
            $aProgram['activity']['total']++;
            
            $aProgram['budget_reciprocal'][$item->activity_type] += $item->budget_reciprocal;
            $aProgram['budget_reciprocal']['total'] += $item->budget_reciprocal;
        }
        
        $lPerson = $this->model->getStaffDistinctByRegion($id);
        $aProgram['staffd']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['staffd'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['staffd'][$item->activity_type] ++;
            $aProgram['staffd']['total']++;
        }
        
        $lPerson = $this->model->getStaffByRegion($id);
        $aProgram['staff']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['staff'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['staff'][$item->activity_type] ++;
            $aProgram['staff']['total']++;
        }
        
        $lPerson = $this->model->getPersonDistinctByRegion($id);
        $aProgram['persond']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['persond'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['persond'][$item->activity_type] ++;
            $aProgram['persond']['total']++;
        }
        
        $lPerson = $this->model->getPersonByRegion($id);
        $aProgram['person']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['person'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['person'][$item->activity_type] ++;
            $aProgram['person']['total']++;
        }
        
        $oActivity = $this->model->selfDeploymentActivityByRegion($id);
        $aProgram['oActivity']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['oActivity'][$key] = 0;
        }
        foreach($oActivity as $item){
            $aProgram['oActivity'][$item->activity_type] ++;
            $aProgram['oActivity']['total']++;
        }
        
        $oPerson = $this->model->getPersonDistinctSelfDeploymentActivityByRegion($id);
        $aProgram['oPerson']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['oPerson'][$key] = 0;
        }
        foreach($oPerson as $item){
            $aProgram['oPerson'][$item->activity_type] ++;
            $aProgram['oPerson']['total']++;
        }
        
        $quarter = FSInput::get('quarter', '1/2015');
        
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/report_region.php');
    }
    
    function show_report_industry(){
        global $arrActivityType, $arrIndustries, $arrProgram;
        $id = FSInput::get('id', 0);
        $quarter = FSInput::get('quarter', '1/2015');
        $program = FSInput::get('program', 1);
        
        $aProgram = array();
        
        $aProgram['export_sales'] = $this->model->get_business_results_rise_industry($id, $quarter[0], $quarter[1], 'export_sales').'%';
        $aProgram['sales'] = $this->model->get_business_results_rise_industry($id, $quarter[0], $quarter[1], 'sales').'%';
        
        $aProgram['new_markets'] = $this->model->get_business_results_calculated_industry($id, $quarter[0], $quarter[1], 'new_markets');
        $aProgram['new_clients'] = $this->model->get_business_results_calculated_industry($id, $quarter[0], $quarter[1], 'new_clients');
        $aProgram['new_products'] = $this->model->get_business_results_calculated_industry($id, $quarter[0], $quarter[1], 'new_products');
        $aProgram['officials_knowledge'] = $this->model->get_business_results_rise_industry($id, $quarter[0], $quarter[1], 'officials_knowledge', 0);
        
        $lActivity = $this->model->getActivityByActivity($id);
        $aProgram['activity']['total'] = 0;
        $aProgram['budget_reciprocal']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['activity'][$key] = 0;
            $aProgram['budget_reciprocal'][$key] = 0;
        }
        foreach($lActivity as $item){ 
            $aProgram['activity'][$item->activity_type] ++;
            $aProgram['activity']['total']++;
            
            $aProgram['budget_reciprocal'][$item->activity_type] += $item->budget_reciprocal;
            $aProgram['budget_reciprocal']['total'] += $item->budget_reciprocal;
        }
        
        $lPerson = $this->model->getStaffDistinctByActivity($id);
        $aProgram['staffd']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['staffd'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['staffd'][$item->activity_type] ++;
            $aProgram['staffd']['total']++;
        }
        
        $lPerson = $this->model->getStaffByActivity($id);
        $aProgram['staff']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['staff'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['staff'][$item->activity_type] ++;
            $aProgram['staff']['total']++;
        }
        
        $lPerson = $this->model->getPersonDistinctByIndustry($id);
        $aProgram['persond']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['persond'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['persond'][$item->activity_type] ++;
            $aProgram['persond']['total']++;
        }
        
        $lPerson = $this->model->getPersonByIndustry($id);
        $aProgram['person']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['person'][$key] = 0;
        }
        foreach($lPerson as $item){
            $aProgram['person'][$item->activity_type] ++;
            $aProgram['person']['total']++;
        }
        
        $oActivity = $this->model->selfDeploymentActivityByIndustry($id);
        $aProgram['oActivity']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['oActivity'][$key] = 0;
        }
        foreach($oActivity as $item){
            $aProgram['oActivity'][$item->activity_type] ++;
            $aProgram['oActivity']['total']++;
        }
        
        $oPerson = $this->model->getPersonDistinctSelfDeploymentActivityByIndustry($id);
        $aProgram['oPerson']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['oPerson'][$key] = 0;
        }
        foreach($oPerson as $item){
            $aProgram['oPerson'][$item->activity_type] ++;
            $aProgram['oPerson']['total']++;
        }
        
        $quarter = FSInput::get('quarter', '1/2015');
        
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/report_industry.php');
    }
    
    function show_lessons_learned(){
        global $arrProgram, $arrActivityType, $arrIndustries, $cities, $arrProgram;
        $cities = $this->model->getCitiesArray();
        $program = FSInput::get('program', 1);
        $list = $this->model->get_lessons_learned();
        $cities = $this->model->getCitiesArray(); 
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/lessons_learned.php');
    }
    
    function get_lessons_learned(){
        global $arrProgram, $arrActivityType, $arrIndustries, $cities, $arrProgram;
        $cities = $this->model->getCitiesArray();
        $program = FSInput::get('program', 1);
        $list = $this->model->get_lessons_learned();
        $cities = $this->model->getCitiesArray();
        $i = 0;
        foreach($list as $item){ 
            $i++;
        ?> 
            <tr class="tr-item">
                <td class="center"><?php echo $i ?></td>
                <td><?php echo @$arrActivityType[$item->activity_type] ?></td>
                <td><?php echo @$arrIndustries[$item->commodity_id] ?></td>
                <?php if($item->city_id){ ?>
                    <td><?php echo @$cities[intval($item->city_id)] ?></td>
                <?php }else{ ?>
                    <td>Toàn quốc</td>
                <?php } ?>
                <td class="center">
                    <?php if($item->number_participants){ ?>
                        <?php echo $item->number_participants ?>
                    <?php } ?>
                    <?php if($item->number_participants_females){ ?>
                        (<?php echo $item->number_participants_females ?> nữ)
                    <?php } ?>
                </td>
                <td><?php if($item->number_participants){ ?><?php echo $item->booth_number ?><?php } ?></td>
                <td><?php if($item->number_visitors){ ?><?php echo $item->number_visitors ?><?php } ?></td>
                <td><?php if($item->number_transactions){ ?><?php echo $item->number_transactions ?><?php } ?></td>
                <td><?php echo $item->outcome ?></td>
            </tr>
        <?php
        }
    }
    
    function show_basic_indices(){
        global $arrProgram;
        $program = FSInput::get('program', 1);
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/basic_indices.php');
    }
    
    function show_city_report_program(){
        $key = FSInput::get('key');
        $list = $this->model->get_city_report_program();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/city_report_program.php');
    }
    
    function show_city_outcome_program(){
        $key = FSInput::get('key');
        $list = $this->model->get_city_outcome_program();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/city_outcome_program.php');
    }
    
    function get_synthesis_report(){
        $json = array();
        $json['officials_knowledge'] = $this->model->get_city_synthesis_report('officials_knowledge');
        $json['officials_xttm'] = $this->model->get_city_synthesis_report('officials_xttm');
        $json['officials_customer'] = $this->model->get_city_synthesis_report('officials_customer');
        $json['provincial_building_strategy'] = $this->model->get_city_synthesis_report('provincial_building_strategy');
        $json['business_benchmarking'] = $this->model->get_city_synthesis_report('business_benchmarking');
        $json['export_sales'] = $this->model->get_export_sales().'%';
        $json['new_markets'] = $this->model->get_new_markets();
        $json['new_clients'] = $this->model->get_new_clients();
        echo json_encode($json);
    }
    
    function show_report_business_cities(){
        $key = FSInput::get('key');
        $list = $this->model->get_report_business_cities();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/report_business_cities.php');
    }
    
    function show_report_business_industries(){
        $key = FSInput::get('key');
        $list = $this->model->get_report_business_industries();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/report_business_industries.php');
    }
    
    function get_statistics_by_city(){
        global $arrActivityType;
        $quarter = FSInput::get('quarter');
        $id = FSInput::get('id');
        
        $json = array(
            'categories' => array('Tổng số'),
            'series' => array()
        );
        
        $lActivity = $this->model->getActivityByCity($id, $quarter);
        $aProgram['activity']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['activity'][$key] = 0;
        }
        foreach($lActivity as $item){ 
            $aProgram['activity'][$item->activity_type] ++;
            $aProgram['activity']['total']++;
        }
        $data = array();
        $data[] = $aProgram['activity']['total'];
        
        foreach($arrActivityType as $key=>$val){
            $json['categories'][] = $val;
            $data[] = $aProgram['activity'][$key];
        }
        
        $json['series'][] = array(
            'name' => FSText::_('Số doanh nghiệp tham gia hoạt động trong chương trình'),
            'data' => $data
        );
            
        $lActivity = $this->model->selfDeploymentActivityByCity($id, $quarter);
        $aProgram['activity']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['activity'][$key] = 0;
        }
        foreach($lActivity as $item){ 
            $aProgram['activity'][$item->activity_type] ++;
            $aProgram['activity']['total']++;
        }
        $data = array();
        $data[] = $aProgram['activity']['total'];
        
        foreach($arrActivityType as $key=>$val){
            $data[] = $aProgram['activity'][$key];
        }
        
        $json['series'][] = array(
            'name' => FSText::_('Số doanh nghiệp tham gia hoạt động ngoài chương trình'),
            'data' => $data
        );
        
        echo json_encode($json);
    }
    
    function get_statistics_by_industry(){
        global $arrActivityType;
        $quarter = FSInput::get('quarter');
        $id = FSInput::get('id');
        
        $json = array(
            'categories' => array('Tổng số'),
            'series' => array()
        );
        
        $lActivity = $this->model->getActivityByIndustry($id, $quarter);
        $aProgram['activity']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['activity'][$key] = 0;
        }
        foreach($lActivity as $item){ 
            $aProgram['activity'][$item->activity_type] ++;
            $aProgram['activity']['total']++;
        }
        $data = array();
        $data[] = $aProgram['activity']['total'];
        
        foreach($arrActivityType as $key=>$val){
            $json['categories'][] = $val;
            $data[] = $aProgram['activity'][$key];
        }
        
        $json['series'][] = array(
            'name' => FSText::_('Số doanh nghiệp tham gia hoạt động trong chương trình'),
            'data' => $data
        );
            
        $lActivity = $this->model->selfDeploymentActivityByIndustry($id, $quarter);
        $aProgram['activity']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['activity'][$key] = 0;
        }
        foreach($lActivity as $item){ 
            $aProgram['activity'][$item->activity_type] ++;
            $aProgram['activity']['total']++;
        }
        $data = array();
        $data[] = $aProgram['activity']['total'];
        
        foreach($arrActivityType as $key=>$val){
            $data[] = $aProgram['activity'][$key];
        }
        
        $json['series'][] = array(
            'name' => FSText::_('Số doanh nghiệp tham gia hoạt động ngoài chương trình'),
            'data' => $data
        );
        
        echo json_encode($json);
    }
    
    function get_statistics_by_region(){
        global $arrActivityType;
        $quarter = FSInput::get('quarter');
        $id = FSInput::get('id');
        
        $json = array(
            'categories' => array('Tổng số'),
            'series' => array()
        );
        
        $lActivity = $this->model->getActivityByRegion($id, $quarter);
        $aProgram['activity']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['activity'][$key] = 0;
        }
        foreach($lActivity as $item){ 
            $aProgram['activity'][$item->activity_type] ++;
            $aProgram['activity']['total']++;
        }
        $data = array();
        $data[] = $aProgram['activity']['total'];
        
        foreach($arrActivityType as $key=>$val){
            $json['categories'][] = $val;
            $data[] = $aProgram['activity'][$key];
        }
        
        $json['series'][] = array(
            'name' => FSText::_('Số doanh nghiệp tham gia hoạt động trong chương trình'),
            'data' => $data
        );
            
        $lActivity = $this->model->selfDeploymentActivityByRegion($id, $quarter);
        $aProgram['activity']['total'] = 0;
        foreach($arrActivityType as $key=>$val){
            $aProgram['activity'][$key] = 0;
        }
        foreach($lActivity as $item){ 
            $aProgram['activity'][$item->activity_type] ++;
            $aProgram['activity']['total']++;
        }
        $data = array();
        $data[] = $aProgram['activity']['total'];
        
        foreach($arrActivityType as $key=>$val){
            $data[] = $aProgram['activity'][$key];
        }
        
        $json['series'][] = array(
            'name' => FSText::_('Số doanh nghiệp tham gia hoạt động ngoài chương trình'),
            'data' => $data
        );
        
        echo json_encode($json);
    }
    
    function excel_lessons_learned(){ 
        global $arrProgram, $arrActivityType, $arrIndustries, $cities, $arrProgram;
        $cities = $this->model->getCitiesArray();
        $program = FSInput::get('program', 1);
        $list = $this->model->get_lessons_learned();
        $cities = $this->model->getCitiesArray(); 
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Vietrade")
							 ->setLastModifiedBy("Vietrade")
							 ->setTitle("Office 2007 XLSX Vietrade Document")
							 ->setSubject("Office 2007 XLSX Vietrade Document")
							 ->setDescription("Vietrade report ".date('d-m-Y'))
							 ->setKeywords("Vietrade report")
							 ->setCategory("Vietrade report");
                             
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(22);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(22);
        $sheet->getColumnDimension('H')->setWidth(22);
        $sheet->getColumnDimension('I')->setWidth(50);
        $sheet->mergeCells("A1:I1"); 
        $sheet->setCellValue('A1', 'Kết quả và bài học kinh nghiệm');
        $sheet->getStyle("A1")->getFont()->setSize(15)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );
        $sheet->setCellValue('A2', 'STT');
        $sheet->setCellValue('B2', FSText::_('Loại hình hoạt động'));
        $sheet->setCellValue('C2', FSText::_('Ngành hàng'));
        $sheet->setCellValue('D2', FSText::_('Tỉnh'));
        $sheet->setCellValue('E2', FSText::_('Số người tham gia'));
        $sheet->setCellValue('F2', FSText::_('Số gian hàng'));
        $sheet->setCellValue('G2', FSText::_('Số lượt khách'));
        $sheet->setCellValue('H2', FSText::_('Số giao dịch'));
        $sheet->setCellValue('I2', FSText::_('Kết quả và bài học kinh nghiệm'));
        $sheet->getStyle('A2:I2')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );
        $sheet->getStyle("A2:I2")->getFont()->setSize(13);
        
        $cCell = 2;
        $i = 0;
        foreach($list as $item){
            $i++;
            $cCell++;
            $sheet->setCellValue('A'.$cCell, $i);
            $sheet->getStyle('A'.$cCell)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            );
            $sheet->setCellValue('B'.$cCell, @$arrActivityType[$item->activity_type]);
            $sheet->setCellValue('C'.$cCell, @$arrIndustries[$item->commodity_id]);
            if($item->city_id){
                $sheet->setCellValue('D'.$cCell,  @$cities[intval($item->city_id)]);
            }else{
                $sheet->setCellValue('D'.$cCell, 'Toàn quốc');
            }
            $number = '';
            if($item->number_participants)
                $number .= $item->number_participants;
            if($item->number_participants_females)
                $number .= ' ('.$item->number_participants_females.' nữ)';
            $sheet->setCellValue('E'.$cCell, $number);
            
            if($item->booth_number)
                $sheet->setCellValue('F'.$cCell, $item->booth_number);
            if($item->number_visitors)
                $sheet->setCellValue('G'.$cCell, $item->number_visitors);
            if($item->number_transactions)
                $sheet->setCellValue('H'.$cCell, $item->number_transactions);
            
            $sheet->setCellValue('I'.$cCell, $item->outcome);
            
            $sheet->getStyle('E'.$cCell.':H'.$cCell)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            );
            
            $sheet->getStyle('A'.$cCell.':H'.$cCell)
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }
        
        $sheet->getStyle('I2:I'.$cCell)
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)
            ->setWrapText(true);
            
        $styleArray = array(
        'borders' => array(
            'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $sheet->getStyle(
            'A1:' . 
            $sheet->getHighestColumn() . 
            $sheet->getHighestRow()
        )->applyFromArray($styleArray);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Ket-qua-bai-hoc-kinh-nghiem-('.date('d-m-Y').').xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    function open_list_program_box(){
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/open_list_program_box.php');
    }
    
    function excel_list_program(){ 
        $_SESSION['lang'] = 'en';
        global $arrProgram, $arrActivityType, $arrIndustries, $cities, $arrProgram;
        
        $program = FSInput::get('program', 1);
        
        $list = $this->model->get_list_programs();
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Vietrade")
							 ->setLastModifiedBy("Vietrade")
							 ->setTitle("Office 2007 XLSX Vietrade Document")
							 ->setSubject("Office 2007 XLSX Vietrade Document")
							 ->setDescription("Vietrade report ".date('d-m-Y'))
							 ->setKeywords("Vietrade report")
							 ->setCategory("Vietrade report");
                             
        $sheet1 = $objPHPExcel->createSheet(1);
        
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $sheet->mergeCells("A1:O1"); 
        $sheet->setCellValue('A1', 'LIST OF ACTIVITIES');
        $sheet->mergeCells("A2:O2"); 
        $sheet->setCellValue('A2', 'Program: '.FSText::_($arrProgram[$program]));
        $sheet->mergeCells("A3:O3"); 
        $sheet->setCellValue('A3', 'From: '.FSInput::get('start_date', date('d/m/Y')).' To: '.FSInput::get('finish_date', date('d/m/Y')));
        /*$sheet->getStyle('A1:O3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );*/
        $sheet->setTitle('Table 1');
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(40);
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->getColumnDimension('O')->setWidth(40);
        
        $sheet1->mergeCells("A1:O1"); 
        $sheet1->setCellValue('A1', 'LIST OF ACTIVITIES');
        $sheet1->mergeCells("A2:O2"); 
        $sheet1->setCellValue('A2', 'Program: '.FSText::_($arrProgram[$program]));
        $sheet1->mergeCells("A3:O3"); 
        $sheet1->setCellValue('A3', 'From: '.FSInput::get('start_date', date('d/m/Y')).' To: '.FSInput::get('finish_date', date('d/m/Y')));
        /* $sheet1->getStyle('A1:O3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );*/
        $sheet1->setTitle('Table 2');
        $sheet1->getColumnDimension('A')->setWidth(15);
        $sheet1->getColumnDimension('B')->setWidth(15);
        $sheet1->getColumnDimension('C')->setWidth(40);
        $sheet1->getColumnDimension('D')->setWidth(15);
        $sheet1->getColumnDimension('E')->setWidth(15);
        $sheet1->getColumnDimension('F')->setWidth(15);
        $sheet1->getColumnDimension('G')->setWidth(15);
        $sheet1->getColumnDimension('H')->setWidth(15);
        $sheet1->getColumnDimension('I')->setWidth(15);
        $sheet1->getColumnDimension('J')->setWidth(15);
        $sheet1->getColumnDimension('K')->setWidth(15);
        $sheet1->getColumnDimension('L')->setWidth(15);
        $sheet1->getColumnDimension('J')->setWidth(40);
        $sheet1->getColumnDimension('K')->setWidth(30);
        $sheet1->getColumnDimension('L')->setWidth(40);
        
        $sheet->setCellValue('A4', FSText::_('Activity No.'));
        $sheet->setCellValue('B4', FSText::_('Program Year'));
        $sheet->setCellValue('C4', FSText::_('Event name'));
        $sheet->setCellValue('D4', FSText::_('Total'));
        $sheet->setCellValue('E4', FSText::_('Male'));
        $sheet->setCellValue('F4', FSText::_('Female'));
        $sheet->setCellValue('G4', FSText::_('Total Pax - TPOs & TSIs (inc. Vietrade)'));
        $sheet->setCellValue('H4', FSText::_('Number of TPOs/TSIs (inc. Vietrade)'));
        $sheet->setCellValue('I4', FSText::_('Total Pax - SMEs'));
        $sheet->setCellValue('J4', FSText::_('Number of SMEs'));
        $sheet->setCellValue('K4', FSText::_('Media'));
        $sheet->setCellValue('L4', FSText::_('VIETRADE - PMU'));
        $sheet->setCellValue('M4', FSText::_('Venue'));
        $sheet->setCellValue('N4', FSText::_('Time'));
        $sheet->setCellValue('O4', FSText::_('Consultants'));
        $sheet->getStyle('A4:O4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );
        $sheet->getStyle('A4:O4')
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
            
        $sheet->getStyle("A4:O4")->getFont()->setSize(13);
        $sheet->getStyle("A4:O4")->getAlignment()->setWrapText(true);
        
        $sheet1->setCellValue('A4', FSText::_('Activity No.'));
        $sheet1->setCellValue('B4', FSText::_('Program Year'));
        $sheet1->setCellValue('C4', FSText::_('Event name'));
        $sheet1->setCellValue('D4', FSText::_('Total Visitors and Exhibitors met'));
        $sheet1->setCellValue('E4', FSText::_('Male'));
        $sheet1->setCellValue('F4', FSText::_('Female'));
        $sheet1->setCellValue('G4', FSText::_('Total Pax - TPOs & TSIs (inc. Vietrade)'));
        $sheet1->setCellValue('H4', FSText::_('Number of TPOs/TSIs (inc. Vietrade)'));
        $sheet1->setCellValue('I4', FSText::_('Total Pax - SMEs'));
        $sheet1->setCellValue('J4', FSText::_('Number of SMEs'));
        $sheet1->setCellValue('K4', FSText::_('Media'));
        $sheet1->setCellValue('L4', FSText::_('VIETRADE - PMU'));
        $sheet1->setCellValue('M4', FSText::_('Venue'));
        $sheet1->setCellValue('N4', FSText::_('Time'));
        $sheet1->setCellValue('O4', FSText::_('Consultants'));
        $sheet1->getStyle('A4:O4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );
        $sheet1->getStyle('A4:O4')
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
            
        $sheet1->getStyle("A4:O4")->getFont()->setSize(13);
        $sheet1->getStyle("A4:O4")->getAlignment()->setWrapText(true);
        
        $cCell = 5;
        foreach($list as $item){
            $cCell++;
            $sheet->setCellValue('A'.$cCell, $item->activity_code);
            $sheet->setCellValue('B'.$cCell, date('Y', strtotime($item->start_date)));
            $sheet->setCellValue('C'.$cCell, $item->title);
            $sheet->setCellValue('D'.$cCell, $item->number_participants);
            $sheet->setCellValue('E'.$cCell, $item->number_participants- $item->number_participants_females);
            $sheet->setCellValue('F'.$cCell, $item->number_participants_females);
            $sheet->setCellValue('G'.$cCell, $item->number_centre_staff);
            $sheet->setCellValue('H'.$cCell, $item->number_center);
            $sheet->setCellValue('I'.$cCell, $item->number_business_staff);
            $sheet->setCellValue('J'.$cCell, $item->number_businesses);
            $sheet->setCellValue('K'.$cCell, $item->number_press_agencies);
            $sheet->setCellValue('L'.$cCell, $item->number_project_managers);
            $sheet->setCellValue('M'.$cCell, $item->activity_address);
            $sheet->setCellValue('N'.$cCell, date('d/m/Y', strtotime($item->start_date)).' - '.date('d/m/Y', strtotime($item->finish_date)));
            
            $sheet1->setCellValue('A'.$cCell, $item->activity_code);
            $sheet1->setCellValue('B'.$cCell, date('Y', strtotime($item->start_date)));
            $sheet1->setCellValue('C'.$cCell, $item->title);
            $sheet1->setCellValue('D'.$cCell, $item->number_visitors_activity);
            $sheet1->setCellValue('E'.$cCell, $item->number_visitors_activity - $item->number_visitors_activity_females);
            $sheet1->setCellValue('F'.$cCell, $item->number_visitors_activity_females);
            $sheet1->setCellValue('G'.$cCell, $item->number_centre_staff);
            $sheet1->setCellValue('H'.$cCell, $item->number_center);
            $sheet1->setCellValue('I'.$cCell, $item->number_business_staff);
            $sheet1->setCellValue('J'.$cCell, $item->number_businesses);
            $sheet1->setCellValue('K'.$cCell, $item->number_press_agencies);
            $sheet1->setCellValue('L'.$cCell, $item->number_project_managers);
            $sheet1->setCellValue('M'.$cCell, $item->activity_address);
            $sheet1->setCellValue('N'.$cCell, date('d/m/Y', strtotime($item->start_date)).' - '.date('d/m/Y', strtotime($item->finish_date)));
            
            $city = $this->model->get_record('code=\''.$item->city_code.'\'', 'fs_members', 'fullname, agencies_title');
            $officers = $this->model->get_record('code=\''.$item->officers_code.'\'', 'fs_members', 'fullname, agencies_title');
            $consultants = '';
            if($city)
                $consultants.= @$city->fullname.' ('.@$city->agencies_title.')'."\n";
            if($officers)
                $consultants.= @$officers->fullname.' ('.@$officers->agencies_title.')';
            $sheet->setCellValue('O'.$cCell, $consultants);
            $sheet->getStyle('O'.$cCell)->getAlignment()->setWrapText(true);
            
            $sheet1->setCellValue('O'.$cCell, $consultants);
            $sheet1->getStyle('O'.$cCell)->getAlignment()->setWrapText(true);
            
            $sheet1->getStyle('A'.$cCell.':O'.$cCell)
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                ->setWrapText(true);
            
            $sheet->getStyle('A'.$cCell.':O'.$cCell)
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                ->setWrapText(true);
        }
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="list-of-activities-('.date('d-m-Y').').xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        $_SESSION['lang'] = 'vi';
        exit;
    }
    
    function open_logframe(){
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/open_logframe.php');
    }
    
    function logframe(){
        global $arrEdp, $arrActivityType, $arrIndustries;
        $objPHPExcel = PHPExcel_IOFactory::load(PATH_BASE."docs/Logframe-tmp.xls");
        
        $start_date = explode('/', FSInput::get('start_date', date('d/m/Y')));
        $start_date = @$start_date[2].'-'.@$start_date[1].'-'.@$start_date[0].' 00:00:00';
        
        $finish_date = explode('/', FSInput::get('finish_date', date('d/m/Y')));
        $finish_date = $finish_date[2].'-'.$finish_date[1].'-'.$finish_date[0].' 23:59:59';
        
        $this->model->start_date = $start_date;
        $this->model->finish_date = $finish_date;
        
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setCellValue('C2', date('F d, Y', strtotime($finish_date)));
        
        /* Table 0.1 */
        $edpIndustries = array();
        $edpRegion = array();
        $memberEdp = $this->model->get_members_edp_logframe();
        foreach($memberEdp as $item){
            if(isset($edpIndustries[$item->edp][$item->commodity_id]))
                $edpIndustries[$item->edp][$item->commodity_id]++;
            else
                $edpIndustries[$item->edp][$item->commodity_id] = 1;
            
            if(isset($edpRegion[$item->edp][$item->region]))
                $edpRegion[$item->edp][$item->region]++;
            else
                $edpRegion[$item->edp][$item->region] = 1;
        }
        $objPHPExcel->setActiveSheetIndex(1);
        $sheet = $objPHPExcel->getActiveSheet();
        foreach($arrEdp as $key=>$val){
            $cCell = $key + 3;
            $sheet->setCellValue('E'.$cCell, intval(@$edpIndustries[$key][1]))
                ->setCellValue('F'.$cCell, intval(@$edpIndustries[$key][2]))
                ->setCellValue('G'.$cCell, intval(@$edpIndustries[$key][3]))
                ->setCellValue('H'.$cCell, intval(@$edpIndustries[$key][4]))
                ->setCellValue('I'.$cCell, intval(@$edpIndustries[$key][5]))
                ->setCellValue('J'.$cCell, intval(@$edpIndustries[$key][6]))
                ->setCellValue('K'.$cCell, intval(@$edpIndustries[$key][7]))
                ->setCellValue('L'.$cCell, intval(@$edpIndustries[$key][8]))
                ->setCellValue('M'.$cCell, intval(@$edpIndustries[$key][9]))
                ->setCellValue('N'.$cCell, intval(@$edpIndustries[$key][10]))
                ->setCellValue('O'.$cCell, intval(@$edpIndustries[$key][11]))
                ->setCellValue('P'.$cCell, intval(@$edpIndustries[$key][12]))
                ->setCellValue('Q'.$cCell, intval(@$edpRegion[$key][1]))
                ->setCellValue('R'.$cCell, intval(@$edpRegion[$key][2]))
                ->setCellValue('S'.$cCell, intval(@$edpRegion[$key][3]));
        }
        
        /* Table 0.3 */
        $arrCell = array();
        foreach($arrIndustries as $key)
            $arrCell[$key] = 200; // Lấy hàng bắt đầu
        $arrCell[1] = 27; // Lychee
        $arrCell[2] = 40; // Tea
        $arrCell[3] = 53; // Pepper
        $arrCell[4] = 69; // Tuna
        // $arrCell[5] = 27; // 
        $arrCell[6] = 85; // Fresh Fruit
        // $arrCell[7] = 27; // 
        $arrCell[8] = 101; // Logistics
        $arrCell[9] = 117; // Tourism
        //$arrCell[10] = 85; // 
        //$arrCell[11] = 85; // 
        //$arrCell[12] = 85; // 
        $objPHPExcel->setActiveSheetIndex(1);
        $sheet = $objPHPExcel->getActiveSheet(); //testVar($memberEdp); die;
        foreach($memberEdp as $item){
            $cCell = intval(@$arrCell[$item->commodity_id]);
            if(!$cCell)
                continue;
            $sheet->setCellValue('B'.$cCell, $item->agencies_title)
                ->setCellValue('C'.$cCell, intval(@$item->outcome[2014]['export_sales']))
                ->setCellValue('D'.$cCell, intval(@$item->outcome[2015]['sales']))
                ->setCellValue('E'.$cCell, intval(@$item->outcome[2015]['export_sales']))
                ->setCellValue('F'.$cCell, intval(@$item->outcome[2016]['sales']))
                ->setCellValue('G'.$cCell, intval(@$item->outcome[2016]['new_markets']))
                ->setCellValue('H'.$cCell, intval(@$item->outcome[2016]['new_clients']))
                ->setCellValue('I'.$cCell, intval(@$item->outcome[2016]['export_sales']))
                ->setCellValue('J'.$cCell, intval(@$item->outcome[2017]['sales']))
                ->setCellValue('K'.$cCell, intval(@$item->outcome[2017]['new_markets']))
                ->setCellValue('L'.$cCell, intval(@$item->outcome[2017]['new_clients']))
                ->setCellValue('M'.$cCell, intval(@$item->outcome[2017]['export_sales']));
            $arrCell[$item->commodity_id]++;
        }
        
        /* Table 1.1 */
        $planOther = $this->model->get_other_plan_logframe();
        $arrOther = array();
        foreach($planOther as $item){
            if(isset($arrOther[$item->activity_type][$item->activity_year][$item->region]))
                $arrOther[$item->activity_type][$item->activity_year][$item->region]++;
            else
                $arrOther[$item->activity_type][$item->activity_year][$item->region] = 1;
        }
        $objPHPExcel->setActiveSheetIndex(2);
        $sheet = $objPHPExcel->getActiveSheet();
        foreach($arrActivityType as $key=>$val){
            if($key == 11) continue;
            $cCell = $key + 3;
            $sheet->setCellValue('C'.$cCell, intval(@$arrOther[$key][2015][1]))
                ->setCellValue('D'.$cCell, intval(@$arrOther[$key][2015][2]))
                ->setCellValue('E'.$cCell, intval(@$arrOther[$key][2015][3]))
                ->setCellValue('G'.$cCell, intval(@$arrOther[$key][2016][1]))
                ->setCellValue('H'.$cCell, intval(@$arrOther[$key][2016][2]))
                ->setCellValue('I'.$cCell, intval(@$arrOther[$key][2016][3]))
                ->setCellValue('K'.$cCell, intval(@$arrOther[$key][2017][1]))
                ->setCellValue('L'.$cCell, intval(@$arrOther[$key][2017][2]))
                ->setCellValue('M'.$cCell, intval(@$arrOther[$key][2017][3]));        
        }
        
        /* Table 1.2 */
        $xttmOpenNew = $this->model->get_xttm_open_new_logframe();
        $arrOpenNew = array();
        foreach($xttmOpenNew as $item){
            if(isset($arrOpenNew[$item->year][$item->region]))
                $arrOpenNew[$item->year][$item->region] += $item->xttm_open_new;
            else
                $arrOpenNew[$item->year][$item->region] = $item->xttm_open_new;
        }
        $objPHPExcel->setActiveSheetIndex(2);
        $sheet = $objPHPExcel->getActiveSheet();
        $cCell = 20;
        $sheet->setCellValue('C'.$cCell, intval(@$arrOther[$key][2015][1]))
            ->setCellValue('D'.$cCell, intval(@$arrOther[$key][2015][2]))
            ->setCellValue('E'.$cCell, intval(@$arrOther[$key][2015][3]))
            ->setCellValue('G'.$cCell, intval(@$arrOther[$key][2016][1]))
            ->setCellValue('H'.$cCell, intval(@$arrOther[$key][2016][2]))
            ->setCellValue('I'.$cCell, intval(@$arrOther[$key][2016][3]))
            ->setCellValue('K'.$cCell, intval(@$arrOther[$key][2017][1]))
            ->setCellValue('L'.$cCell, intval(@$arrOther[$key][2017][2]))
            ->setCellValue('M'.$cCell, intval(@$arrOther[$key][2017][3]));        
        
        /* Table 1.5 */
        $allActivity = $this->model->get_activity_logframe(); 
        $arrActivityEvents = array(); // Table 1.6.1
        $arrActivityEventsRegion = array(); // Table 1.6.1
        
        $arrActivitySMEs = array(); // Table 1.6.2
        $arrActivitySMEsRegion = array(); // Table 1.6.2
        
        $objPHPExcel->setActiveSheetIndex(4);
        $sheet = $objPHPExcel->getActiveSheet();
        $cCell = 6;
        foreach($allActivity as $item){
            if($item->activity_type == 11){
                $sheet->setCellValue('A'.$cCell, date('d/m/Y', strtotime($item->start_date)))
                    ->setCellValue('B'.$cCell, $item->activity_address)
                    ->setCellValue('C'.$cCell, $item->title)
                    ->setCellValue('D'.$cCell, $item->number_center)
                    ->setCellValue('E'.$cCell, $item->number_business_staff)
                    ->setCellValue('F'.$cCell, $item->number_businesses)
                    ->setCellValue('G'.$cCell, @$item->outcome['achievements'])
                    ->setCellValue('H'.$cCell, @$item->outcome['empirical']);
                $cCell++;
            }
            //Lấy dữ liệu cho Table 1.6.1
            if(isset($arrActivityEvents[$item->activity_type][$item->commodity_id]))
                $arrActivityEvents[$item->activity_type][intval($item->commodity_id)]++;
            else
                $arrActivityEvents[$item->activity_type][intval($item->commodity_id)] = 1;
                
            if(isset($arrActivityEventsRegion[$item->activity_type][intval($item->region)]))
                $arrActivityEventsRegion[$item->activity_type][intval($item->region)]++;
            else
                $arrActivityEventsRegion[$item->activity_type][intval($item->region)] = 1;
                
            //Lấy dữ liệu cho Table 1.6.1    
            if(isset($arrActivitySMEs[$item->activity_type][intval($item->commodity_id)]))
                $arrActivitySMEs[$item->activity_type][intval($item->commodity_id)] += $item->number_businesses;
            else
                $arrActivitySMEs[$item->activity_type][intval($item->commodity_id)] = $item->number_businesses;
            if(isset($arrActivitySMEsRegion[$item->activity_type][intval($item->region)]))
                $arrActivitySMEsRegion[$item->activity_type][intval($item->region)] += $item->number_businesses;
            else
                $arrActivitySMEsRegion[$item->activity_type][intval($item->region)] = $item->number_businesses;
        }
        // Tính tổng
        /* if($cCell > 5){
        $sheet->mergeCells('A'.$cCell.':C'.$cCell); 
        $sheet->setCellValue('A'.$cCell, 'Tổng')
                ->setCellValue('D'.$cCell, '=SUM(D5:D'.($cCell-1).')')
                ->setCellValue('E'.$cCell, '=SUM(E5:E'.($cCell-1).')')
                ->setCellValue('F'.$cCell, '=SUM(F5:F'.($cCell-1).')');
        }*/        
        /* Table 1.6.1 */
        $objPHPExcel->setActiveSheetIndex(5);
        $sheet = $objPHPExcel->getActiveSheet();
        foreach($arrActivityType as $key=>$val){
            if($key == 11) continue;
            $cCell = $key + 3;
            $sheet->setCellValue('D'.$cCell, intval(@$arrActivityEvents[$key][1]))
                ->setCellValue('E'.$cCell, intval(@$arrActivityEvents[$key][2]))
                ->setCellValue('F'.$cCell, intval(@$arrActivityEvents[$key][3]))
                ->setCellValue('G'.$cCell, intval(@$arrActivityEvents[$key][4]))
                ->setCellValue('H'.$cCell, intval(@$arrActivityEvents[$key][5]))
                ->setCellValue('I'.$cCell, intval(@$arrActivityEvents[$key][6]))
                ->setCellValue('J'.$cCell, intval(@$arrActivityEvents[$key][7]))
                ->setCellValue('K'.$cCell, intval(@$arrActivityEvents[$key][8]))
                ->setCellValue('L'.$cCell, intval(@$arrActivityEvents[$key][9]))
                ->setCellValue('M'.$cCell, intval(@$arrActivityEvents[$key][10]))
                ->setCellValue('N'.$cCell, intval(@$arrActivityEvents[$key][11]))
                ->setCellValue('O'.$cCell, intval(@$arrActivityEvents[$key][12]))
                ->setCellValue('P'.$cCell, intval(@$arrActivityEventsRegion[$key][1]))// Theo vùng
                ->setCellValue('Q'.$cCell, intval(@$arrActivityEventsRegion[$key][2]))
                ->setCellValue('R'.$cCell, intval(@$arrActivityEventsRegion[$key][3]));        
        }
        
        /* Table 1.6.2 */
        $objPHPExcel->setActiveSheetIndex(5);
        $sheet = $objPHPExcel->getActiveSheet();
        foreach($arrActivityType as $key=>$val){
            if($key == 11) continue;
            $cCell = $key + 17;
            $sheet->setCellValue('D'.$cCell, intval(@$arrActivitySMEs[$key][1]))
                ->setCellValue('E'.$cCell, intval(@$arrActivitySMEs[$key][2]))
                ->setCellValue('F'.$cCell, intval(@$arrActivitySMEs[$key][3]))
                ->setCellValue('G'.$cCell, intval(@$arrActivitySMEs[$key][4]))
                ->setCellValue('H'.$cCell, intval(@$arrActivitySMEs[$key][5]))
                ->setCellValue('I'.$cCell, intval(@$arrActivitySMEs[$key][6]))
                ->setCellValue('J'.$cCell, intval(@$arrActivitySMEs[$key][7]))
                ->setCellValue('K'.$cCell, intval(@$arrActivitySMEs[$key][8]))
                ->setCellValue('L'.$cCell, intval(@$arrActivitySMEs[$key][9]))
                ->setCellValue('M'.$cCell, intval(@$arrActivitySMEs[$key][10]))
                ->setCellValue('N'.$cCell, intval(@$arrActivitySMEs[$key][11]))
                ->setCellValue('O'.$cCell, intval(@$arrActivitySMEs[$key][12]))
                ->setCellValue('P'.$cCell, intval(@$arrActivitySMEs[$key][1]))// Theo vùng
                ->setCellValue('Q'.$cCell, intval(@$arrActivitySMEs[$key][2]))
                ->setCellValue('R'.$cCell, intval(@$arrActivitySMEs[$key][3]));
        }
        
        /* Table 1.6.3 */
        $cCell = 33;
        foreach($allActivity as $item)
            if($item->activity_type == 3){
                $sheet->setCellValue('A'.$cCell, date('d/m/Y', strtotime($item->start_date)))
                    ->setCellValue('B'.$cCell, $item->activity_address)
                    ->setCellValue('C'.$cCell, $item->title)
                    ->setCellValue('D'.$cCell, @$arrIndustries[$item->commodity_id])
                    ->setCellValue('E'.$cCell, intval($item->number_business_staff))
                    ->setCellValue('F'.$cCell, intval($item->number_businesses))
                    ->setCellValue('G'.$cCell, intval($item->number_vietrade))
                    ->setCellValue('H'.$cCell, @$item->outcome['achievements'])
                    ->setCellValue('I'.$cCell, @$item->outcome['empirical'])
                    ->setCellValue('J'.$cCell, @$item->outcome['after1month'])
                    ->setCellValue('K'.$cCell, @$item->outcome['after2quarter'])
                    ->setCellValue('L'.$cCell, @$item->outcome['after3quarter'])
                    ->setCellValue('M'.$cCell, @$item->outcome['after4quarter']);
                $cCell++;
            }
        
        /* Table 1.6.4 */
        $cCell = 70;
        foreach($allActivity as $item)
            if($item->activity_type == 5){
                $sheet->setCellValue('A'.$cCell, date('d/m/Y', strtotime($item->start_date)))
                    ->setCellValue('B'.$cCell, $item->activity_address)
                    ->setCellValue('C'.$cCell, $item->title)
                    ->setCellValue('D'.$cCell, @$arrIndustries[$item->commodity_id])
                    ->setCellValue('E'.$cCell, intval($item->number_business_staff))
                    ->setCellValue('F'.$cCell, intval($item->number_businesses))
                    ->setCellValue('G'.$cCell, intval($item->number_vietrade))
                    ->setCellValue('H'.$cCell, @$item->outcome['achievements'])
                    ->setCellValue('I'.$cCell, @$item->outcome['empirical'])
                    ->setCellValue('J'.$cCell, @$item->outcome['after1month'])
                    ->setCellValue('K'.$cCell, @$item->outcome['after2quarter'])
                    ->setCellValue('L'.$cCell, @$item->outcome['after3quarter'])
                    ->setCellValue('M'.$cCell, @$item->outcome['after4quarter']);
                $cCell++;
            }
        
        /* Table 1.6.5 */
        $cCell = 106;
        foreach($allActivity as $item)
            if($item->activity_type == 6){
                $sheet->setCellValue('A'.$cCell, date('d/m/Y', strtotime($item->start_date)))
                    ->setCellValue('B'.$cCell, $item->activity_address)
                    ->setCellValue('C'.$cCell, $item->title)
                    ->setCellValue('D'.$cCell, @$arrIndustries[$item->commodity_id])
                    ->setCellValue('E'.$cCell, intval($item->number_business_staff))
                    ->setCellValue('F'.$cCell, intval($item->number_businesses))
                    ->setCellValue('G'.$cCell, intval($item->number_vietrade))
                    ->setCellValue('H'.$cCell, @$item->outcome['achievements'])
                    ->setCellValue('I'.$cCell, @$item->outcome['empirical'])
                    ->setCellValue('J'.$cCell, @$item->outcome['after1month'])
                    ->setCellValue('K'.$cCell, @$item->outcome['after2quarter'])
                    ->setCellValue('L'.$cCell, @$item->outcome['after3quarter'])
                    ->setCellValue('M'.$cCell, @$item->outcome['after4quarter']);
                $cCell++;
            }
        
        /* Table 2.1 */
        $objPHPExcel->setActiveSheetIndex(6);
        $sheet = $objPHPExcel->getActiveSheet();
        $cCell = 5;
        foreach($allActivity as $item)
            if($item->activity_type == 9){
                $sheet->setCellValue('A'.$cCell, date('d/m/Y', strtotime($item->start_date)))
                    ->setCellValue('B'.$cCell, $item->activity_address)
                    ->setCellValue('C'.$cCell, $item->title)
                    ->setCellValue('D'.$cCell, @$arrIndustries[$item->commodity_id])
                    ->setCellValue('E'.$cCell, intval($item->number_business_staff))
                    ->setCellValue('F'.$cCell, intval($item->number_businesses))
                    ->setCellValue('G'.$cCell, intval($item->number_vietrade))
                    ->setCellValue('H'.$cCell, intval($item->number_press_agencies))
                    ->setCellValue('I'.$cCell, @$item->outcome['achievements'])
                    ->setCellValue('J'.$cCell, @$item->outcome['empirical']);
                $cCell++;
            }
           
        /* Table 3.1 */
        $allActivityTPOs = $this->model->get_training_organised_by_TPOs_TSIs(); 
        $objPHPExcel->setActiveSheetIndex(7);
        $sheet = $objPHPExcel->getActiveSheet();
        $cCell = 5;
        foreach($allActivityTPOs as $item){
            $sheet->setCellValue('A'.$cCell, date('d/m/Y', strtotime($item->start_date)))
                ->setCellValue('B'.$cCell, $item->activity_address)
                ->setCellValue('C'.$cCell, $item->title)
                ->setCellValue('D'.$cCell, @$arrIndustries[$item->commodity_id])
                ->setCellValue('E'.$cCell, $item->agencies_title)
                ->setCellValue('F'.$cCell, intval($item->number_businesses))
                ->setCellValue('G'.$cCell, @$item->outcome['achievements'])
                ->setCellValue('H'.$cCell, @$item->outcome['empirical'])
                ->setCellValue('I'.$cCell, '')
                ->setCellValue('J'.$cCell, '');
            $cCell++;
        }
        
           
        /* Table 3.2 */
        $allActivityTPOs = $this->model->get_training_organised_by_PROMOCEN(); 
        $objPHPExcel->setActiveSheetIndex(8);
        $sheet = $objPHPExcel->getActiveSheet();
        $cCell = 6;
        foreach($allActivityTPOs as $item){
            $sheet->setCellValue('A'.$cCell, date('d/m/Y', strtotime($item->start_date)))
                ->setCellValue('B'.$cCell, $item->activity_address)
                ->setCellValue('C'.$cCell, $item->title)
                ->setCellValue('D'.$cCell, @$arrIndustries[$item->commodity_id])
                ->setCellValue('E'.$cCell, $item->agencies_title)
                ->setCellValue('F'.$cCell, intval($item->number_businesses))
                ->setCellValue('G'.$cCell, @$item->outcome['achievements'])
                ->setCellValue('H'.$cCell, @$item->outcome['empirical'])
                ->setCellValue('I'.$cCell, '')
                ->setCellValue('J'.$cCell, '');
            $cCell++;
        }
        
        $objPHPExcel->setActiveSheetIndex(0);
             
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Logframe-'.date('Y-m-d').'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: '.gmdate('D, d M Y H:i:s').' GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
} 
