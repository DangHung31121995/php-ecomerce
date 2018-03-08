<?php
class MemberBControllersMember{
    function display($parameters, $title, $blockId = 0){
        $style = $parameters->getParams('style');
        $style = $style?$style:'default';
        require(PATH_BASE . 'blocks/member/views/' . $style . '.php');
    }    
}