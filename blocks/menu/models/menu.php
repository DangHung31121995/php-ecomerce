<?php
class MenuBModelsMenu
{
    function getList($group)
    {
        $fstable = FSFactory::getClass('fstable');
		$this->table_name  = $fstable->_('fs_menus_items', 1); 
        global $db;
        if (!$group)
            return;
        $sql = 'SELECT id, link, name, level, parent_id
				FROM '.$this->table_name.'
				WHERE published  = 1 AND group_id = '.$group.' 
				ORDER BY ordering';
        $db->query($sql);
        $result = $db->getObjectList();
        $tree_class  = FSFactory::getClass('tree','tree/');
		return $list = $tree_class -> indentRows($result);
    }
}
?>