<?php
/**
 * @author vangiangfly
 * @category Contronller
 */ 
require_once(PATH_BASE.'blocks/products/models/products.php');
class ProductsBControllersProducts{
    function display($parameters, $title, $blockId = 0){
        $style = $parameters->getParams('style');
        $style = $style ? $style : 'default';
        
        $model = new ProductsBModelsProducts();
        
        $suffix = $parameters->getParams('suffix');
        
        $where = $parameters->getParams('where');
        $model->where = $where ? $where : 'default';
        
        $order_by = $parameters->getParams('order_by');
        $model->order_by = $order_by ? $order_by : 'default';
        
        $limit = $parameters->getParams('limit');
        $model->limit = $limit ? $limit : 6;
        
        $margin_pos = $parameters->getParams('margin_pos' );
		$margin_value = (int)$parameters->getParams('margin_value' );
        
        $cssText = '';
        if($margin_value)
            $cssText .= $margin_pos.':'.$margin_value.'px;';
            
        $list = $model->getProducts();
        
        /* if (!$list)
            return; */
        require(PATH_BASE.'blocks/products/views/'.$style.'.php');
    }
}