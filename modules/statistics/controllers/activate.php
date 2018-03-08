<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
        
class StatisticsControllersActivate extends FSControllers{
    function __construct(){
        parent::__construct();
    }

    function display(){
        $cities = $this->model->getCitiesArray();
        $list = $this->model->getList();
        $total = $this->model->getTotal();
		$pagination = $this->model->getPagination($total); 
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/default.php');
    }
    
    function list_activate(){
        $cities = $this->model->getCitiesArray();
        $list = $this->model->getList();
        $total = $this->model->getTotal();
		$pagination = $this->model->getPagination($total); 
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/list_activate.php');
    }
    
    function create(){
        $plans = $this->model->getActivityPlan();
        $cities = $this->model->getCitiesArray();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/create.php');
    }
    
    function do_save(){
        global $user;
        if(!$user->userID)
            setRedirect(FSRoute::_('index.php?module=members&view=members&task=login'), 'Bạn chưa đăng nhập!');
        $data = $this->model->getData();
        if(IS_ADMIN || in_array($user->userInfo->type, array(1,2))){
            $id = $this->model->saveActivate();
            if($id)
                setRedirect(FSRoute::_('index.php?module=statistics&view=activate&task=create'), 'Lập báo cáo thành công!');
        }else
            setRedirect(FSRoute::_('index.php?module=statistics&view=activate&task=create'), 'Liên hệ admin để thực hiện thao tác này!');
    }
    
    function update(){
        global $user, $arrActivityKeyTime;
        $data = $this->model->getData();
        if(!$data)
            setRedirect(FSRoute::_('index.php?module=statistics&view=activate&task=display'), 'Không có hoạt động!');
        $plans = $this->model->getActivityPlan();
        $cities = $this->model->getCitiesArray();
        $participants = $this->model->getListParticipantsByActivityId($data->id);
        $activityOutcome = array();
        foreach($arrActivityKeyTime as $key){
            $activityOutcome[$key] = '';
        }
        //if($this->checkParticipants($data->id, $user->userID) && $user->userID){
            $list = $this->model->getActivityOutcome($data->id, $data->member_code);
            foreach($list as $item){
                if(isset($activityOutcome[$item->activity_type]))
                    $activityOutcome[$item->activity_type] = $item->outcome;
            }
        //}
        $city = $this->model->get_record('code=\''.$data->city_code.'\'', 'fs_members', 'fullname');
        $officers = $this->model->get_record('code=\''.$data->officers_code.'\'', 'fs_members', 'fullname');
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/update.php');
    }
    
    function view(){
        global $user, $arrActivityKeyTime;
        $data = $this->model->getData();
        if(!$data)
            setRedirect(FSRoute::_('index.php?module=statistics&view=activate&task=display'), 'Không có hoạt động!');
        $plans = $this->model->getActivityPlan();
        $cities = $this->model->getCitiesArray();
        $participants = $this->model->getListParticipantsByActivityId($data->id);
        $activityOutcome = array();
        foreach($arrActivityKeyTime as $key){
            $activityOutcome[$key] = '';
        }
        //if($this->checkParticipants($data->id, $user->userID) && $user->userID){
            $list = $this->model->getActivityOutcome($data->id, $data->member_code);
            foreach($list as $item){
                if(isset($activityOutcome[$item->activity_type]))
                    $activityOutcome[$item->activity_type] = $item->outcome;
            }
        //}
        $city = $this->model->get_record('code=\''.$data->city_code.'\'', 'fs_members', 'fullname');
        $officers = $this->model->get_record('code=\''.$data->officers_code.'\'', 'fs_members', 'fullname');
        $creator = $this->model->get_record('code=\''.$data->member_code.'\'', 'fs_members', 'fullname,agencies_title');
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/view.php');
    }
    
    function do_update(){
        global $user;
        if(!$user->userID)
            setRedirect(FSRoute::_('index.php?module=members&view=members&task=login'), 'Bạn chưa đăng nhập!');
        $data_id = FSInput::get('data_id', 0);
        $data_member_code = FSInput::get('data_member_code', 0);
        if(!IS_ADMIN && $user->userInfo->code != $data_member_code && !in_array($user->userInfo->type, array(1,2)))
            setRedirect(FSRoute::_('index.php?module=statistics&view=activate&task=update&id='.$data_id), 'Liên hệ admin để thực hiện thao tác này!');
        $this->model->do_update();
        $is_lock = FSInput::get('is_lock', 0, 'int');
        if($is_lock == 0)
            $this->model->saveActivate();
        setRedirect(FSRoute::_('index.php?module=statistics&view=activate&task=update&id='.$data_id), 'Cập nhật thành công');
    }
    
