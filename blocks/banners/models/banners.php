<?php
/**
 * @author vangiangfly
 * @category Contronller
 */ 
class BannersBModelsBanners
{
    function __construct()
    {
    }
    function getList($category_id)
    {
        $where = '';
        if ($category_id)
            $where .= ' AND category_id IN (' . $category_id . ') ';
        $query = "  SELECT name, id, category_id, type, image, flash, content, link, width, height
                    FROM fs_banners AS a
                    WHERE published = 1
                    " . $where . " ";
        global $db;
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }
}
?>