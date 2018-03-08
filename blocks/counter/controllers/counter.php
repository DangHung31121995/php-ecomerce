<?php
require(PATH_BASE.'blocks/counter/models/counter.php');
class CounterBControllersCounter{
    function display($parameters, $title, $blockId = 0){
        $style = $parameters->getParams('style');
        $style = $style?$style:'default';
        $model = new CounterBModelsCounter();
        $visited = $model->getTotalVisited();
        $online = $model->getCountOnline();
        require(PATH_BASE . 'blocks/counter/views/' . $style . '.php');
    }    
}