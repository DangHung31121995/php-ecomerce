<?php
class ProductsBModelsProducts{
    var $where;
    var $order_by;
    var $limit;
    function __construct(){
        $fstable = FSFactory::getClass('fstable');
		$this->table_name  = $fstable->_('fs_products', MULTI_LANGUAGE);
		$this->table_category  = $fstable->_('fs_products_categories', MULTI_LANGUAGE);
    }
    
    /**
     * Điều kiện lấy sản phẩm
     * 
     * @return string
     */ 
    function getWhere(){
        $where = 'published = 1 ';
        switch($this->where){
            case 'sellers':
                $where .= ' AND hot = 1';
                break;
            case 'sales':
                $where .= ' AND discount > 0';
                break;
            default:
                $where .= '';
        }
        return $where;
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
    
    function getProducts(){
        global $db;
        $query = '  SELECT id, name, summary, price, price_old, discount, discount_unit, image, alias, category_alias, hot, new, status
                    FROM '.$this->table_name.' 
                    WHERE '.$this->getWhere().'
                    ORDER BY '.$this->getOrdering().'
                    LIMIT '.$this->limit;
        $sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
    }
}