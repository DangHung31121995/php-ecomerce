<?php
require(PATH_BASE.'blocks/menu/models/menu.php');
class MenuBControllersMenu{
    function display($parameters, $title, $blockId = 0){
        $group = $parameters->getParams('group');
        $style = $parameters->getParams('style');
        $style = $style?$style:'default';
        $class = $parameters->getParams('class');
        $class = $class?$class:'';
        if (!$group)
            return;
        $model = new MenuBModelsMenu();
        $list = $model->getList($group);
        if (!$list)
            return;
        $total = count($list);
        foreach($list as $item){
            $list[$item->id]->selected = '';
            $selected = $this->checkSelected($item);
            if($selected){
                $list[$item->id]->selected = 'selected';
                if($item->parent_id)
                    $list[$item->parent_id]->selected = 'selected';
            }
        }
        include 'blocks/menu/views/' . $style . '.php';
    }
    
    function checkSelected($item = ''){
        $return = 0;
        $cUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $link = FSRoute::_($item ->link.'&Itemid='.$item->id);
        if($cUrl == $link)
            $return = 1;
        return $return;
    }
}