    function checkParticipants($activity_id = 0, $member_code = ''){
        return true;
    }
    
    function open_participants_box(){
        $id = FSInput::get('id', 0);
        $data = $this->model->getData();
        $list = $this->model->getListParticipants();
        $total = $this->model->getTotalParticipants();
		$pagination = $this->model->getPagination($total); 
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/show_popup.php');
    }
    
    function open_business_report(){ 
        $title = base64_decode(FSInput::get('title', ''));
        $activity_type = FSInput::get('activity_type', 1);
        $list = $this->model->getBusinessReport();
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/business_report.php');
    }
    
    function add_participants(){
        $json = array(
            'error' => true,
            'msg' => 'Có lỗi trong quá trình xử lý. Bạn vui lòng kiểm tra lại!'
        );
        $id = $this->model->add_participants();
        if($id){
            $json['error'] = false;
            $json['id'] = fsEncode($id);
        }
        echo json_encode($json);
    }
    
    function del_participants(){
        $json = array(
            'error' => true,
            'msg' => 'Có lỗi trong quá trình xử lý. Bạn vui lòng kiểm tra lại!'
        );
        $id = fsDecode(FSInput::get('id', '0'));
        $id = $this->model->_remove('id='.$id, 'fs_activity_participants');
        if($id)
            $json['error'] = false;
        echo json_encode($json);
    }
    
    function filter_outcome(){
        $json = array(
            'error' => true,
            'html' => '<option value="0">-- Lựa chọn từ kế hoạch CT --</option>'
        );
        $plans = $this->model->filter_outcome();
        foreach($plans as $item){
            $json['html'] .= '<option value="'.$item->id.'">'.$item->activity_title.'</option>';
        }
        $json['error'] = false;
        echo json_encode($json);
    }
    
    function open_risk_box(){
        $id = FSInput::get('id', 0);
        $list = $this->model->getListRisks();
        $total = $this->model->getTotalRisks();
		$pagination = $this->model->getPagination($total); 
        require(PATH_BASE.'modules/'.$this->module.'/views/'.$this->view.'/risk_box.php');
    }
    
    function add_risk(){
        $json = array(
            'error' => true,
            'msg' => 'Có lỗi trong quá trình xử lý. Bạn vui lòng kiểm tra lại!'
        );
        $id = $this->model->add_risk();
        if($id){
            $json['error'] = false;
            $json['id'] = fsEncode($id);
        }
        echo json_encode($json);
    }
    
    function del_risk(){
        $json = array(
            'error' => true,
            'msg' => 'Có lỗi trong quá trình xử lý. Bạn vui lòng kiểm tra lại!'
        );
        $id = fsDecode(FSInput::get('id', '0'));
        $id = $this->model->_remove('id='.$id, 'fs_report_activity_risks');
        if($id)
            $json['error'] = false;
        echo json_encode($json);
    }
    
    function excel_activate(){
        global $user, $arrActivityKeyTime, $arrProgram, $arrActivityType, $arrIndustries, $arrOperationalStatus;
        $data = $this->model->getData();
        if(!$data)
            setRedirect(FSRoute::_('index.php?module=statistics&view=activate&task=display'), 'Không có hoạt động!');
        $activityOutcome = array();
        foreach($arrActivityKeyTime as $key){
            $activityOutcome[$key] = '';
        }
        $list = $this->model->getActivityOutcome($data->id, $data->member_code);
        foreach($list as $item){
            if(isset($activityOutcome[$item->activity_type]))
                $activityOutcome[$item->activity_type] = $item->outcome;
        }
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Vietrade")
							 ->setLastModifiedBy("Vietrade")
							 ->setTitle("Office 2007 XLSX Vietrade Document")
							 ->setSubject("Office 2007 XLSX Vietrade Document")
							 ->setDescription("Vietrade report ".date('d-m-Y'))
							 ->setKeywords("Vietrade report")
							 ->setCategory("Vietrade report");
                             
                             
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1"); 
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Báo cáo hoạt động');
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(15)->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );
        
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Chương trình')
                                        ->setCellValue('B2', @$arrProgram[$data->program]);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Loại hình hoạt động')
                                        ->setCellValue('B3', @$arrActivityType[$data->activity_type])
                                        ->setCellValue('C3', 'Thời gian')
                                        ->setCellValue('D3', date('d/m/Y', strtotime($data->start_date)).' - '.date('d/m/Y', strtotime($data->finish_date)));
        
