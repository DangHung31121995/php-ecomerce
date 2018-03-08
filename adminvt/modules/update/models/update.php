<?php 
	class UpdateModelsUpdate extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 40;
			$this -> view = 'order';
			$this -> table_name = 'fs_order';
			parent::__construct();
		}
		
		function syn_products(){

			$arr_syn = array(
					'pro_id'	=>	'id',
				  'pro_supplier'=>'manufactory',
				  'pro_author'=>'author_id',
				  'pro_pagenumber'=>'pagenumber',
				  'pro_size'=>'size',
				  'pro_weight'=>'weight',
				  'pro_pricesale' =>'price_outsite',
//				  'pro_pricesale' =>'price_old',//
				   'pro_price' =>'price',
				  'pro_decreaseprice' =>'discount',
				  'pro_outsite' =>'outsite',
				  'pro_translator' =>'translator_id',
				  'pro_number' =>'pagenumber',
//				  'pro_new' =>'',//13
//				  'pro_hot' =>'',//16
				  'pro_active' =>'published',
				  'pro_picture' =>'image',
				  'pro_category' =>'category_id',
				  'pro_name' =>'name',
//				  'pro_date' =>'', time
				  'pro_teaser' =>'summary',
				  'pro_description' =>'description',
//				  'pro_stock' =>'',
//				  'admin_id' =>'',
				  'pro_hits' =>'hits',
				  'pro_keyword' =>'keyword',
				  'pro_newspaper' =>'newspaper',
				  'pro_trichdoan' =>'cited',
				  'pro_press' =>'press'
			);
			
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM products ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$row['price_old'] = $item_r -> pro_outsite;
			
				// new and hot
				$str_types = '';
				$k = 0;
				if($item_r -> pro_new){
					$str_types .= ','.'13'.',';
					$k ++;
				}
				if($item_r -> pro_hot){
					if(!$k)
						$str_types .= ','.'16'.',';
					else 	
						$str_types .= '16'.',';
				}
				$row['price_old'] = $item_r -> pro_outsite;
				$row['created_time'] = date('Y-m-d H:i:s',$item_r -> pro_date);
				$row['edited_time'] = date('Y-m-d H:i:s',$item_r -> pro_date);
				echo $this -> _add($row, 'fs_products_1',1);
			}
		}
		
		function syn_cats(){

			$arr_syn = array(
					'cat_id'  =>'id',
				  'cat_name' =>'name',
				  'cat_order' =>'ordering',
				  'cat_active' => 'published',
				  'cat_parent_id' => 'parent_id'
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM categories_multi WHERE cat_type = "product" ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$row['alias'] = $fsstring -> stringStandart($item_r -> cat_name);
				
				$row['created_time'] = $time;
				$row['updated_time'] = $time;
				echo $this -> _add($row, 'fs_products_categories',1);
			}
		}
		
		function update_home_cats(){

			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM categories_multi WHERE cat_type = "product" ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				$row['show_in_homepage'] = $item_r -> cat_show;
				echo $this -> _update($row, 'fs_products_categories',' id = '.$item_r -> cat_id,1);
			}
		}
		
		function syn_manufactories(){

			$arr_syn = array(
					'sup_id'  =>'id',
				  'sup_name' =>'name',
				  'sup_order' =>'ordering',
				  'sup_active' => 'published',
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM supplier ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$row['alias'] = $fsstring -> stringStandart($item_r -> sup_name);
				
				$row['created_time'] = $time;
				$row['edited_time'] = $time;
				echo $this -> _add($row, 'fs_manufactories',1);
				
				$row3['manufactory_alias'] = $row['alias'];
				$row3['manufactory_name'] = $row['name'];
				$this -> syn_product_vs_foreign($row['id'],'manufactory',$row3);
			}
		}
		function valid_manufactory(){
			$list = $this -> get_records('','fs_manufactories');
			foreach($list as $item){
				$row3 = array();
				$row3['manufactory_alias'] = $item -> alias;
				$row3['manufactory_name'] = $item -> name;
				$this -> syn_product_vs_foreign($item -> id,'manufactory',$row3);
			}
		}
		function syn_author(){

			$arr_syn = array(
					'aut_id'  =>'id',
				  'aut_name' =>'name',
				  'aut_order' =>'ordering',
				  'aut_active' => 'published',
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM author ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$row['alias'] = $fsstring -> stringStandart($row['name']);
				
				$row['created_time'] = $time;
				$row['edited_time'] = $time;
				echo $this -> _add($row, 'fs_products_authors',1);
				
				$row3['author_alias'] = $row['alias'];
				$row3['author_name'] = $row['name'];
				$this -> syn_product_vs_foreign($row['id'],'author_id',$row3);
			}
		}
		
		function syn_translator(){

			$arr_syn = array(
					'dic_id'  =>'id',
				  'dic_name' =>'name',
				  'dic_order' =>'ordering',
				  'dic_active' => 'published',
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM dichgia ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$row['alias'] = $fsstring -> stringStandart($row['name']);
				
				$row['created_time'] = $time;
				$row['edited_time'] = $time;
				echo $this -> _add($row, 'fs_products_translators',1);
				
				$row3['translator_alias'] = $row['alias'];
				$row3['translator_name'] = $row['name'];
				$this -> syn_product_vs_foreign($row['id'],'translator_id',$row3);
			}
		}
		function syn_pagenumber(){

			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM products ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				$row['pagenumber'] = $item_r -> pro_pagenumber;
				echo $this -> _update($row, 'fs_products',' `id` = '.$item_r->pro_id );
			}
		}
		function add_main_images(){
			$arr_img_paths = array(array('resized',126,197,'resized_not_crop'),array('large',240,350,'resized_not_crop'));
			$list = $this -> get_records('id >= 1700','fs_products','id,image,image_old','id ');
			$folder_image_begin = 'D:\xampp\htdocs\backup\nhasachhuongthuy\pictures_products\\';
			$day = '20';
			$month = '9';
			
			$folder_image_destination = 'D:\xampp\htdocs\svn\nhasachhuongthuy\code\images\products\2012\\'.$month.'\\'.$day.'\original\\';
			$fsFile = FSFactory::getClass('FsFiles','');
			for($i = 0; $i < count($list) ; $i ++){
				$item = $list[$i]; 
				$image = $item -> image_old;
				$fsFile -> create_folder($folder_image_destination);
				if(!$fsFile -> copy_file($folder_image_begin.$image,$folder_image_destination.$image))
					continue;
				foreach($arr_img_paths as $path){
					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination);
					$fsFile -> create_folder($path_resize);
					$method_resize = $path[3]?$path[3]:'resized_not_crop';
					if(!$fsFile ->$method_resize($folder_image_destination.$image, $path_resize.$image,$path[1], $path[2]))
						return false;
				}
				$row3['image'] = 'images/products/2012/'.$month.'/'.$day.'/original/'.$image;
				$this -> syn_product_vs_foreign($item->id,'id',$row3);
			}
		}
		function add_other_images(){
			$arr_img_paths = array(array('trainer_small',70,110,'resized_not_crop'),array('trainer_large',597,473,'resized_not_crop'));
			$list = $this -> get_records(' id >= 576','fs_products_images','id,image,image_old','id ');
			$folder_image_begin = 'D:\xampp\htdocs\backup\nhasachhuongthuy\pictures_products\\';
			$day = '25';
			$month = '10';
			
			$folder_image_destination = 'D:\xampp\htdocs\svn\nhasachhuongthuy\code\images\products_trainer\2012\\'.$month.'\\'.$day.'\original\\';
			$fsFile = FSFactory::getClass('FsFiles','');
			for($i = 0; $i < count($list) ; $i ++){
				$item = $list[$i]; 
				$image = $item -> image_old;
				$fsFile -> create_folder($folder_image_destination);
				if(!$fsFile -> copy_file($folder_image_begin.$image,$folder_image_destination.$image))
					continue;
				foreach($arr_img_paths as $path){
					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination);
					$fsFile -> create_folder($path_resize);
					$method_resize = $path[3]?$path[3]:'resized_not_crop';
					if(!$fsFile ->$method_resize($folder_image_destination.$image, $path_resize.$image,$path[1], $path[2]))
						continue;
				}
				$row3['image'] = 'images/products_trainer/2012/'.$month.'/'.$day.'/original/'.$image;
				$this -> _update($row3, 'fs_products_images',' `id` = '.$item->id);
			}
		}
		
		function syn_images(){

			$arr_syn = array(
					'pipr_id'  =>'id',
				  'pipr_name' =>'name',
				  'pipr_order' =>'ordering',
				  'pipr_product' => 'product_id',
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM pictures_product ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$arr_types = array(1=>'bia-truoc',2=>'muc-luc',3=>'trich-doan',4=>'bia-sau');
				$row['type'] = $arr_types[$item_r -> pipr_type];
				echo $this -> _add($row, 'fs_products_images',1);
			}
		}
		
		function syn_product_vs_foreign($foreign_id,$foreign_name,$row){
			$this -> _update($row, 'fs_products',' `'.$foreign_name.'` = '.$foreign_id,1);
		}
		
		function _save()
		{
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM item ';
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			
			
			// select db in local
			global $db;
			$select = ' SELECT * FROM fs_products ';
			$db->query($select);
			$list = $db->getObjectList();
			$arr_result = array();
			$time = date('Y-m-d H:i:s');
			
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				for($j = 0; $j < count($list) ; $j ++){
					$item = $list[$j];
					if((trim($item_r -> Code) == trim($item -> code)) && trim($item -> code) != ''){
						$price_r = (int)$item_r -> SellPriceTot;
						$quantity_r = (int)$item_r -> StockCrt;
						
						// address from remote db
						
						// update if different
						if($price_r != $item -> price || $quantity_r != $item -> quantity){
							$sql = 'UPDATE fs_products '; 
							$sql .= ' ';
							$sql .= ' ';
							$sql .= ' edited_time = \''.$time.'\' ';
							$sql .= ' WHERE id = '.$item -> id;
							global $db;
							$db->query($sql);
							$rows = $db->affected_rows();
							if($rows)
								if( $price_r != $item -> price && $item -> tablename ){
									if($db -> checkExistTable($item -> tablename)){
										$sql = 'UPDATE '.$item -> tablename; 
										$sql .= ' SET ext_price = \''.$price_r.'\' ';
										$sql .= ' WHERE productid = '.$item -> id;	
										
										$db->query($sql);
										$rows2 = $db->affected_rows();
									}
								}
								$arr_result[] = array('id' => $item ->id, 'name'=> $item -> name);
							}
						}
					}
				}
			return $arr_result;
		}
		
		/*
		 * Sua truong alias va price_old
		 */
		function repair_products(){
			$list = $this -> get_records('','fs_products','id,name,price,price_old,price_outsite','id ');
			$fsstring = FSFactory::getClass('FSString','','../');
				
			for($i = 0; $i < count($list) ; $i ++){
				$item = $list[$i]; 
				$row3['alias'] = $fsstring -> stringStandart($item -> name);
				$row3['price_old'] = $fsstring -> stringStandart($item -> price_outsite);
				$this -> syn_product_vs_foreign($item->id,'id',$row3);
			}
		}
		
		/*
		 * Resize lai anh tu bang fs_products
		 * Ko update lai db
		 */
		function new_resize_images(){

			global $db;
			$select = ' SELECT * FROM fs_products WHERE  id <= 500';
//			$select = ' SELECT * FROM fs_products WHERE id < 1500 AND id >=1000';
			$sql = $db->query($select);
			
			$list = $db->getObjectList();
			
			$arr_img_paths = array(array('resized',141,197,'resized_not_crop'),array('large',251,350,'resized_not_crop'));
			$fsFile = FSFactory::getClass('FsFiles','');
			for($i = 0; $i < count($list) ; $i ++){
				$item = $list[$i]; 
				$image = PATH_BASE.str_replace('/',DS,$item -> image);
//				$fsFile -> create_folder($folder_image_destination);
//				if(!$fsFile -> copy_file($folder_image_begin.$image,$folder_image_destination.$image))
//					continue;
				foreach($arr_img_paths as $path){
					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $image);
//					$fsFile -> create_folder($path_resize);
					$method_resize = $path[3]?$path[3]:'resized_not_crop';
//					$fsFile -> remove_file_by_path($path_resize);
					if(!$fsFile ->$method_resize($image, $path_resize,$path[1], $path[2])){
						echo $item->id.'_';
					}
//						return false;
				}
			}
		}
		
	}
?>
