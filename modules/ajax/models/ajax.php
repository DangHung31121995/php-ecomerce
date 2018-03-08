<?php
class AjaxModelsAjax extends FSModels{
    function __construct(){
        parent::__construct();
    }
    
    function registerNewsletter(){
        $email = FSInput::get('email');
        $created_time = date("Y-m-d H:i:s");
        $sql = "INSERT INTO fs_newsletter (`email`, `created_time`)
                VALUES ('$email', '$created_time')";
        global $db;
        $db->query($sql);
        $id = $db->insert();
        return $id;
    }
    
    function checkEmailExists(){
        global $db;
        $email = FSInput::get('email');
        $query = '  SELECT count(id)
                    FROM fs_newsletter
                    WHERE email = \''.$email.'\''; echo $query;die;
        $result = $db->query($query);
        $total = $db->getResult();
		return $total;
    }
    
    function getRelatedNews(){
        global $db;
        $sqlWhere = '';
        $keyword = FSInput::get('keyword');
        if(trim($keyword) == '')
            return false;
        $keyword = mb_strtolower($keyword, "UTF-8");
        $keyword = str_replace("\'", "'", $keyword);
		$keyword = str_replace("'", "''", $keyword);
        $arrKey = explode(',', $keyword);
        foreach($arrKey as $key){
            $sqlWhere .= ' AND title LIKE \'%'.$key .'%\'';
        }
        $query = '  SELECT id, title, image, summary, alias, created_time, category_id, category_name, category_alias
                    FROM fs_news
                    WHERE published = 1 '.$sqlWhere.'
                    ORDER BY ordering DESC';
        $result = $db->query_limit($query, 10, 1); 
        return $db->getObjectList();
    }
    
    function getDiscountCode($code = ''){
        global $db;
        $query = '  SELECT *
                    FROM fs_products_discount
                    WHERE published = 1 AND code = \''.$code.'\'';
        $result = $db->query($query);
        return $db->getObject();
    }
    
    function addCommentProduct(){
        $name = FSInput::get('txtName', '');
        $email = FSInput::get('txtMail', '');
        $product_id = FSInput::get('product_id', 0);
        $comment = FSInput::get('txtCom', '');
        $created_time = date("Y-m-d H:i:s");
        $published = 0;
        $sql = "INSERT INTO fs_products_comments (`product_id`, `name`, `email`, `created_time`, `comment`, `published`)
                VALUES ('$product_id', '$name', '$email', '$created_time', '$comment', '$published')";
        global $db;
        $db->query($sql);
        $id = $db->insert();
        return $id;
    }
    
    function commentNews(){
        $name = FSInput::get('txtName', '');
        $email = FSInput::get('txtMail', '');
        $record_id = FSInput::get('record_id', 0);
        $comment = FSInput::get('txtCom', '');
        $created_time = date("Y-m-d H:i:s");
        $published = 0;
        $sql = "INSERT INTO fs_news_comments (`record_id`, `name`, `email`, `created_time`, `comment`, `published`)
                VALUES ('$record_id', '$name', '$email', '$created_time', '$comment', '$published')";
        global $db;
        $db->query($sql);
        $id = $db->insert();
        return $id;
    }
}