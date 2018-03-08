<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class StatisticsModelsActivate extends FSModels{
    
    function getActivityPlan(){
        global $db;
        $query = '  SELECT *
                    FROM fs_activity_plan
                    WHERE published = 1
                    ORDER BY id DESC';
        $result = $db->query_limit($query, 30, $this->page);
        return $db->getObjectList();
    }
    
    function filter_outcome(){
        global $db;
        $where = '';
        $program = FSInput::get('program', 0);
        if($program)
            $where .= ' AND program = '.$program;
        $activity_type = FSInput::get('activity_type', 0);
        if($activity_type)
            $where .= ' AND activity_type = '.$activity_type;
        $query = '  SELECT *
                    FROM fs_activity_plan
                    WHERE published = 1 '.$where.'
                    ORDER BY id DESC
                    LIMIT 30';
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function saveActivate(){
        global $user;
        $row = array();
        $row['program'] = FSInput::get('program', 0);
        $row['title'] = FSInput::get('title', '');
        $row['activity_type'] = FSInput::get('activity_type', 0);
        $row['activity_plan_id'] = FSInput::get('activity_plan_id', 0);
        $row['member_code'] = $user->userInfo->code;
        
        $start_date = explode('/', FSInput::get('start_date', date('d/m/Y')));
        $row['start_date'] = @$start_date[2].'-'.@$start_date[1].'-'.@$start_date[0].' 09:00:00';
        
        $finish_date = explode('/', FSInput::get('finish_date', date('d/m/Y')));
        $row['finish_date'] = $finish_date[2].'-'.$finish_date[1].'-'.$finish_date[0].' 09:00:00';
        $row['activity_address'] = FSInput::get('activity_address', '');
        $row['city_code'] = FSInput::get('city_code', '');
        $row['officers_code'] = FSInput::get('officers_code', '');
        $row['commodity_id'] = FSInput::get('commodity_id', 0);
        $row['commodities_outside'] = FSInput::get('commodities_outside', '');
        $row['budget_program'] = FSInput::get('budget_program', '');
        $row['budget_reciprocal'] = FSInput::get('budget_reciprocal', '');
        $row['booth_number'] = FSInput::get('booth_number', 0);
        $row['number_visitors'] = FSInput::get('number_visitors', 0);
        $row['revenue_spot_vnd'] = FSInput::get('revenue_spot_vnd', 0);
        $row['revenue_spot_usd'] = FSInput::get('revenue_spot_usd', 0);
        $row['number_transactions'] = FSInput::get('number_transactions', 0);
        $row['number_contracts_signed'] = FSInput::get('number_contracts_signed', 0);
        
        
        
        $row['created_time'] = date('Y-m-d H:i:s');
        $status = FSInput::get('status', 1);
        $row['published'] = 1; 
        if($_FILES["activity_participants"]["name"]){
            $path_original = 'images'.DS.'activities'.DS.'files'.DS.date('Y/m').DS;
			$path = PATH_BASE.$path_original;
            $fsFile = FSFactory::getClass('FsFiles');
			$file_upload_name = $fsFile->upload_file("activity_participants", $path ,10000000000, '-'.time());
			if($file_upload_name){
				$row['activity_participants'] = str_replace(DS,'/',$path_original).$file_upload_name;
			}
        }
        $data_id = FSInput::get('data_id', 0, 'int'); 
        if($data_id){
            $start_date = explode('/', FSInput::get('ustart_date', date('d/m/Y')));
            $row['start_date'] = $start_date[2].'-'.$start_date[1].'-'.$start_date[0].' 09:00:00';
            
            $id = $data_id;
            $this->_update($row, 'fs_report_activity', 'id='.$id);
        }else
            $id = $this->_add($row, 'fs_report_activity');
        $this->update_activity_participants($id);
        $this->update_activity_risks($id);
        if(!$data_id)
            $this->addActivateAfter($id);
        session_regenerate_id();
        return $id;
    }
    
    function addActivateAfter($id){
        global $user;
        $start_date = FSInput::get('start_date');
        
        /* Kết quả đạt được ngay sau hoạt động */
        $row = array();
        $row['member_code'] = $user->userInfo->code;
        $row['activity_id'] = $id;
        $row['activity_type'] = 'after';
        $row['outcome'] = FSInput::get('achievements', '');
        $quarter = getQuarterText($start_date, 'after');
        $row['quarter'] = $quarter['quarter'];
        $row['year'] = $quarter['year'];
        $row['created_time'] = date('Y-m-d H:i:s');
        $this->_add($row, 'fs_report_activity_outcome');
        
        /* Bài học kinh nghiệm */
        $row = array();
        $row['member_code'] = $user->userInfo->code;
        $row['activity_id'] = $id;
        $row['activity_type'] = 'empirical';
        $row['outcome'] = FSInput::get('empirical', '');
        $quarter = getQuarterText($start_date, 'empirical');
        $row['quarter'] = $quarter['quarter'];
        $row['year'] = $quarter['year'];
        $row['created_time'] = date('Y-m-d H:i:s');
        $this->_add($row, 'fs_report_activity_outcome');
        
        /* Thách thức */
        $row = array();
        $row['member_code'] = $user->userInfo->code;
        $row['activity_id'] = $id;
        $row['activity_type'] = 'challenge';
        $row['outcome'] = FSInput::get('challenge', '');
        $quarter = getQuarterText($start_date, 'challenge');
        $row['quarter'] = $quarter['quarter'];
        $row['year'] = $quarter['year'];
        $row['created_time'] = date('Y-m-d H:i:s');
        $this->_add($row, 'fs_report_activity_outcome');
    }
    
    function update_activity_participants($id){
        global $db;
        
        $this->_update(array('activity_id'=>$id, 'temp'=>''), 'fs_activity_participants', 'temp=\''.session_id().'\'');
        
        /* Tổng số người tham gia */
        $number_participants = FSInput::get('number_participants', 0);
        if(!$number_participants){
            $query = '  SELECT count(id)
                        FROM fs_activity_participants
                        WHERE activity_id = \''.$id.'\'';
            $result = $db->query($query);
            $number_participants = $db->getResult();
        }
        
        $number_participants_females = FSInput::get('number_participants_females', 0);
        if(!$number_participants_females){
            $query = '  SELECT count(id)
                        FROM fs_activity_participants
                        WHERE sex = 2 AND activity_id = \''.$id.'\'';
            $result = $db->query($query);
            $number_participants_females = $db->getResult();
        }
        /* Số cán bộ Trung tâm, Hiệp hội tham gia */
        $number_centre_staff = FSInput::get('number_centre_staff', 0);
        if(!$number_centre_staff){
            $query = '  SELECT count(ap.id)
                        FROM fs_activity_participants AS ap
                            INNER JOIN fs_members AS me ON ap.member_code = me.code
                        WHERE me.type = 1 AND ap.activity_id = \''.$id.'\'';
            $result = $db->query($query);
            $number_centre_staff = $db->getResult();
        }        
        
        /* Số Trung tâm, Hiệp hội tham gia */
        $number_center = FSInput::get('number_center', 0);
        if(!$number_center){
            $query = '  SELECT count(ap.id)
                        FROM fs_activity_participants AS ap
                            INNER JOIN fs_members AS me ON ap.member_code = me.code
                        WHERE me.type = 1 AND ap.activity_id = \''.$id.'\'';
            $result = $db->query($query);
            $number_center = $db->getResult();
        }  
        
        /* Số cán bộ doanh nghiệp tham gia */
        $number_business_staff = FSInput::get('number_business_staff', 0);
        if(!$number_business_staff){
            $query = '  SELECT count(ap.id)
                        FROM fs_activity_participants AS ap
                            INNER JOIN fs_members AS me ON ap.member_code = me.code
                        WHERE me.type = 5 AND ap.activity_id = \''.$id.'\'';
            $result = $db->query($query);
            $number_business_staff = $db->getResult();
        } 
        
        /* Số doanh nghiệp tham gia */
        $number_businesses = FSInput::get('number_businesses', 0);
        if(!$number_businesses){
            $query = '  SELECT count(ap.id)
                        FROM fs_activity_participants AS ap
                            INNER JOIN fs_members AS me ON ap.member_code = me.code
                        WHERE me.type = 5 AND ap.activity_id = \''.$id.'\'';
            $result = $db->query($query);
            $number_businesses = $db->getResult();
        } 
        
        /* Số doanh nghiệp tham gia */
        $number_businesses = FSInput::get('number_businesses', 0);
        if(!$number_businesses){
            $query = '  SELECT count(ap.id)
                        FROM fs_activity_participants AS ap
                            INNER JOIN fs_members AS me ON ap.member_code = me.code
                        WHERE me.type = 5 AND ap.activity_id = \''.$id.'\'';
            $result = $db->query($query);
            $number_businesses = $db->getResult();
        } 
        
        /* Số cán bộ BQL dự án */
        $number_project_managers = FSInput::get('number_project_managers', 0);
        if(!$number_project_managers){
            $query = '  SELECT count(ap.id)
                        FROM fs_activity_participants AS ap
                            INNER JOIN fs_members AS me ON ap.member_code = me.code
                        WHERE me.type IN(2,3,4) AND ap.activity_id = \''.$id.'\'';
            $result = $db->query($query);
            $number_project_managers = $db->getResult();
        }
        
        $row = array();
        $row['number_participants'] = $number_participants;
        $row['number_participants_females'] = $number_participants_females;
        $row['number_centre_staff'] = $number_centre_staff;
        $row['number_center'] = $number_center;
        $row['number_business_staff'] = $number_business_staff;
        $row['number_businesses'] = $number_businesses;
        $row['number_press_agencies'] = FSInput::get('number_press_agencies', 0);
        $row['number_project_managers'] = $number_project_managers;
        $row['number_visitors_activity'] = FSInput::get('number_visitors_activity', 0);
        $row['number_vietrade'] = FSInput::get('number_vietrade', 0);
        $row['number_visitors_activity_females'] = FSInput::get('number_visitors_activity_females', 0);
        
        $this->_update($row, 'fs_report_activity', 'id=\''.$id.'\'');
    }
    
    function update_activity_risks($id){
        global $db;
        $this->_update(array('activity_id'=>$id, 'temp'=>''), 'fs_report_activity_risks', 'temp=\''.session_id().'\'');
    }
    
    function add_participants(){
        $row = array();
        $data_id = FSInput::get('data_id', 0);
        if($data_id){
            $row['temp'] = '';
            $row['activity_id'] = $data_id;
        }else{
            $row['temp'] = session_id();
            $row['activity_id'] = 0;
        }
        $row['member_code'] = FSInput::get('member_code', '');
        $row['participants_title'] = FSInput::get('participants_title', '');
        $row['agencies_title'] = FSInput::get('agencies_title', '');
        $row['sex'] = FSInput::get('sex', '');
        $row['mobile'] = FSInput::get('mobile', '');
        $row['email'] = FSInput::get('email', '');
        $row['created_time'] = date('Y-m-d H:i:s');
        return $this->_add($row, 'fs_activity_participants');
    }
    
    function getListParticipants(){
        global $db;
        $id = FSInput::get('id', 0);
        if($id)
            $sqlWhere = ' activity_id = '.$id;
        else 
            $sqlWhere = 'temp = \''.session_id().'\'';
        $query = '  SELECT *
                    FROM fs_activity_participants
                    WHERE '.$sqlWhere.'
                    ORDER BY id DESC';
        $result = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    /**
     * Lấy tổng số
     * @return Int
     */
    function getTotalParticipants(){
        global $db;
        $query = '  SELECT count(id)
                    FROM fs_activity_participants
                    WHERE temp = \''.session_id().'\'';
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    } 
    
    function getListRisks(){
        global $db;
        $id = FSInput::get('id', 0);
        if($id)
            $sqlWhere = ' activity_id = '.$id;
        else 
            $sqlWhere = 'temp = \''.session_id().'\'';
        $query = '  SELECT *
                    FROM fs_report_activity_risks
                    WHERE '.$sqlWhere.'
                    ORDER BY id DESC';
        $result = $db->query_limit($query, $this->limit, $this->page);
        return $db->getObjectList();
    }
    
    /**
     * Lấy tổng số
     * @return Int
     */
    function getTotalRisks(){
        global $db;
        $query = '  SELECT count(id)
                    FROM fs_report_activity_risks
                    WHERE temp = \''.session_id().'\'';
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    } 
    
    function getListParticipantsByActivityId($id){
        global $db;
        $query = '  SELECT *
                    FROM fs_activity_participants
                    WHERE activity_id = \''.$id.'\'
                    ORDER BY id DESC';
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    /**
     * Phân trang
     * @return Object
     */ 
    function getPagination($total){
		FSFactory::include_class('Pagination');
		$pagination = new Pagination($this->limit, $total, $this->page);
		return $pagination;
	}
    
    function getWhere(){
        global $user;
        $where = '1 = 1';
        $program = FSInput::get('program', 0);
        if($program)
            $where .= ' AND ra.program = '.$program;
        $activity_city = FSInput::get('activity_city', 0);
        if($activity_city)
            $where .= ' AND ra.activity_city = '.$activity_city; 
        $commodity_id = FSInput::get('commodity_id', 0);
        if($commodity_id)
            $where .= ' AND ra.commodity_id = '.$commodity_id; 
        $activity_type = FSInput::get('activity_type', 0);
        if($activity_type)
            $where .= ' AND ra.activity_type = '.$activity_type; 
        $activity_month = FSInput::get('activity_month', 0);
        $activity_year = FSInput::get('activity_year', 0);
        if($activity_month && $activity_year)
            $where .= ' AND ap.activity_month = '.$activity_month.' AND ap.activity_year = '.$activity_year; 
        $keyword = FSInput::get('keyword', '');
        if($keyword != '')
            $where .= ' AND ap.outcome_code LIKE \'%'.$keyword.'%\'';
        $my_plan = FSInput::get('my_plan', 0);    
        if($user->userID && $my_plan)
            $where .= ' AND ra.member_code = \''.$user->userInfo->code.'\'';
        return $where;
    }
    
    function getList(){
        global $db;
        $query = '  SELECT ra.*, ap.outcome_code AS outcome_code, ap.activity_code AS activity_code, mb.agencies_title
                    FROM fs_report_activity AS ra
                        LEFT JOIN fs_activity_plan AS ap ON ra.activity_plan_id = ap.id
                        LEFT JOIN fs_members AS mb ON mb.code = ra.member_code
                    WHERE '.$this->getWhere().'
                    ORDER BY ra.id DESC'; 
        $result = $db->query_limit($query, $this->limit, $this->page);
        return $db->getObjectList();
    }
    
    /**
     * Lấy tổng số tin
     * @return Int
     */
    function getTotal(){
        global $db;
        $query = '  SELECT count(ra.id)
                    FROM fs_report_activity AS ra
                        LEFT JOIN fs_activity_plan AS ap ON ra.activity_plan_id = ap.id
                    WHERE '.$this->getWhere().'
                    ';
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    } 
    
    function getData(){
        global $db;
        $id = FSInput::get('id', 0);
        $query = '  SELECT ra.*, me.fullname AS fullname
                    FROM fs_report_activity AS ra
                        LEFT JOIN fs_members AS me ON me.code = ra.member_code
                    WHERE ra.id = '.$id.'
                    LIMIT 1';
        $result = $db->query($query);
        return $db->getObject();
    }
    
    function getActivityOutcome($activity_id, $member_code){
        global $db;
        $query = '  SELECT *
                    FROM fs_report_activity_outcome
                    WHERE activity_id=\''.$activity_id.'\' AND member_code=\''.$member_code.'\'';
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function do_update(){
        global $db, $arrActivityKeyTime, $user;
        $data_id =  FSInput::get('data_id', 0);
        foreach($arrActivityKeyTime as $key){
            if(isset($_REQUEST[$key]))
                $data = trim($_REQUEST[$key]);
            else
                continue;
            if($data != ''){
                $start_date = FSInput::get('start_date');
                $row = array();
                $row['member_code'] = $user->userInfo->code;
                $row['activity_id'] = $data_id;
                $row['activity_type'] = $key;
                $row['outcome'] = $data;
                $quarter = getQuarterText($start_date, $key);
                $row['quarter'] = $quarter['quarter'];
                $row['year'] = $quarter['year'];
                $row['created_time'] = date('Y-m-d H:i:s');
                $this->_add($row, 'fs_report_activity_outcome');
            }
        }
        $status = FSInput::get('status', 1);
        $this->_update(array('status'=>$status), 'fs_report_activity', 'id = '.$data_id.' AND member_code =\''.$user->userInfo->code.'\'');
    }
    
    function getBusinessReport(){
        $id = FSInput::get('id', 0);
        $key = FSInput::get('key', 'after');
        global $db;
        $query = '  SELECT ab.*, me.agencies_title AS agencies_title
                    FROM fs_report_activity_business AS ab
                        INNER JOIN fs_members AS me ON me.code = ab.member_code
                    WHERE ab.activity_id=\''.$id.'\' AND ab.activity_type =\''.$key.'\''; 
        $result = $db->query($query);
        return $db->getObjectList();
    }
    
    function add_risk(){
        $row = array();
        $data_id = FSInput::get('data_id', 0);
        if($data_id){
            $row['temp'] = '';
            $row['activity_id'] = $data_id;
        }else{
            $row['temp'] = session_id();
            $row['activity_id'] = 0;
        }
        $row['type'] = FSInput::get('type', 1, 'int');
        $row['risk'] = FSInput::get('risk', '');
        $row['solution'] = FSInput::get('solution', '');
        $row['created_time'] = date('Y-m-d H:i:s');
        return $this->_add($row, 'fs_report_activity_risks');
    }
} 