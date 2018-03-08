<?php
class NavigationBModelsNavigation{
    function __construct(){
        $fstable = FSFactory::getClass('fstable');
		$this->table_name  = $fstable->_('fs_menus_items', 1); 
    }
    
    function getList($group)
    {
        global $db;
        if (!$group)
            return;
        $sql = 'SELECT id, link, name, level, parent_id, is_html, html
				FROM '.$this->table_name.'
				WHERE published  = 1 AND parent_id = 0 AND group_id = '.$group.' 
				ORDER BY ordering';
        $db->query($sql);
        $list = $db->getObjectList(); 
        $i = 0;
        if($list)
            foreach($list as $item){
                $list[$i]->children = $this->getMenuChild($item->id);
                $i++;
            }
		return $list;
    }
    
    function getMenuChild($parent_id = 0){
        global $db;
        $sql = 'SELECT id, link, name, level, parent_id
				FROM '.$this->table_name.'
				WHERE published  = 1 AND parent_id = '.$parent_id.'
				ORDER BY ordering';
        $db->query($sql);
        return $db->getObjectList();
    }
}
?>