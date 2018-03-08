<?php
/**
 * @author vangiangfly
 * @category Contronller
 */ 
require_once(PATH_BASE.'blocks/news/models/news.php');
class NewsBControllersNews{
    function display($parameters, $title, $blockId = 0){
        $style = $parameters->getParams('style');
        $style = $style ? $style : 'default';
        
        $model = new NewsBModelsNews();
        
        $suffix = $parameters->getParams('suffix');
        
        $where = $parameters->getParams('where');
        $model->where = $where ? $where : 'default';
        
        $order_by = $parameters->getParams('order_by');
        $model->order_by = $order_by ? $order_by : 'default';
        
        $limit = $parameters->getParams('limit');
        $model->limit = $limit ? $limit : 6;
        
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
        $categories = $parameters->getParams('category_id'); 
        if($categories){
            $cats = $model->getCategories($categories);
            $i = 0;
            foreach($cats as $item){
                $cats[$i]->news = $model->getNews($item->id);
                $i++;
            }
            $list = $cats[0]->news;
        }else{
            $list = $model->getNews();
        }
        require(PATH_BASE.'blocks/news/views/'.$style.'.php');
    }
}