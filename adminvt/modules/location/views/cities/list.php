<?php  
global $toolbar;
$toolbar->setTitle(FSText :: _('Cities') );
$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
//	FILTER
$filter_config  = array();
$fitler_config['search'] = 0; 
$fitler_config['filter_count'] = 0;																																																																																																																																																																																																																																																																																																																																																																																																																						
$list_config = array();
$list_config[] = array('title'=>'Tên','field'=>'name','ordering'=> 1, 'type'=>'edit_text','col_width' => '30%','arr_params'=>array('size'=> 40));
$list_config[] = array('title'=>'Miền','field'=>'region','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
$list_config[] = array('title'=>'Edit','type'=>'edit');
$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>