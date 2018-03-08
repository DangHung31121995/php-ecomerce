<?php
class SpaceBControllersSpace{
    function display($parameters, $title, $blockId = 0){
        $height = (int)$parameters->getParams('height');
        $cssText = '';
        if($height)
            $cssText .= 'height:'.$height.'px;';
        require(PATH_BASE.'blocks/space/views/default.php');
    }
}