        $plan = $this->model->get_record('id=\''.$data->activity_plan_id.'\'', 'fs_activity_plan', 'activity_title');
        $city = $this->model->get_record('code=\''.$data->city_code.'\'', 'fs_members', 'fullname');
        $officers = $this->model->get_record('code=\''.$data->officers_code.'\'', 'fs_members', 'fullname');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'Mã hoạt động')
                                        ->setCellValue('B4', @$plan->activity_title)
                                        ->setCellValue('C4', 'Cán bộ phụ trách')
                                        ->setCellValue('D4', (($city)?$city->fullname:$data->city_code).' - '.(($officers)?$officers->fullname:$data->officers_code));
        
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Ngành hàng')
                                        ->setCellValue('B5', @$arrIndustries[$data->commodity_id])
                                        ->setCellValue('C5', 'Thời gian')
                                        ->setCellValue('D5', $data->number_participants.' ( '.$data->number_participants_females.' nữ)');
                                        
        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Khác')
                                        ->setCellValue('B6', @$data->commodities_outside)
                                        ->setCellValue('C6', 'Ngân sách chương trình')
                                        ->setCellValue('D6', number_format($data->budget_program, 0, ',', '.').' VNĐ');
                                        
        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Địa điểm')
                                        ->setCellValue('B7', @$data->activity_address)
                                        ->setCellValue('C7', 'Ngân sách đối ứng')
                                        ->setCellValue('D7', number_format($data->budget_reciprocal, 0, ',', '.').' VNĐ');
        $cCell = 8;
        if($data->activity_type == 3 || $data->activity_type == 4){
            $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Số gian hàng')
                                        ->setCellValue('B8', $data->activity_address);  
            $objPHPExcel->getActiveSheet()->mergeCells("B8:D8");    
            
            $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Số lượt khách')
                                        ->setCellValue('B9', $data->number_visitors);  
            $objPHPExcel->getActiveSheet()->mergeCells("B9:D9");
            
            $objPHPExcel->getActiveSheet()->setCellValue('A10', 'Số giao dịch')
                                        ->setCellValue('B10', $data->number_transactions);  
            $objPHPExcel->getActiveSheet()->mergeCells("B10:D10");
            
            $objPHPExcel->getActiveSheet()->setCellValue('A11', 'Số hợp đồng đã ký kết')
                                        ->setCellValue('B11', $data->number_contracts_signed);  
            $objPHPExcel->getActiveSheet()->mergeCells("B11:D11");
            
            $objPHPExcel->getActiveSheet()->setCellValue('A12', 'Doanh thu tại chỗ')
                                        ->setCellValue('B12', number_format($data->revenue_spot_vnd, 0, ',', '.').' VNĐ')
                                        ->setCellValue('C12', number_format($data->revenue_spot_usd, 0, ',', '.').' USD');  
            $cCell = 13;
        }
        
        foreach($activityOutcome as $key=>$val){
            if($val == '')
                continue;
                $data_title = '';
                switch($key){
                    case 'after':
                        $title = FSText::_('Kết quả ngay sau hoạt động').':';
                        break;
                    case 'after1month':
                        $title = FSText::_('Kết quả đạt được sau 1 tháng').':';
                        break;
                    case 'empirical':
                        $title = FSText::_('Thách thức/ Rủi ro').':';
                        break;    
                    default:
                        $quarter = getQuarterText($data->start_date, $key);
                        $title = FSText::_('Kết quả đạt được quý').' '.$quarter['text'].':';
                }
                
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$cCell, $title)
                                        ->setCellValue('B'.$cCell, $val);  
            $objPHPExcel->getActiveSheet()->mergeCells("B".$cCell.":D".$cCell);
            $cCell++;
        } 
        
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$cCell, 'Tình trạng hoạt động')
                                        ->setCellValue('B'.$cCell, @$arrOperationalStatus[$data->status]);  
        $objPHPExcel->getActiveSheet()->mergeCells("B".$cCell.":D".$cCell);
        
        $styleArray = array(
        'borders' => array(
            'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' . 
            $objPHPExcel->getActiveSheet()->getHighestColumn() . 
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->applyFromArray($styleArray);
        
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' . 
            $objPHPExcel->getActiveSheet()->getHighestColumn() . 
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getAlignment()
            ->setWrapText(true)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                                                                                                                                
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Bao-cao-hoat-dong-'.$data->id.'('.date('d-m-Y').').xls"');
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
    
    function excel_activate_persons(){
        $data = $this->model->getData();
        if(!$data)
            setRedirect(FSRoute::_('index.php?module=statistics&view=activate&task=display'), 'Không có hoạt động!');
        $participants = $this->model->getListParticipantsByActivityId($data->id);
        
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
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(40);
        
        $sheet->mergeCells("A1:F1"); 
        $sheet->setCellValue('A1', 'Danh sách người tham gia');
        $sheet->getStyle("A1")->getFont()->setSize(15)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );
        $sheet->setCellValue('A2', 'STT');
        $sheet->setCellValue('B2', FSText::_('Tên'));
        $sheet->setCellValue('C2', FSText::_('Đơn vị'));
        $sheet->setCellValue('D2', FSText::_('_Nam_').'/'.FSText::_('Nữ'));
        $sheet->setCellValue('E2', FSText::_('Điện thoại'));
        $sheet->setCellValue('F2', FSText::_('Email'));
        $sheet->getStyle('A2:F2')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        );
        $sheet->getStyle("A2:F2")->getFont()->setSize(13);
        
        $cCell = 2;
        $i = 0;
        foreach($participants as $item){
            $i++;
            $cCell++;
            $sheet->setCellValue('A'.$cCell, $i);
            $sheet->setCellValue('B'.$cCell, $item->participants_title);
            $sheet->setCellValue('C'.$cCell, $item->agencies_title);
            $sheet->setCellValue('D'.$cCell, ($item->sex == 1)?'Nam':'Nữ');
            $sheet->setCellValue('E'.$cCell, $item->mobile);
            $sheet->setCellValue('F'.$cCell, $item->email);
            $sheet->getStyle('A'.$cCell)->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            );
        }
        
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
        
        $sheet->getStyle(
            'A1:' . 
            $sheet->getHighestColumn() . 
            $sheet->getHighestRow()
        )->getAlignment()
            ->setWrapText(true)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Danh-sanh-tham-gia-hoat-dong-'.$data->id.'('.date('d-m-Y').').xls"');
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
    
    function word_activate(){
        global $user, $arrActivityKeyTime, $arrProgram, $arrActivityType, $arrIndustries, $arrOperationalStatus;
        $data = $this->model->getData();
        if(!$data)
            setRedirect(FSRoute::_('index.php?module=statistics&view=activate&task=display'), 'Không có hoạt động!');
        $activityOutcome = array();
        foreach($arrActivityKeyTime as $key){
            $activityOutcome[$key] = '';
        }
        $list = $this->model->getActivityOutcome($data->id, $data->member_code);
        foreach($list as $item){
            if(isset($activityOutcome[$item->activity_type]))
                $activityOutcome[$item->activity_type] = $item->outcome;
        }
        
        \PhpOffice\PhpWord\Autoloader::register();
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $header = array('size' => 14, 'bold' => true);
        
        $styleTable = array('borderSize' => 6, 'borderColor' => '999999');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'FFFF00');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellHCentered = array('align' => 'center');
        $cellVCentered = array('valign' => 'center');
        
        $phpWord->addTableStyle('Colspan Rowspan', $styleTable);
        $table = $section->addTable('Colspan Rowspan');
        
        $table->addRow();
        $cell = $table->addCell(10000, array('gridSpan' => 4, 'valign' => 'center'));
        $textrun = $cell->addTextRun($cellHCentered);
        $textrun->addText(htmlspecialchars('Báo cáo hoạt động'), $header);
        
        $table->addRow(); 
        $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Loại hình hoạt động'));
        $table->addCell(3000, $cellVCentered)->addText(htmlspecialchars(@$arrActivityType[$data->activity_type]));
        $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Thời gian'));
        $table->addCell(3000, $cellVCentered)->addText(htmlspecialchars(date('d/m/Y', strtotime($data->start_date)).' - '.date('d/m/Y', strtotime($data->finish_date))));
        
        $plan = $this->model->get_record('id=\''.$data->activity_plan_id.'\'', 'fs_activity_plan', 'activity_title');
        $city = $this->model->get_record('code=\''.$data->city_code.'\'', 'fs_members', 'fullname');
        $officers = $this->model->get_record('code=\''.$data->officers_code.'\'', 'fs_members', 'fullname');
        $table->addRow(); 
        $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Mã hoạt động'));
        $table->addCell(3000, $cellVCentered)->addText(htmlspecialchars(@$plan->activity_title));
        $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Cán bộ phụ trách'));
        $table->addCell(3000, $cellVCentered)->addText(htmlspecialchars((($city)?$city->fullname:$data->city_code).' - '.(($officers)?$officers->fullname:$data->officers_code)));
        
        $table->addRow(); 
        $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Ngành hàng'));
        $table->addCell(3000, $cellVCentered)->addText(htmlspecialchars(@$arrIndustries[$data->commodity_id]));
        $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Thời gian'));
        $table->addCell(3000, $cellVCentered)->addText(htmlspecialchars($data->number_participants.' ( '.$data->number_participants_females.' nữ)'));
        
        $table->addRow(); 
        $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Khác'));
        $table->addCell(3000, $cellVCentered)->addText(htmlspecialchars(@$data->commodities_outside));
        $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Ngân sách chương trình'));
        $table->addCell(3000, $cellVCentered)->addText(htmlspecialchars(number_format($data->budget_program, 0, ',', '.').' VNĐ'));
        
        $table->addRow(); 
        $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Địa điểm'));
        $table->addCell(3000, $cellVCentered)->addText(htmlspecialchars(@$data->activity_address));
        $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Ngân sách đối ứng'));
        $table->addCell(3000, $cellVCentered)->addText(htmlspecialchars(number_format($data->budget_reciprocal, 0, ',', '.').' VNĐ'));
        
        if($data->activity_type == 3 || $data->activity_type == 4){
            $table->addRow(); 
            $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Số gian hàng'));
            $table->addCell(8000, array('gridSpan' => 3, 'valign' => 'center'))->addText(htmlspecialchars($data->activity_address));
            
            $table->addRow(); 
            $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Số lượt khách'));
            $table->addCell(8000, array('gridSpan' => 3, 'valign' => 'center'))->addText(htmlspecialchars($data->number_visitors));
            
            $table->addRow(); 
            $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Số giao dịch'));
            $table->addCell(8000, array('gridSpan' => 3, 'valign' => 'center'))->addText(htmlspecialchars($data->number_transactions));
            
            $table->addRow(); 
            $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Số hợp đồng đã ký kết'));
            $table->addCell(8000, array('gridSpan' => 3, 'valign' => 'center'))->addText(htmlspecialchars($data->number_contracts_signed));
            
            $table->addRow(); 
            $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Doanh thu tại chỗ'));
            $table->addCell(8000, array('gridSpan' => 3, 'valign' => 'center'))->addText(htmlspecialchars(number_format($data->revenue_spot_vnd, 0, ',', '.').' VNĐ - '.number_format($data->revenue_spot_usd, 0, ',', '.').' USD'));
        }
        
        foreach($activityOutcome as $key=>$val){
            if($val == '')
                continue;
                $data_title = '';
                switch($key){
                    case 'after':
                        $title = FSText::_('Kết quả ngay sau hoạt động').':';
                        break;
                    case 'after1month':
                        $title = FSText::_('Kết quả đạt được sau 1 tháng').':';
                        break;
                    case 'empirical':
                        $title = FSText::_('Thách thức/ Rủi ro').':';
                        break;    
                    default:
                        $quarter = getQuarterText($data->start_date, $key);
                        $title = FSText::_('Kết quả đạt được quý').' '.$quarter['text'].':';
                }
            $table->addRow(); 
            $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars($title));
            $table->addCell(8000, array('gridSpan' => 3, 'valign' => 'center'))->addText(htmlspecialchars($val));
        } 
        
        $table->addRow(); 
        $table->addCell(2000, $cellVCentered)->addText(htmlspecialchars('Tình trạng hoạt động'));
        $table->addCell(8000, array('gridSpan' => 3, 'valign' => 'center'))->addText(htmlspecialchars(@$arrOperationalStatus[$data->status]));
        
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="Bao-cao-hoat-dong-'.$data->id.'('.date('d-m-Y').').docx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save("php://output");              
    }        
    
    
} 