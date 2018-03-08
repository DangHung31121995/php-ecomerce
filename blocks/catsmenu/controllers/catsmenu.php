<?php
require(PATH_BASE.'blocks/catsmenu/models/catsmenu.php');
class CatsmenuBControllersCatsmenu{
    function display($parameters, $title, $blockId = 0){
        $style = $parameters->getParams('style');
        $style = $style ? $style : 'default';
        $module = $parameters->getParams('module');
        $module = $module ? $module : 'products';
        if(!$title)
            $title = $parameters->getParams('title');
        $title = $title ? $title : 'Danh sách danh mục';
        $model = new CatmenuBModelsCatmenu($module);
        $listCatmenu = $model->getListCatmenu(); 
        $cat = $model->getCategory('fs_'.$module.'_categories');
        $currentCat = 0;
        if($cat)
            $currentCat = $cat->id;
        
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
            
        require(PATH_BASE.'blocks/catsmenu/views/'.$module.'-'.$style.'.php');
    }
}