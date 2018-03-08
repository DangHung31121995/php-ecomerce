<?php 
$params = array(
	'suffix' => array(
				'name' => 'Hậu tố',
				'type' => 'text',
				'default' => '_products'
				),
	'where' => array(
				'name'=>'Sản phẩm',
				'type' => 'select',
				'value' => array('default' => 'Default', 'sellers' =>'Bán chạy', 'sales' =>'Khuyến mại')
		),
    'order_by'=> array(
				'name'=>'Sắp xếp theo',
				'type' => 'select',
				'value' => array('default' => 'Default', 'new' =>'Sản phẩm mới', 'increase' =>'Giá tăng dần', 'discounts' =>'Giá giảm dần')
		),
    'style' => array(
    	'name'=>'Style',
    	'type' => 'select',
    	'value' => array(
            'default' => 'Default', 
            /* 'slideshow' =>'Slideshow', */
            'sidebar' =>'Sidebar'
        )
	),
    'limit' =>array(
				'name' => 'Limit',
				'type' => 'text',
				'default' => '6'
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
?>