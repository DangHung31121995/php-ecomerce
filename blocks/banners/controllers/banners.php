<?php
/**
 * @author vangiangfly
 * @category Contronller
 */ 
require_once(PATH_BASE.'blocks/banners/models/banners.php');
class BannersBControllersBanners
{
    function __construct(){
        
    }
    
    function display($parameters, $title, $blockId = 0){
        $style = $parameters->getParams('style');
        $style = $style ? $style : 'default';
        
        $class = $parameters->getParams('class');
        
        $suffix = $parameters->getParams('suffix');
        
        $category_id = $parameters->getParams('category_id');
        
        $width = (int)$parameters->getParams('width' );
        $float = $parameters->getParams('float' );
        $margin_pos = $parameters->getParams('margin_pos' );
		$margin_value = (int)$parameters->getParams('margin_value' );
        
        $cssText = '';
        $cssText .= 'float:'.$float.';';
        if($margin_value)
            $cssText .= $margin_pos.':'.$margin_value.'px;';
        if($width)
            $cssText .= 'width:'.$width.'px;';
        
        $model = new BannersBModelsBanners();
        $list = $model->getList($category_id);
        if (!$list)
            return true;
        require(PATH_BASE.'blocks/banners/views/banners/' . $style . '.php');
    }
}
?>