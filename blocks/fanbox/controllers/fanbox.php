<?php
class FanboxBControllersFanbox{
    function display($parameters, $title, $blockId = 0){
        $style = $parameters->getParams('style');
        $style = $style?$style:'default';
        $link = $parameters->getParams('link');
        $link = $link?$link:'https://www.facebook.com/www.cungcuoi.net';
        require(PATH_BASE . 'blocks/fanbox/views/' . $style . '.php');
    }    
}