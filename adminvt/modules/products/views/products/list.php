<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Products') );
$toolbar->addButton('duplicate',FSText :: _('Duplicate'),FSText :: _('You must select at least one record'),'duplicate.png');
$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
$toolbar->addButton('export',FSText :: _('Export excel'),FSText :: _(''),'excel.png'); 
$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
//	FILTER
$filter_config  = array();
$fitler_config['search'] = 1; 
$fitler_config['filter_count'] = 2;
$filter_categories = array();
$filter_categories['title'] = FSText::_('Danh mục'); 
$filter_categories['list'] = @$categories; 
$filter_categories['field'] = 'treename'; 
$fitler_config['filter'][] = $filter_categories;
$filter_status = array();
$filter_status['title'] = FSText::_('Tình trạng'); 
$filter_status['list'] = @$status; 
$filter_status['field'] = 'title'; 
$fitler_config['filter'][] = $filter_status;																																																																																																																																																																																																																																																																																																																																																																																																																						
//	CONFIG	
$list_config = array();
$list_config[] = array('title'=>'Tên','field'=>'name','ordering'=> 1, 'type'=>'edit_text','col_width' => '30%','arr_params'=>array('size'=> 40));
$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','no_col'=>1,'arr_params'=>array('search'=>'/original/','replace'=>'/tiny/'));
//$list_config[] = array('title'=>'Giá','type'=>'label');
//$list_config[] = array('title'=>'Giá','field'=>'price_old','no_col'=>3, 'type'=>'edit_text','display_label'=>1,'arr_params'=>array('size'=>6));
//$list_config[] = array('title'=>'Giảm giá','field'=>'discount','no_col'=>3, 'type'=>'edit_text','display_label'=>1,'arr_params'=>array('size'=>6));
//$list_config[] = array('title'=>'Loại giảm giá','field'=>'discount_unit','no_col'=>3, 'type'=>'edit_selectbox','display_label'=>1,'arr_params'=>array('arry_select'=>array('percent'=>'Phần trăm','price'=>'Giá trị')));
$list_config[] = array('title'=>'Category','field'=>'category_name','ordering'=> 1, 'type'=>'text','col_width' => '20%');
$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
$list_config[] = array('title'=>'Edit','type'=>'edit');
$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>