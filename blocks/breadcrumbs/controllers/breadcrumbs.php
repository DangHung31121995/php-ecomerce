<?php
/**
 * @author vangiangfly
 * @category Controller
 */ 
class BreadcrumbsBControllersBreadcrumbs
{
    function __construct()
    {
    }
    function display($parameters, $title, $blockId = 0)
    {
        global $tmpl;
        $style = $parameters->getParams('style');
        $style = $style ? $style : 'default';
        $breadcrumbs = $tmpl->get_variables('breadcrumbs');
        require(PATH_BASE.'blocks/breadcrumbs/views/'.$style.'.php');
    }
}
?>