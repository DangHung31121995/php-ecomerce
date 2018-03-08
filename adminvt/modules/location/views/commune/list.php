<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Quận/huyện') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
		
//	FILTER	
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	
	$fitler_config['filter_count'] = 3;

	$filter_countries = array();
	$filter_countries['title'] = FSText::_('Country'); 
	$filter_countries['list'] = @$countries; 
	$filter_countries['field'] = 'name'; 

	$filter_cities = array();
	$filter_cities['title'] = FSText::_('City'); 
	$filter_cities['list'] = @$cities; 
	$filter_cities['field'] = 'name'; 
	
	$filter_districts = array();
	$filter_districts['title'] = FSText::_('District'); 
	$filter_districts['list'] = @$districts; 
	$filter_districts['field'] = 'name'; 
	
	$fitler_config['filter'][] = $filter_countries;
	$fitler_config['filter'][] = @$filter_cities;
	$fitler_config['filter'][] = @$filter_districts;																																																																																																																																																																																																																																																																																																																																																																																																																						

//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'edit_text','col_width' => '30%','arr_params'=>array('size'=> 30,'row'=> 1));
	$list_config[] = array('title'=>'Country','field'=>'country_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'City','field'=>'city_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'District','field'=>'district_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
		