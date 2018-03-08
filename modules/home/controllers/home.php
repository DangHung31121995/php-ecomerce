<?php
/**
 * @author vangiangfly
 * @copyright 2013
 */
class HomeControllersHome extends FSControllers{
    function __construct(){
        parent::__construct();
    }
    
    function display(){
        $quarter = getPrevCurrentQuarter(); 
        $arrQuarter = explode('/', $quarter['text']);
        $arrKey = array('new_markets', 'new_clients', 'export_sales');
        /* Dữ liệu theo vùng */
        $arrRegion = array();
        for($i = 1; $i <= 3; $i++)
            foreach($arrKey as $key)
                $arrRegion[$i][$key] = $this->model->get_business_results_by_region($i, $arrQuarter[0], $arrQuarter[1], $key);
        /* Dữ liệu theo vùng */
        $keyIndustries = array(4, 1, 2);
        $arrIndustries = array();
        foreach($keyIndustries as $ind)
            foreach($arrKey as $key)
                $arrIndustries[$ind][$key] = $this->model->get_business_results_by_industry($ind, $arrQuarter[0], $arrQuarter[1], $key);    
                
        require(PATH_BASE.'modules/'.$this->module.'/views/default.php');
    }
    
    function get_statistics_cities(){
        global $arrRegions;
        $tmpRegions = $arrRegions;
        unset($tmpRegions[0]);
        $json = array(
            'categories' => array(),
            'series' => array()
        );
        $arrQuarter = $this->get_quarter_statistics();
        foreach($arrQuarter as $quarter){
            $json['categories'][] = FSText::_('Quý').' '.$quarter['text'];
        }
        foreach($tmpRegions as $key=>$val){
            $data = array();
            foreach($arrQuarter as $quarter){
                $data[] = $this->model->get_statistics_cities_region($key, $quarter['quarter'], $quarter['year']);
            }
            $json['series'][] = array(
                'name' => $val,
                'data' => $data
            );
        }
        echo json_encode($json);
    }
    
    function get_statistics_business(){
        global $arrRegions;
        $tmpRegions = $arrRegions;
        unset($tmpRegions[0]);
        $json = array(
            'categories' => array(),
            'series' => array()
        );
        $arrQuarter = $this->get_quarter_statistics(); 
        foreach($arrQuarter as $quarter){
            $json['categories'][] = FSText::_('Quý').' '.$quarter['text'];
        }
        foreach($tmpRegions as $key=>$val){
            $data = array();
            foreach($arrQuarter as $quarter){
                $data[] = $this->model->get_statistics_business_region($key, $quarter['quarter'], $quarter['year']);
            }
            $json['series'][] = array(
                'name' => $val,
                'data' => $data
            );
        }
        echo json_encode($json);
    }
    
    function get_quarter_statistics(){
        $arrQuarter = array();
        
        $cMonth = date('n');
        $cYear = date('Y');
        $cQuarter = ceil($cMonth / 3);
        $cYear = date('Y');
        for($i = 0; $i <4; $i++){
            $quarter = $cQuarter - $i;
            $year = intval($cYear);
            if($quarter == 0){
                $quarter = 4;
                $year--;
            }
            if($year < 2015 || $quarter <= 0)
                break;
            $arrQuarter[] = array(
                'quarter' => $quarter,
                'year' => $year,
                'text' => $quarter.'/'.$year
            );
        } 
        $reQuarter = array();
        $total = count($arrQuarter) - 1;
        for($i = $total; $i >= 0; $i--){
            $reQuarter[] = $arrQuarter[$i];
        } 
        return $reQuarter;
    }
} 