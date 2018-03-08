<?php
require(PATH_BASE.'blocks/navigation/models/navigation.php');
class NavigationBControllersNavigation
{
    function display($parameters, $title, $blockId = 0)
    {
        $group = $parameters->getParams('group');
        $style = $parameters->getParams('style');
        $style = $style?$style:'default';
        $class = $parameters->getParams('class');
        $class = $class?$class:'';
        if (!$group)
            return;
        $model = new NavigationBModelsNavigation();
        $list = $model->getList($group);
        if (!$list)
            return;
        include 'blocks/navigation/views/' . $style . '.php';
    }
}
?>