<?php
class NewsBModelsNews{
    var $where;
    var $order_by;
    var $limit;
    var $category_id;
    function __construct(){
        $this->category_id = 0;
        $fstable = FSFactory::getClass('fstable');
		$this->table_name  = $fstable->_('fs_news', MULTI_LANGUAGE);
		$this->table_category  = $fstable->_('fs_news_categories', MULTI_LANGUAGE);
    }
    
    /**
     * Điều kiện lấy sản phẩm
     * 
     * @return string
     */ 
    function getWhere(){
        $where = 'published = 1 ';
        /* switch($this->where){
            case 'sellers':
                $where .= ' AND hot = 1';
                break;
            case 'sales':
                $where .= ' AND discount > 0';
                break;
            default:
                $where .= '';
        }
        if($this->category_id)
            $where .= ' AND category_id_wrapper LIKE \'%,'.$this->category_id.',%\'';*/
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
            default:
                $where .= ' ordering DESC';
        }
        return $where;
    }
    
    function getNews($category_id = 0){
        global $db;
        $where = $this->getWhere();
        if($category_id)
            $where .= ' AND category_id_wrapper LIKE \'%,'.$category_id.',%\'';
        $query = '  SELECT id, title, image, summary, alias, created_time, category_id, category_name, category_alias
                    FROM '.$this->table_name.' 
                    WHERE '.$where.SQL_PUBLISH.'
                    ORDER BY '.$this->getOrdering().'
                    LIMIT '.$this->limit;
        $sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
    }
    
    function getCategories($categories = 0){ 
        global $db;
        $query = '  SELECT id, name, alias, alias_wrapper, parent_id, list_parents
                    FROM '.$this->table_category.' 
                    WHERE id IN ('.$categories.')
                    ORDER BY ordering ASC';
        $sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
    }
}