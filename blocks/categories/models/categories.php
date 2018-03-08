<?php
class CategoriesBModelsCategories{
    var $category_id;
    var $order_by;
    var $limit;
    function __construct(){
        $fstable = FSFactory::getClass('fstable');
		$this->table_name  = $fstable->_('fs_products', MULTI_LANGUAGE);
		$this->table_category  = $fstable->_('fs_products_categories', MULTI_LANGUAGE);
    }
    
    /**
     * Sắp xếp theo
     * 
     * @return string
     */ 
    function getOrdering(){
        $where = '';
        switch($this->order_by){
            case 'new':
                $where .= ' id DESC';
                break;
            case 'increase':
                $where .= ' price_old ASC';
                break;
            case 'discounts':
                $where .= ' price_old DESC';
                break;
            default:
                $where .= ' ordering DESC';
        }
        return $where;
    }
    
    /**
     * Lấy danh sách sản phẩm
     * 
     * @return object list
     */ 
    function getProducts($id = 0){
        global $db;
        $query = '  SELECT id, name, summary, price, price_old, discount, discount_unit, image, alias, category_alias, hot, new, origin_title, status
                    FROM '.$this->table_name.' 
                    WHERE published = 1 AND category_id_wrapper LIKE \'%,'.$id.',%\'
                    ORDER BY '.$this->getOrdering().'
                    LIMIT '.$this->limit;
        $sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
    }
    
    /**
     * Lấy danh mục
     * @return Object list
     */ 
    public function getCategories($catId = 0){
        global $db;
        $query = '  SELECT id, name, alias, level, parent_id, alias, list_parents
                    FROM '.$this->table_category.'
                    WHERE published = 1 AND show_in_homepage = 1 AND parent_id = 0
                    ORDER BY ordering ASC';
        $result = $db->query($query);
        return $db->getObjectList();
    }
}