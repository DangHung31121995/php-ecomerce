<?php 
$params = array (
	'suffix' => array(
    	'name' => 'Hậu tố',
    	'type' => 'text',
    	'default' => '_banner'
	),
	'category_id' => array(
		'name'=>'Nhóm banner',
		'type' => 'select',
		'value' => getBannersCategory(),
		'attr' => array('multiple' => 'multiple'),
	),
    'style' => array(
    	'name'=>'Style',
    	'type' => 'select',
    	'value' => array(
            'logo' => 'Logo',
            'default' => 'Default', 
            'sidebar' => 'Sidebar', 
            'slideshow' =>'Slideshow'
        )
	),
    /* 'class' => array(
    	'name'=>'Class',
    	'type' => 'text',
    	'default'=>'span12'
	),*/
    'width' => array (
		'name' => 'Rộng (px)',
		'type' => 'text',
		'default'=>'0'
	),
    'float' => array (
		'name' => 'Canh (align)',
		'type' => 'select',
		'value'=>array(
            'none'=>'Không',
            'left'=>'Trái',
            'right'=>'Phải'
        )
	),
    'margin_pos' => array (
		'name' => 'Nơi cách',
		'type' => 'select',
		'value'=>array(
            '_'=>'Không',
            'margin-top'=>'Trên',
            'margin-left'=>'Trái',
            'margin-right'=>'Phải',
            'margin-bottom'=>'Dưới'
        )
	),
    'margin_value' => array (
		'name' => 'Khoảng cách (px)' ,
		'type' => 'text',
		'default' => '0'
	)
);
function getBannersCategory(){
	global $db;
	$query = "  SELECT name, id 
				FROM fs_banners_categories";
	$sql = $db->query($query);
	$result = $db->getObjectList();
	if(!$result)
	     return;
	$arr_group = array();
    foreach($result as $item){
    	$arr_group[$item -> id] = $item -> name;
    }
	return $arr_group;
}
?>