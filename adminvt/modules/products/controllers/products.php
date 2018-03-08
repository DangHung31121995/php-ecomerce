<?php
class ProductsControllersProducts extends Controllers
{
    function __construct()
    {
        $this->view = 'products';
        parent::__construct();
    }
    function display()
    {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;
        $model = $this->model;
        $list = $model->get_data();
        $categories = $model->get_categories_tree();
        $pagination = $model->getPagination();
        $status = $model->getStatus();
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }
    
    function add(){
        /*$colors = $model->getColors();
        $datColor = array(0);
        $sizes = $model->getSizes();
        $datSize = array(0);
        $origins = $model->getOrigins();
        $datOrigin = array(0);*/
        $cid = FSInput::get('cid');
        if($cid){
            $category= $this->model->get_record_by_id($cid,'fs_products_categories'); 
			$tablename = $category->tablename;
			$relate_categories = $this->model->getRelatedCategories($category->tablename);
            $extend_fields = $this->model->getExtendFields($category->tablename);
			$data_foreign = $this->model -> get_data_foreign($extend_fields);
			$maxOrdering = $this->model->getMaxOrdering();
            $categories = $this->model->get_categories_tree();
            $maxOrdering = $this->model->getMaxOrdering();
            $uploadConfig = base64_encode('add|'.session_id());
            include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
        }else{
			$categories = $this->model->get_categories_tree();
			include 'modules/'.$this->module.'/views/'.$this -> view.'/select_categories.php';
		}
    }
    
    function edit(){
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $data = $this->model->get_record_by_id($id);
        $categories = $this->model->get_categories_tree();
        $images = $this->model->get_product_images($data->id);
        $category= $this->model->get_record_by_id($data->category_id, 'fs_products_categories');
        $tablename = $data->tablename?$data->tablename:$category->tablename;
		$extend_fields = $this->model->getExtendFields($tablename); 
		$relate_categories = $this->model->getRelatedCategories($tablename);
        $data_ext = $this->model->getProductExt($data->tablename, $data->id);
		$data_foreign = $this->model -> get_data_foreign($extend_fields);
        /*$colors = $model->getColors();
        $datColor = explode(',', $data->color);
        $sizes = $model->getSizes();
        $datSize = explode(',', $data->size);
        $origins = $model->getOrigins();
        $datOrigin = explode(',', $data->origin);*/
        $uploadConfig = base64_encode('edit|'.$id);
        $this->params_form = array('ext_id'=>@$data_ext -> id) ;
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }
    
    /**
     * Upload nhiều ảnh cho sản phẩm
     */ 
    function uploadProductImages(){
        $this->model->uploadProductImages();
    }
    
    /**
     * Lấy danh sách ảnh của sản phẩm
     */
    function getProductImages(){
        $listImages = $this->model->getProductImages();
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail_images.php';
    } 
    
    /**
     * Xóa ảnh
     */ 
    function deleteOtherImage(){
        $this->model->deleteOtherImage();
    }
    
    /**
     * Sắp xếp ảnh
     */
    function sortProductImages(){
        $this->model->sortProductImages();
    } 
    
    function export(){
        //http://www.phpkode.com/source/p/phpexcel/Tests/05featuredemo.inc.php
        $arrStatus = array(0=>'Hết hàng', 1=>'Còn hàng');
        require_once(PATH_BASE.'libraries/PHPExcel/PHPExcel.php');
        $sharedStyle1 = new PHPExcel_Style();
        $sharedStyle1->applyFromArray(
    	array('fill' 	=> array(
    								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
    								'color'		=> array('argb' => 'FFFFFF00')
    							)
    		 ));
        $products = $this->model->getProductsExport(); 
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("www.finalstyle.com")
        							 ->setLastModifiedBy("www.finalstyle.com")
        							 ->setTitle("Office 2007 XLSX Test Document")
        							 ->setSubject("Office 2007 XLSX Test Document")
        							 ->setDescription("Danh sach san pham")
        							 ->setKeywords("office 2007 openxml php")
        							 ->setCategory("Danh sach san pham");
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'STT')
                    ->setCellValue('B1', 'ID')
                    ->setCellValue('C1', 'Mã')
                    ->setCellValue('D1', 'Tên sản phẩm')
                    ->setCellValue('E1', 'Giá (đ)')
                    ->setCellValue('F1', 'Giảm (đ)')
                    ->setCellValue('G1', 'Tình trạng')
                    ->setCellValue('H1', 'Danh mục');
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->setTitle(date('d-m-Y'));
        // Bind data
        $tmp = 1;
        foreach($products as $item){
            $tmp++;
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$tmp, $item->ordering)
                        ->setCellValue('B'.$tmp, $item->id)
                        ->setCellValue('C'.$tmp, $item->code)
                        ->setCellValue('D'.$tmp, $item->name)
                        ->setCellValue('E'.$tmp, $item->price_old)
                        ->setCellValue('F'.$tmp, $item->discount)
                        ->setCellValue('G'.$tmp, $arrStatus[$item->status])
                        ->setCellValue('H'.$tmp, $item->category_name);
            if(!$item->status) 
                $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, 'A'.$tmp.':H'.$tmp);
        }
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->getActiveSheet()->getStyle('E2:E'.$tmp)->getNumberFormat()->setFormatCode("#,##0 _€");
        $objPHPExcel->getActiveSheet()->getStyle('F2:F'.$tmp)->getNumberFormat()->setFormatCode("#,##0 _€");
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Danh-sach-san-pham-'.date('d-m-Y').'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        ob_end_flush();
        exit;
    }
}
?>