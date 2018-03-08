<?php
class CatmenuBModelsCatmenu{
    var $table;
    function __construct($module){
        $fs_table = FSFactory::getClass('fstable');
        $this->table = $fs_table->_('fs_'.$module.'_categories', MULTI_LANGUAGE);
    }
    
    /**
     * Lấy danh mục
     * @return Object list
     */ 
    public function getListCatmenu(){
        global $db;
        $query = '  SELECT id, name, icon, alias, level, parent_id, alias, list_parents, total_products
                    FROM '.$this->table.'
                    WHERE published = 1 AND show_in_homepage = 1
                    ORDER BY ordering ASC';
        $result = $db->query($query);
        $categories = $db->getObjectList();
        $tree_class  = FSFactory::getClass('tree','tree/');
		return $list = $tree_class -> indentRows($categories, 3);
    }
    
    /**
     * Lấy tổng số sản phẩm
     * @return Int
     */
    function getTotalProduct($sqlWhere = ''){
        global $db;
        $query = '  SELECT count(id)
                    FROM fs_products
                    WHERE published = 1 '.$sqlWhere;
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    }
    
    /**
     * Lấy danh mục
     * @return Object
     */
    function getCategory($table_category)
	{
        global $db;
		$code = FSInput::get('ccode');
        $fs_table = FSFactory::getClass('fstable');
		if($code){
			$where = ' AND alias = \''.$code.'\'';
		} else {
			$id = FSInput::get('id',0,'int');
			$where = ' AND id = '.$id.' ';
		}
        $query = "  SELECT id
                    FROM ".$this->table." 
                    WHERE published = 1 ".$where;
		$sql = $db->query($query);
		$result = $db->getObject();
		return $result;
	} 
}
?>