<?php 
$params = array(
	'suffix' => array(
				'name' => 'Hậu tố',
				'type' => 'text',
				'default' => '_news'
				),
    'order_by'=> array(
				'name'=>'Sắp xếp theo',
				'type' => 'select',
				'value' => array('default' => 'Default', 'new' =>'Tin mới')
		),
    'style' => array(
    	'name'=>'Style',
    	'type' => 'select',
    	'value' => array(
            'default' => 'Default',
            'list' =>'List',
            'grid' => 'Grid',
            /* 'slideshow' => 'Slideshow',*/
            'featured' => 'Featured'
        )
	),
	'category_id' => array(
		'name'  =>'Danh mục',
		'type'  => 'select',
		'value' => getNewsCategories(),
        'attr' => array('multiple' => 'multiple')
	),
    'limit' =>array(
    	'name' => 'Limit',
    	'type' => 'text',
    	'default' => '4'
    ),
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
		'name' => 'Nới cách',
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
function getNewsCategories(){
	global $db;
	$query = " SELECT name, id, parent_id FROM fs_news_categories ORDER BY ordering";
	$db->query($query);
	$list = $db->getObjectList();
	$arr_group = array('0'=>'Chọn danh mục');
	if(!$list)
	     return;
	$tree  = FSFactory::getClass('tree','tree/');
	$list = $tree -> indentRows2($list);
    foreach($list as $item){
    	$arr_group[$item -> id] = $item -> treename;
    }
	return $arr_group;
}
?>