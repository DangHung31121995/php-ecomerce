<?php
class FSModels
{
    var $limit;
    var $page;
    var $table_name;
    var $prefix;
    var $arr_img_paths;
    var $img_folder;
    var $call_update_sitemap;
    var $field_except_when_duplicate; // this field is updated auto follow other field ( not update by REQUEST ). Example : list_parents
    var $array_synchronize = array(); // đồng bộ dữ liệu ngoài bảng extend. Viết dang  array(tablename => array(field1, field2,...))
    var $use_table_extend; // use table extend. Example: fs_products_mobile
    var $type; // ex: products, pharmacology
    var $calculate_filters; // 1: calculate filters
    function __construct()
    {
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $this->module = $module;
        $this->view = $view;
        $page = FSInput::get('page', 0, 'int');
        $this->page = $page;
        $prefix = $this->module . '_' . $this->view . '_';
        $this->prefix = $prefix;
        //			$this -> arr_img_paths = array();
        //			$this -> img_folder = '';
    }
    function get_data()
    {
        global $db;
        $query = $this->setQuery();
        if (!$query)
            return array();
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();
        return $result;
    }
    function setQuery()
    {
        $field_search = 'name';
        // ordering
        $ordering = "";
        if (isset($_SESSION[$this->prefix . 'sort_field']))
        {
            $sort_field = $_SESSION[$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            $ordering = '';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
        }
        if (!$ordering)
            $ordering .= " ORDER BY created_time DESC , id DESC ";
        $where = "  ";
        if (isset($_SESSION[$this->prefix . 'keysearch']))
        {
            if ($_SESSION[$this->prefix . 'keysearch'])
            {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND " . $field_search . " LIKE '%" . $keysearch . "%' ";
            }
        }
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " . $where . $ordering . " ";
        return $query;
    }
    /*
    * show total of models
    */
    function getTotal()
    {
        global $db;
        $query = $this->setQuery();
        $sql = $db->query($query);
        $total = $db->getTotal();
        return $total;
    }
    function getPagination()
    {
        $total = $this->getTotal();
        $pagination = new Pagination($this->limit, $total, $this->page);
        return $pagination;
    }
    /*
    * get info of Category
    */
    function get_record_by_id($id, $table_name = '')
    {
        if (!$id)
            return;
        if (!$table_name)
            $table_name = $this->table_name;
        $query = " SELECT *
						  FROM " . $table_name . "
						  WHERE id = $id ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    /*
    * get record 
    */
    function get_record($where = '', $table_name = '', $select = '*')
    {
        if (!$where)
            return;
        if (!$table_name)
            $table_name = $this->table_name;
        $query = " SELECT " . $select . "
						  FROM " . $table_name . "
						  WHERE " . $where;
        global $db;
        $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    /*
    * get record by rid
    */
    function get_records($where = '', $table_name = '', $select = '*', $ordering =
        '', $limit = '', $field_key = '')
    {
        $sql_where = " ";
        if ($where)
        {
            $sql_where .= ' WHERE ' . $where;
        }
        if (!$table_name)
            $table_name = $this->table_name;
        $query = " SELECT " . $select . "
					  FROM " . $table_name . $sql_where;
        if ($ordering)
            $query .= ' ORDER BY ' . $ordering;
        if ($limit)
            $query .= ' LIMIT ' . $limit;
        global $db;
        $sql = $db->query($query);
        if (!$field_key)
            $result = $db->getObjectList();
        else
            $result = $db->getObjectListByKey($field_key);
        return $result;
    }
    function get_count($where = '', $table_name = '')
    {
        if (!$where)
            return;
        if (!$table_name)
            $table_name = $this->table_name;
        $query = " SELECT count(*)
						  FROM " . $table_name . "
						  WHERE " . $where;
        global $db;
        $sql = $db->query($query);
        $result = $db->getResult();
        return $result;
    }
    /*
    * Return result
    */
    function get_result($where = '', $table_name = '', $field = 'id')
    {
        if (!$where)
            return;
        if (!$table_name)
            $table_name = $this->table_name;
        $select = " SELECT " . $field . " ";
        $query = $select . "  FROM " . $table_name . "
						  WHERE " . $where;
        global $db;
        $sql = $db->query($query);
        $result = $db->getResult();
        return $result;
    }
    function get_field_by_id($id, $field, $table_name = '')
    {
        if (!$id)
            return;
        if (!$table_name)
            $table_name = $this->table_name;
        $query = " SELECT $field
						  FROM " . $table_name . "
						  WHERE id = $id ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getResult();
        return $result;
    }
    /*
    * get record by rid
    */
    function get_record_by_rid($id, $table_name = '')
    {
        if (!$id)
            return;
        if (!$table_name)
            $table_name = $this->table_name;
        $query = " SELECT *
						  FROM " . $table_name . "
						  WHERE rid = $id ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    /*
    * remove record
    * $img_field is image field need remove.
    * $img_paths is paths contain image
    */
    function remove()
    {
        // check remove
        if (method_exists($this, 'check_remove'))
        {
            if (!$this->check_remove())
            {
                Errors::_(FSText::_('Can not remove these records because have data are related'));
                return false;
            }
        }
        $cids = FSInput::get('id', array(), 'array');
        foreach ($cids as $cid)
        {
            if ($cid != 1)
                $cids[] = $cid;
        }
        if (!count($cids))
            return false;
        $str_cids = implode(',', $cids);
        $field_img = isset($this->field_img) ? $this->field_img : '';
        $use_table_extend = isset($this->use_table_extend) ? $this->use_table_extend : 0;
        // array table_names is changed. ( for calculate filter)
        $arr_table_name_changed = array();
        if ($field_img || $use_table_extend)
        {
            $select = 'id';
            if ($field_img)
                $select .= ',' . $field_img;
            if ($use_table_extend)
                $select .= ',tablename';
            $query = " SELECT " . $select . " FROM " . $this->table_name . "
						WHERE id IN (" . $str_cids . ") ";
            global $db;
            $sql = $db->query($query);
            $result = $db->getObjectList();
            if (!$result)
                return;
            foreach ($result as $item)
            {
                // remove img
                if ($field_img)
                {
                    $old_image = $item->$field_img;
                    $arr_img_paths = $this->arr_img_paths;
                    if (count($arr_img_paths))
                    {
                        foreach ($arr_img_paths as $item_path)
                        {
                            $path_resize = str_replace('/original/', '/' . $item_path[0] . '/', $old_image);
                            $path_resize = PATH_BASE . str_replace('/', DS, $path_resize);
                            unlink($path_resize);
                        }
                    }
                    $old_image = PATH_BASE . str_replace('/', DS, $old_image);
                    unlink($old_image);
                }
                if ($use_table_extend)
                {
                    // remove data in table fs_Type_extend
                    $table_extend = $item->tablename;
                    // for caculator filters
                    $arr_table_name_changed[] = $table_extend;
                    if ($table_extend)
                    {
                        if ($db->checkExistTable($table_extend))
                            $this->_remove('record_id  = ' . $item->id, $table_extend);
                    }
                }
                //synchronize
                $array_synchronize = $this->array_synchronize;
                if (count($array_synchronize))
                {
                    foreach ($array_synchronize as $table_name => $fields)
                    {
                        $syn = 0;
                        $row5 = array();
                        $where = '';
                        foreach ($fields as $cur_field => $syn_field)
                        {
                            $where .= $syn_field . ' = ' . $item->id;
                            break;
                        }
                        $rs = $this->_update($row5, $table_name, $where, 0);
                        $this->_remove($where, $table_name);
                    }
                }
            }
        }
        $sql = " DELETE FROM " . $this->table_name . " 
						WHERE id IN ( $str_cids ) ";
        global $db;
        $db->query($sql);
        $rows = $db->affected_rows();
        // update sitemap
        if ($this->call_update_sitemap)
        {
            $this->call_update_sitemap();
        }
        // 	calculate filters:
        if ($this->calculate_filters)
        {
            $this->caculate_filter($arr_table_name_changed);
        }
        return $rows;
    }
    /*
    * remove record
    * $img_field is image field need remove.
    * $img_paths is paths contain image
    */
    //		function remove2($img_field = '')
    //		{
    //			$cids = FSInput::get('id',array(),'array');
    //			$num_record = 0;
    //			if(count($cids))
    //			{
    //				$str_cids = implode(',',$cids);
    //				if($img_field)
    //					$this -> remove_old_image($str_cids,$img_field);
    //
    //				global $db;
    //
    //				$sql = " DELETE FROM ".$this -> table_name."
    //						WHERE id IN ( $str_cids ) " ;
    //				$db->query($sql);
    //				$rows = $db->affected_rows();
    //				return $rows;
    //			}
    //			return 0;
    //		}
    /*
    * value: == 1 :published
    * value  == 0 :unpublished
    * published record
    */
    function published($value)
    {
        $ids = FSInput::get('id', array(), 'array');
        if (count($ids))
        {
            global $db;
            $str_ids = implode(',', $ids);
            $sql = " UPDATE " . $this->table_name . "
							SET published = $value
						WHERE id IN ( $str_ids ) ";
            $db->query($sql);
            $rows = $db->affected_rows();
            // 	update sitemap
            if ($this->call_update_sitemap)
            {
                $this->call_update_sitemap();
            }
            // array table_names is changed. ( for calculate filter)
            $arr_table_name_changed = array();
            // update table fs_TYPE_extend
            if ($this->use_table_extend)
            {
                foreach ($ids as $id)
                {
                    $record = $this->get_record('id = ' . $id, $this->table_name);
                    $table_extend = $record->tablename;
                    // calculate filter:
                    $arr_table_name_changed[] = $table_extend;
                    global $db;
                    if ($table_extend && $db->checkExistTable($table_extend))
                    {
                        $row['published'] = $value;
                        $rs = $this->_update($row, $table_extend, ' record_id = ' . $id);
                    }
                }
            }
            //synchronize
            $array_synchronize = $this->array_synchronize;
            if (count($array_synchronize))
            {
                foreach ($array_synchronize as $table_name => $fields)
                {
                    $i = 0;
                    $syn = 0;
                    $row5 = array();
                    $where = ' ';
                    foreach ($fields as $cur_field => $syn_field)
                    {
                        if (!$i)
                        {
                            $where .= $syn_field . ' = ' . $id;
                        } else
                        {
                            if ($cur_field == 'published')
                            {
                                $row5[$syn_field] = $value;
                                $syn = 1;
                            }
                        }
                        $i++;
                    }
                    if ($syn)
                    {
                        $rs = $this->_update($row5, $table_name, $where);
                    }
                }
            }
            // calculate filters:
            if ($this->calculate_filters)
            {
                $this->caculate_filter($arr_table_name_changed);
            }
            return $rows;
        }
        return 0;
    }
    /*
    * value: == 1 :published
    * value  == 0 :unpublished
    * published record
    */
    function duplicate()
    {
        $ids = FSInput::get('id', array(), 'array');
        $rs = 0;
        $field_except = $this->field_except_when_duplicate;
        $time = date('Y-m-d H:i:s');
        if (count($ids))
        {
            global $db;
            $str_ids = implode(',', $ids);
            $records = $this->get_records(' id IN (' . $str_ids . ')', $this->table_name);
            if (!count($records))
                return false;
            foreach ($records as $item)
            {
                $row = array();
                $field_key1 = 'name'; // title or name
                $key1 = ''; // title or name
                $key2 = ''; // alias
                foreach ($item as $key => $value)
                {
                    if ($key == 'id' || (isset($this->field_img) && $key == $this->field_img))
                    {
                        continue;
                    }
                    if ($key == 'name' || $key == 'title')
                    {
                        $key1 = $value;
                        $field_key1 = $key;
                        continue;
                    }
                    if ($key == 'alias')
                    {
                        $key2 = $value;
                        continue;
                    }
                    if ($key == 'edited_time' || $key == 'created_time' || $key == 'updated_time')
                    {
                        $row[$key] = $time;
                        continue;
                    }
                    $row[$key] = mysql_real_escape_string($value);
                }
                if (!$key1)
                    continue;
                $j = 0;
                while (true)
                {
                    if (!$j)
                    {
                        $key1_copy = $key1 . ' copy';
                        $key2_copy = $key2 . '-copy';
                    } else
                    {
                        $key1_copy = $key1 . ' copy ' . $j;
                        $key2_copy = $key2 . '-copy-' . $j;
                    }
                    $where = $field_key1 . ' = "' . mysql_real_escape_string($key1_copy).'"';
                    if(isset($item -> alias)){
                    	 $where .= ' OR alias = "' . mysql_real_escape_string($key2_copy) . '" ';
                    }
                    $check_exist = $this->get_count($where, $this->table_name);
                    if (!$check_exist)
                    {
                        $row[$field_key1] = $key1_copy;
                        if(isset($item -> alias))
                        	$row['alias'] = $key2_copy;
                        break;
                    }
                    $j++;
                }
                $new_record_id = $this->_add($row, $this->table_name, 1);
                if ($new_record_id)
                {
                    $row2 = array();
                    $new_record = $this->get_record(' id = ' . $new_record_id, $this->table_name);
                    // except : wrapper_alias, list_parents
                    if ($field_except && count($field_except))
                    {
                        foreach ($field_except as $f)
                        {
                            echo $row2[$f[0]] = str_replace(',' . $item->$f[1] . ',', ',' . $new_record->$f[1] .
                                ',', $row[$f[0]]);
                        }
                        $this->_update($row2, $this->table_name, ' id = ' . $new_record_id);
                    }
                    // duplicate data extend
                    if ($this->use_table_extend)
                    {
                        $row3 = array();
                        $row3 = $row;
                        unset($row3['tablename']);
                        $row3['record_id'] = $new_record_id;
                        $table_extend = $item->tablename;
                        // for caculator filters
                        $arr_table_name_changed[] = $table_extend;
                        if ($table_extend && $db->checkExistTable($table_extend))
                        {
                            $record_extend = $this->get_record('record_id = ' . $item->id, $table_extend);
                            foreach ($record_extend as $field_ext_name => $field_ext_value)
                            {
                                if (isset($row3[$field_ext_name]) || $field_ext_name == 'id')
                                    continue;
                                $row3[$field_ext_name] = $field_ext_value;
                            }
                            if (!$this->_add($row3, $table_extend))
                                continue;
                        }
                    }
                    $rs++;
                }
            }
            // 	update sitemap
            if ($this->call_update_sitemap)
            {
                $this->call_update_sitemap();
            }
            // calculate filters:
            if ($this->calculate_filters)
            {
                $this->caculate_filter($arr_table_name_changed);
            }
            return $rs;
        }
        return 0;
    }
    /*
    * get Max value of Ordering field in table fs_categories
    */
    function getMaxOrdering()
    {
        $query = " SELECT Max(a.ordering)
					 FROM " . $this->table_name . " AS a
					";
        global $db;
        $sql = $db->query($query);
        $result = $db->getResult();
        if (!$result)
            return 1;
        return ($result + 1);
    }
    /*
    * get field of table
    */
    function get_field_table($table_name = '',$key_field_name = 0){
		if(!$table_name)	
			$table_name = $this -> table_name;
		global $db;
		$query = "SHOW COLUMNS FROM ".$table_name." ";
		$db->query($query);
		if($key_field_name)
			$fields_in_table = $db->getObjectListByKey('Field');
		else 
			$fields_in_table = $db->getObjectList();
		return $fields_in_table;
	}
    /*
    * save into table
    */
    function save($row = array(), $use_mysql_real_escape_string = 0)
    {
        $id = FSInput::get('id', 0, 'int');
        if (!$id)
            return $this->save_new($row, $use_mysql_real_escape_string);
        else
            return $this->save_change($id, $row, $use_mysql_real_escape_string);
    }
    function save_new($row, $use_mysql_real_escape_string = 0)
    {
        $fields_in_table = $this->get_field_table();
        $str_fields = array();
        $str_values = array();
        $field_img = isset($this->field_img) ? $this->field_img : 'image';
        for ($i = 0; $i < count($fields_in_table); $i++)
        {
            $item = $fields_in_table[$i];
            $field = $item->Field;
            if ($field == 'alias')
            {
                if (!isset($row['alias']))
                {
                    $alias = FSInput::get('alias');
                    $fsstring = FSFactory::getClass('FSString', '', '../');
                    if (!$alias)
                    {
                        $title = FSInput::get('title');
                        if (!$title)
                            $title = FSInput::get('name');
                        if (!$title)
                        {
                            Errors::_('Cần nhập tên hoặc tiêu đề');
                            return false;
                        }
                        $row['alias'] = $fsstring->stringStandart($title);
                    } else
                    {
                        $row['alias'] = $fsstring->stringStandart($alias);
                    }
                }
                if ($this->check_alias)
                {
                    if ($this->check_exist($row['alias']))
                    {
                        Errors::_('Alias của bạn đã bị trùng tên');
                        return false;
                    }
                }
            }
            if ($field == $field_img && !isset($row[$field_img]) && $field_img)
            {
                $image = $_FILES[$field_img]["name"];
                if ($image)
                {
                    $suffix = '-' . time();
                    if(isset($row['alias']))
                        $suffix = $row['alias'].'-' . time();
                    $image = $this->upload_image($field_img, $suffix, 2000000);
                    $row[$field_img] = $image;
                }
            }
            if (isset($row[$field]))
            {
                $str_fields[] = "`" . $field . "`";
                $str_values[] = "'" . $row[$field] . "'";
            } else
                if (isset($_POST[$field]))
                {
                    $type = $item->Type;
                    $value = $_POST[$field];
                    if (strpos($type, 'text') !== false || strpos($type, 'varchar') !== false)
                    {
                        $str_fields[] = "`" . $field . "`";
                        if ($use_mysql_real_escape_string)
                        {
                            $str_values[] = "'" . mysql_real_escape_string($value) . "'";
                        } else
                        {
                            $str_values[] = "'" . mysql_real_escape_string(htmlspecialchars_decode($value)) .
                                "'";
                        }
                    } else
                    {
                        $str_fields[] = "`" . $field . "`";
                        $str_values[] = "'" . $value . "'";
                    }
                } else
                {
                    if ($field == 'edited_time' || $field == 'created_time' || $field ==
                        'updated_time')
                    {
                        $time = date('Y-m-d H:i:s');
                        $str_fields[] = "`" . $field . "`";
                        $str_values[] = "'" . $time . "'";
                    }
                }
            if ($field == 'lang' && MULTI_LANGUAGE){
                $str_fields[] = "`lang`";
                $str_values[] = "'" . $_SESSION['adlang'] . "'";
            }
        }
        if (!count($str_fields))
            return false;
        $str_fields = implode(',', $str_fields);
        $str_values = implode(',', $str_values);
        global $db;
        $sql = ' INSERT INTO  ' . $this->table_name;
        $sql .= '(' . $str_fields . ") ";
        $sql .= 'VALUES (' . $str_values . ") ";
        $db->query($sql);
        $id = $db->insert();
        // calculate filters:
        if ($this->calculate_filters)
        {
            $arr_table_name_changed = array();
            if (isset($row['tablename']) && !empty($row['tablename']))
                $arr_table_name_changed[] = $row['tablename'];
            $this->caculate_filter($arr_table_name_changed);
        }
        return $id;
    }
    /*
    * Update:
    * update field from :row, time and request
    */
    function save_change($id, $row = array(), $use_mysql_real_escape_string = 0)
    {
        if (!$id)
            return;
        $fields_in_table = $this->get_field_table();
        $str_update = array();
        $field_img = isset($this->field_img) ? $this->field_img : 'image';
        // mảng  $row1 này chỉ phục vụ cho việc đồng bộ dữ liệu ra bảng ngoài theo cấu hình $array_synchronize
        for ($i = 0; $i < count($fields_in_table); $i++)
        {
            $item = $fields_in_table[$i];
            $field = $item->Field;
            if ($field == 'alias')
            {
                if (!isset($row['alias']))
                {
                    $alias = FSInput::get('alias');
                    $fsstring = FSFactory::getClass('FSString', '', '../');
                    if (!$alias)
                    {
                        $title = FSInput::get('title');
                        if (!$title)
                            $title = FSInput::get('name');
                        if (!$title)
                        {
                            Errors::_('Cần nhập tên hoặc tiêu đề');
                            return false;
                        }
                        $row['alias'] = $fsstring->stringStandart($title);
                    } else
                    {
                        $row['alias'] = $fsstring->stringStandart($alias);
                    }
                }
                if ($this->check_alias)
                {
                    if ($this->check_exist($row['alias'], $id))
                    {
                        Errors::_('Alias của bạn đã bị trùng tên');
                        return false;
                    }
                }
            }
            if ($field == $field_img && !isset($row[$field_img]) && $field_img)
            {
                $image = $_FILES[$field_img]["name"];
                if ($image)
                {
                    // remove old if exists record and img
                    $suffix = '-' . time();
                    if(isset($row['alias']))
                        $suffix = $row['alias'].'-' . time();
                    $this->remove_old_image($id, $field_img);
                    $image = $this->upload_image($field_img, $suffix, 2000000, NULL, $alias);
                    $row[$field_img] = $image;
                }
            }
            if (isset($row[$field]))
            {
                $str_update[] = "`" . $field . "` = '" . $row[$field] . "'";
            } else
                if (isset($_POST[$field]))
                {
                    $type = $item->Type;
                    $value = $_POST[$field];
                    if (strpos($type, 'text') !== false || strpos($type, 'varchar') !== false)
                    {
                        //						$str_update[] = "`".$field."` = '".mysql_real_escape_string($_POST[$field])."'";
                        //						$str_update[] = "`".$field."` = '".htmlspecialchars_decode(FSInput::get($field))."'";
                        if ($use_mysql_real_escape_string)
                            $row[$field] = mysql_real_escape_string(FSInput::get($field));
                        else
                            $row[$field] = htmlspecialchars_decode(FSInput::get($field));
                    } else
                    {
                        //						$str_update[] = "`".$field."` = '".$_POST[$field]."'";
                        $row[$field] = $_POST[$field]; // synchronize
                    }
                } else
                {
                    if ($field == 'edited_time' || $field == 'updated_time')
                    {
                        $time = date('Y-m-d H:i:s');
                        //						$str_update[] = "`".$field."` = '".$time."'";
                        $row[$field] = $time; // synchronize
                    }
                }
        }
        //			if(!count($str_update))
        //				return false;
        //			$str_update = implode(',',$str_update);
        //			global $db;
        $rows = $this->_update($row, $this->table_name, ' id = ' . $id, 0);
        //			 $sql = ' UPDATE  '.$this ->  table_name . ' SET ';
        //			$sql .=  $str_update;
        //			$sql .=  ' WHERE id = '.$id.' ';
        //			$db->query($sql);
        //			$rows = $db->affected_rows();
        // calculate filters:
        if ($this->calculate_filters)
        {
            $arr_table_name_changed = array();
            if (isset($row['tablename']) && !empty($row['tablename']))
                $arr_table_name_changed[] = $row['tablename'];
            $this->caculate_filter($arr_table_name_changed);
        }
        //synchronize
        $array_synchronize = $this->array_synchronize;
        if (count($array_synchronize))
        {
            foreach ($array_synchronize as $table_name => $fields)
            {
                $i = 0;
                $syn = 0;
                $row5 = array();
                $where = ' ';
                foreach ($fields as $cur_field => $syn_field)
                {
                    if (!$i)
                    {
                        $where .= $syn_field . ' = ' . $id;
                    } else
                    {
                        if (isset($row[$cur_field]))
                        {
                            $row5[$syn_field] = $row[$cur_field];
                            $syn = 1;
                        }
                    }
                    $i++;
                }
                if ($syn)
                    $rs = $this->_update($row5, $table_name, $where, 0);
            }
        }
        if ($rows)
            return $rows ? $id : 0;
    }
    /*
    * Change alias of category in table_item (news,products,...)
    */
    function _update($row, $table_name, $where = '', $use_mysql_real_escape_string =
        1)
    {
        $total = count($row);
        if (!$total || !$table_name)
            return;
        $sql = 'UPDATE ' . $table_name . ' SET ';
        $i = 0;
        foreach ($row as $key => $value)
        {
            if ($use_mysql_real_escape_string)
                $sql .= "`" . $key . "` = '" . mysql_real_escape_string($value) . "'";
            else
                $sql .= "`" . $key . "` = '" . $value . "'";
            if ($i < $total - 1)
                $sql .= ',';
            $i++;
        }
        if ($where)
            $where = ' WHERE ' . $where;
        $sql .= $where;
        global $db;
        $db->query($sql);
        $rows = $db->affected_rows();
        return $rows;
    }
    function _add($row, $table_name, $use_mysql_real_escape_string = 0)
    {
        if (!$table_name)
            return false;
        $str_fields = array();
        $str_values = array();
        if (!count($row))
            return;
        foreach ($row as $field => $value)
        {
            if ($use_mysql_real_escape_string)
            {
                $value = mysql_real_escape_string($value);
            } else
            {
            }
            $str_fields[] = "`" . $field . "`";
            $str_values[] = "'" . $value . "'";
        }
        $str_fields = implode(',', $str_fields);
        $str_values = implode(',', $str_values);
        global $db;
        $sql = ' INSERT INTO  ' . $table_name;
        $sql .= '(' . $str_fields . ") ";
        $sql .= 'VALUES (' . $str_values . ") ";
        $db->query($sql);
        $id = $db->insert();
        return $id;
    }
    /*
    * Value need remove
    */
    function _remove($where = '', $table_name = '')
    {
        $sql_where = '';
        if ($where)
            $sql_where .= ' WHERE ' . $where;
        if (!$table_name)
            $table_name = $this->table_name;
        $sql = " DELETE FROM " . $table_name . $sql_where;
        global $db;
        $db->query($sql);
        $rows = $db->affected_rows();
        return $rows;
    }
    /*
    * Return result
    */
    function _get_result($where = '', $table_name = '', $field = 'id')
    {
        if (!$where)
            return;
        if (!$table_name)
            $table_name = $this->table_name;
        $select = " SELECT " . $field . " ";
        $query = $select . "  FROM " . $table_name . "
						  WHERE " . $where;
        global $db;
        $sql = $db->query($query);
        $result = $db->getResult();
        return $result;
    }
    /*
    * Update only param call
    */
    function record_update($row, $id, $table_name = '')
    {
        if (!$table_name)
            $table_name = $this->table_name;
        if (!count($row))
            return;
        $str_update = array();
        foreach ($row as $key => $value)
        {
            $str_update[] = "`" . $key . "` = '" . $value . "'";
        }
        // convert to string
        $str_update = implode(',', $str_update);
        $sql = ' UPDATE  ' . $table_name . ' SET ';
        $sql .= $str_update;
        $sql .= ' WHERE id = 	  ' . $id . ' ';
        global $db;
        $db->query($sql);
        $rows = $db->affected_rows();
        if ($rows)
            return $rows ? $id : 0;
    }
    function get_all_record($table_name)
    {
        $query = " SELECT *
						  FROM " . $table_name . " ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    /*
    * check exist name, alias
    */
    function check_exist_alias($name, $alias, $id = '', $table_name)
    {
        if (!$name || !$table_name)
            return;
        $query = " SELECT count(*)
						  FROM " . $table_name . " 
						WHERE (name = '" . $name . "'
						OR alias = '" . $alias . "') ";
        if ($id)
            $query .= ' AND id <> ' . $id . ' ';
        global $db;
        $sql = $db->query($query);
        $result = $db->getResult();
        return $result;
    }
    /*
    * Remove img
    */
    // remove image of id IN str_id
    function remove_image($sts_ids, $path_arr = array(), $field = 'image', $table_name =
        '')
    {
        if (!$sts_ids || !count($path_arr))
            return;
        if (!$table_name)
            $table_name = $this->table_name;
        $sql = " SELECT " . $field . "
					 FROM " . $table_name . "
					 WHERE  id IN (" . $sts_ids . ") ";
        global $db;
        $db->query($sql);
        $list = $db->getObjectList();
        for ($i = 0; $i < count($list); $i++)
        {
            $image = $list[$i]->$field;
            if ($image)
                for ($j = 0; $j < count($path_arr); $j++)
                {
                    if (!@unlink($path_arr[$j] . $image))
                    {
                        Errors::_('Not remove image' . $path_arr[$j] . $image);
                    }
                }
        }
        return true;
    }
    /*
    * Note: Image link is fixed link. This have url_root
    * Remove old width new method
    */
    // remove image of id IN str_id
    function remove_old_image($sts_ids, $field = 'image', $table_name = '')
    {
        if (!$sts_ids)
            return;
        $path_arr = $this->arr_img_paths;
        if (!$table_name)
            $table_name = $this->table_name;
        $sql = " SELECT " . $field . "
					 FROM " . $table_name . "
					 WHERE  id IN (" . $sts_ids . ") ";
        global $db;
        $db->query($sql);
        $list = $db->getObjectList();
        for ($i = 0; $i < count($list); $i++)
        {
            $image = $list[$i]->$field;
            if ($image)
            {
                $image = PATH_BASE . str_replace('/', DS, $image);
                if (!@unlink($image))
                {
                    Errors::_('Not remove image' . $image);
                }
                for ($j = 0; $j < count($path_arr); $j++)
                {
                    $link = str_replace(DS . 'original' . DS, DS . $path_arr[$j][0] . DS, $image);
                    if (!@unlink($link))
                    {
                        Errors::_('Not remove image' . $link);
                    }
                }
            }
        }
        return true;
    }
    /*
    * Remove file
    */
    // remove file of id IN str_id
    function remove_file($sts_ids, $path_arr = array(), $field = 'image', $table_name =
        '')
    {
        if (!$sts_ids || !count($path_arr))
            return;
        if (!$table_name)
            $table_name = $this->table_name;
        $sql = " SELECT " . $field . "
					 FROM " . $table_name . "
					 WHERE  id IN (" . $sts_ids . ") ";
        global $db;
        $db->query($sql);
        $list = $db->getObjectList();
        for ($i = 0; $i < count($list); $i++)
        {
            $image = $list[$i]->$field;
            if ($image)
                for ($j = 0; $j < count($path_arr); $j++)
                {
                    if (!@unlink($path_arr[$j] . $image))
                    {
                        Errors::_('Not remove image' . $path_arr[$j] . $image);
                    }
                }
        }
        return true;
    }
    /*
    * Check exist of record in tables of language
    */
    function check_translate($table_name, $rid)
    {
        if (!$table_name)
            return false;
        global $db;
        $lang_arr = array('en', 'vi');
        $lang_current = $_SESSION['con_lang'];
        foreach ($lang_arr as $lang)
        {
            if ($lang != $lang_current)
            {
                $query = " SELECT id
							  FROM " . $table_name . "
							  WHERE rid = $rid ";
                $db->query($query);
                $result = $db->getResult();
                if ($result)
                    return true;
            }
        }
        return false;
    }
    /*
    * get District
    * default: Ha Noi
    */
    function get_districts($city_id = '1473')
    {
        if (!isset($city_id))
            $city_id = 1473;
        global $db;
        $sql = " SELECT id, name FROM fs_districts
					WHERE city_id = $city_id ";
        $db->query($sql);
        return $db->getObjectList();
    }
    function get_cities_follow_country($country_id = '66')
    {
        if (!$country_id)
            $country_id = 1473;
        global $db;
        $sql = " SELECT id, name FROM fs_cities
					WHERE country_id = $country_id ";
        $db->query($sql);
        return $db->getObjectList();
    }
    function get_city()
    {
        global $db;
        $sql = " SELECT id, name FROM fs_cities ";
        $db->query($sql);
        return $db->getObjectList();
    }
    /*
    * get Estore
    */
    function get_estore()
    {
        $estore_id = $_SESSION['estore_id'];
        if (!$estore_id)
            return;
        global $db;
        $sql = " SELECT *
					FROM fs_estores
					WHERE `id`  = '$estore_id' 
					";
        $db->query($sql);
        return $db->getObject();
    }
    /*
    * get rid
    * 1. if rid exist: get Max rid
    * 2. if rid not exist : get rid
    */
    function get_record_id_for_language($table_name, $rid_need_check)
    {
        if (!$table_name && !$rid_need_check)
            return 0;
        global $db;
        $lang_arr = array('en', 'vi');
        $lang_current = $_SESSION['con_lang'];
        $exist = 0;
        foreach ($lang_arr as $lang)
        {
            $query = " SELECT rid
				  FROM " . $table_name . '_' . $lang . "
				  WHERE rid = $rid_need_check ";
            $db->query($query);
            $result = $db->getResult();
            if ($result)
            {
                $exist = 1;
                break;
            }
        }
        if (!$exist)
            return $rid_need_check;
        $max_rid = 0;
        foreach ($lang_arr as $lang)
        {
            $query = " SELECT Max(rid) as max_rid
				  FROM " . $table_name . "
				   ";
            $db->query($query);
            $result = $db->getResult();
            $max_rid = $max_rid > $result ? $max_rid : $result;
        }
        return $max_rid + 1;
    }
    /*
    * Save all record for list form
    */
    function save_all()
    {
        $total = FSInput::get('total', 0, 'int');
        if (!$total)
            return true;
        $field_change = FSInput::get('field_change');
        if (!$field_change)
            return false;
        // 	calculate filters:
        $arr_table_name_changed = array();
        $field_change_arr = explode(',', $field_change);
        $total_field_change = count($field_change_arr);
        $record_change_success = 0;
        for ($i = 0; $i < $total; $i++)
        {
            $str_update = '';
            $update = 0;
            $row = array();
            foreach ($field_change_arr as $field_item)
            {
                $field_value_original = FSInput::get($field_item . '_' . $i . '_original');
                $field_value_new = FSInput::get($field_item . '_' . $i);
                if (is_array($field_value_new))
                {
                    $field_value_new = count($field_value_new) ? ',' . implode(',', $field_value_new) .
                        ',' : '';
                }
                if ($field_value_original != $field_value_new)
                {
                    $update = 1;
                    //	        	          $row[$field_item] = htmlspecialchars_decode($field_value_new);
                    echo $row[$field_item] = htmlspecialchars_decode($field_value_new);
                    //	        	          echo $row[$field_item] = $field_value_new;
                    //	        	          die;
                    //	        	          $str_update[] = "`".$field_item."` = '".$field_value_new."'";
                }
            }
            if ($update)
            {
                $id = FSInput::get('id_' . $i, 0, 'int');
                $rs = $this->_update($row, $this->table_name, '  id = ' . $id, 0);
                if ($this->use_table_extend)
                {
                    $record = $this->get_record('id = ' . $id, $this->table_name);
                    $table_extend = $record->tablename;
                    // calculate filters:
                    $arr_table_name_changed[] = $table_extend;
                    global $db;
                    if ($db->checkExistTable($table_extend))
                    {
                        $rs = $this->_update($row, $table_extend, '  record_id = ' . $id);
                    }
                }
                //synchronize
                $array_synchronize = $this->array_synchronize;
                if (count($array_synchronize))
                {
                    foreach ($array_synchronize as $table_name => $fields)
                    {
                        $i = 0;
                        $syn = 0;
                        $row5 = array();
                        $where = ' WHERE ';
                        foreach ($fields as $cur_field => $syn_field)
                        {
                            if (!$i)
                            {
                                $where .= $syn_field . ' = ' . $id;
                            } else
                            {
                                if (isset($row[$cur_field]))
                                {
                                    $row5[$syn_field] = $row[$cur_field];
                                    $syn = 1;
                                }
                            }
                            $i++;
                        }
                        if ($syn)
                            $rs = $this->_update($row5, $table_name, $where, 0);
                    }
                }
                if (!$rs)
                    return false;
                $record_change_success++;
            }
        }
        // calculate filters:
        if ($this->calculate_filters)
        {
            $this->caculate_filter($arr_table_name_changed);
        }
        return $record_change_success;
    }
    /*
    * Show list category of tags
    */
    function get_tags_categories()
    {
        global $db;
        $query = " SELECT a.*, a.parent_id as parent_id 
                          FROM 
                            " . 'fs_tags_categories' . " AS a
                           ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        $limit = $this->limit;
        $page = $this->page ? $this->page : 1;
        $start = $limit * ($page - 1);
        $end = $start + $limit;
        $list_new = array();
        $i = 0;
        foreach ($list as $row)
        {
            if ($i >= $start && $i < $end)
            {
                $list_new[] = $row;
            }
            $i++;
            if ($i > $end)
                break;
        }
        return $list_new;
    }
    function change_status($field, $value)
    {
        if (!$field)
            return false;
        $ids = FSInput::get('id', array(), 'array');
        if (count($ids))
        {
            global $db;
            $str_ids = implode(',', $ids);
            $sql = " UPDATE " . $this->table_name . "
							SET `" . $field . "` = $value
						WHERE id IN ( $str_ids ) ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        return 0;
    }
    /*
    * value: == 1 :hot
    * value  == 0 :unhot
    * published record
    */
    function home($value)
    {
        $ids = FSInput::get('id', array(), 'array');
        if (count($ids))
        {
            global $db;
            $str_ids = implode(',', $ids);
            $sql = " UPDATE " . $this->table_name . "
							SET show_in_homepage = $value
						WHERE id IN ( $str_ids ) ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        // 	update sitemap
        if ($this->call_update_sitemap)
        {
            $this->call_update_sitemap();
        }
        return 0;
    }
    function check_exist($value, $id = '', $field = 'alias', $table_name = '')
    {
        if (!$value)
            return false;
        if (!$table_name)
            $table_name = $this->table_name;
        $query = " SELECT count(*)
					  FROM " . $table_name . " 
					WHERE 
						$field = '" . $value . "' ";
        if ($id)
            $query .= ' AND id <> ' . $id . ' ';
        global $db;
        $sql = $db->query($query);
        $result = $db->getResult();
        return $result;
    }
    function upload_image($image_tag_name = 'image', $suffix = '', $max_size =
        2000000, $arr_img_paths = array())
    {
        $img_folder = $this->img_folder;
        $img_link = str_replace('\\', '/', $img_folder);
        $img_folder = str_replace('/', DS, $img_folder);
        $img_folder = PATH_BASE . $img_folder . DS;
        $fsFile = FSFactory::getClass('FsFiles');
        // upload
        $path = $img_folder . 'original' . DS;
        if (!$fsFile->create_folder($path))
        {
            Errors::setError("Not create folder " . $path);
            return false;
        }
        $image = $fsFile->uploadImage($image_tag_name, $path, $max_size, $suffix);
        if (!$image)
            return false;
        $img_link = $img_link . '/original/' . $image;
        if (!count($arr_img_paths))
            $arr_img_paths = $this->arr_img_paths;
        if (!count($arr_img_paths))
            return $img_link;
        foreach ($arr_img_paths as $item)
        {
            $path_resize = str_replace(DS . 'original' . DS, DS . $item[0] . DS, $path);
            $fsFile->create_folder($path_resize);
            $method_resize = $item[3] ? $item[3] : 'resized_not_crop';
            if (!$fsFile->$method_resize($path . $image, $path_resize . $image, $item[1], $item[2]))
                return false;
        }
        return $img_link;
    }
    function update_sitemap($str_categories_id, $table_name = 'fs_news_categories',
        $module = 'news')
    {
        global $db;
        $sql = " SELECT * FROM  fs_sitemap
						WHERE record_id IN ( $str_categories_id ) 
						AND table_name = '" . $table_name . "'
						AND module = '" . $module . "'
						 ";
        $db->query($sql);
        $list_exit = $db->getObjectList();
        $array_record_exit = array();
        $array_field = array(
            'name',
            'alias',
            'alias_wrapper',
            'parent_id',
            'list_parents',
            'level',
            'published',
            'ordering',
            'created_time',
            'updated_time');
        foreach ($list_exit as $item)
        {
            $record = $this->get_record_by_id($item->record_id, $table_name);
            if (!$record)
            {
                $this->_remove('record_id = ' . $item->record_id, 'fs_sitemap');
                continue;
            }
            $row = array();
            $row['record_id'] = $record->id;
            $row['module'] = $module;
            $row['table_name'] = $table_name;
            foreach ($array_field as $field)
            {
                $row[$field] = $record->$field;
            }
            $this->_update($row, 'fs_sitemap', '  record_id = ' . $record->id .
                ' AND module = "' . $module . '" AND table_name = "' . $table_name . '"');
            $array_record_exit[] = $record->id;
        }
        $arr_categories_id = explode(',', $str_categories_id);
        foreach ($arr_categories_id as $item)
        {
            if (in_array($item, $array_record_exit))
                continue;
            $record = $this->get_record_by_id($item, $table_name);
            if (!$record)
            {
                $this->_remove('record_id = ' . $item, 'fs_sitemap');
                continue;
            }
            $row = array();
            $row['record_id'] = $record->id;
            $row['module'] = $module;
            $row['table_name'] = $table_name;
            foreach ($array_field as $field)
            {
                $row[$field] = $record->$field;
            }
            $this->_add($row, 'fs_sitemap');
        }
    }
    function call_update_sitemap()
    {
        $cids = FSInput::get('id', array(), 'array');
        if (!count($cids))
            return false;
        $str_cids = implode(',', $cids);
        $this->update_sitemap($str_cids, $this->table_name, $this->module);
    }
    /*
    * select in category
    */
    function get_categories_tree()
    {
        global $db;
        $query = $this->setQuery();
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        $limit = $this->limit;
        $page = $this->page ? $this->page : 1;
        $start = $limit * ($page - 1);
        $end = $start + $limit;
        $list_new = array();
        $i = 0;
        foreach ($list as $row)
        {
            if ($i >= $start && $i < $end)
            {
                $list_new[] = $row;
            }
            $i++;
            if ($i > $end)
                break;
        }
        return $list_new;
    }
    /************************************************************************************************/
    /*  CALCULATE FILTER *****/
    /************************************************************************************************/
    /*
    * Tính toán filter
    */
    function caculate_filter($arr_table_name = array())
    {
        // caculate for table fs_TYPE
        $this->calculate_filter_common();
        if (!count($arr_table_name))
            return true;
        foreach ($arr_table_name as $table_name)
        {
            // caculate for table fs_TYPE_extend
            $this->calculate_filter_extend($table_name);
        }
        return true;
    }
    /*
    * Xóa filter theo bảng hoặc category
    */
    function remove_filters($arr_table_name = array(), $arr_categories_id = array())
    {
        // caculate for table fs_TYPE
        $this->calculate_filter_common();
        if (count($arr_table_name))
        {
            foreach ($arr_table_name as $table_name)
            {
                // caculate for table fs_TYPE_extend
                $this->_remove(' tablename = "' . $table_name . '"', 'fs_' . $this->type .
                    '_filters_values');
            }
        }
        if (count($arr_categories_id))
        {
            foreach ($arr_categories_id as $category_id)
            {
                // caculate for table fs_TYPE_extend
                $this->_remove(' category_id = "' . $category_id . '"', 'fs_' . $this->type .
                    '_filters_values');
            }
        }
        return true;
    }
    function calculate_filter_common()
    {
        // get data from fs_TYPE
        $data = $this->get_records('published = 1', 'fs_' . $this->type);
        // get filter common
        $filters = $this->get_records('is_common = 1', 'fs_' . $this->type . '_filters');
        // get categories
        $categories = $this->get_records('', 'fs_' . $this->type . '_categories');
        if (!count($data) || !count($filters))
            return;
        $arr_filter = array();
        $arr_filter_id_current = array();
        $arr_filter_fieldname_current = array();
        $array_exit = array();
        foreach ($data as $item)
        {
            // duyệt ko có category
            $rs = $this->genate_array_filter($arr_filter, $filters, $arr_filter_id_current,
                $arr_filter_fieldname_current, $array_exit, $item, 0);
            $arr_filter = $rs[0];
            $array_exit = $rs[1];
            if (count($categories))
            {
                foreach ($categories as $category)
                {
                    $rs = $this->genate_array_filter($arr_filter, $filters, $arr_filter_id_current,
                        $arr_filter_fieldname_current, $array_exit, $item, $category->id);
                    $arr_filter = $rs[0];
                    $array_exit = $rs[1];
                }
            }
        }
    }
    /*
    * Đêm bộ lọc trong trường bảng mở rộng
    */
    function calculate_filter_extend($table_name)
    {
        // get data from fs_TYPE_extend
        $data = $this->get_records('published = 1', $table_name);
        // get filter
        $filters = $this->get_records(' tablename = "' . $table_name .
            '" OR tablename ="fs_' . $this->type . '"', 'fs_' . $this->type . '_filters',
            '*', null, null, 'id');
        // get categories
        $categories = $this->get_records('', 'fs_' . $this->type . '_categories', '*', null, null,
            'id');
        if (!count($data) || !count($filters))
            return;
        $arr_filter = array();
        $arr_filter_id_current = array();
        $arr_filter_fieldname_current = array();
        $array_exit = array();
        foreach ($data as $item)
        {
            // duyệt ko có category
            $rs = $this->genate_array_filter($arr_filter, $filters, $arr_filter_id_current,
                $arr_filter_fieldname_current, $array_exit, $item, 0);
            $arr_filter = $rs[0];
            $array_exit = $rs[1];
            if (count($categories))
            {
                foreach ($categories as $category)
                {
                    $rs = $this->genate_array_filter($arr_filter, $filters, $arr_filter_id_current,
                        $arr_filter_fieldname_current, $array_exit, $item, $category->id);
                    $arr_filter = $rs[0];
                    $array_exit = $rs[1];
                }
            }
        }
        $this->save_filter($arr_filter, $filters, $table_name, $categories);
        return true;
    }
    /*
    * sinh mang filter khong co category
    * $arr_filter_id_current : (Mảng id của các filter đang duyệt tới) có dạng:  (2,3,4)  
    * $arr_filter_fieldname_current : mảng field_name của các filter đang duyệt tới. Để tránh duyệt cùng 1 fieldname .có dạng:  ('color','body','...) 
    * $array_exit: có dạng array('0,1,2' => '2,0,1') dùng để check các filter đã duyệt. VD [1][2][3] = [2][1][3] sẽ bị trùng nhau 
    * Thay đổi sau mỗi lần đệ quy: $arr_filter,$array_exit
    */
    function genate_array_filter($arr_filter, $filters, $arr_filter_id_current, $arr_filter_fieldname_current,
        $array_exit, $record, $category_id = 0)
    {
        // check categories
        if ($category_id && !($this->check_item_in_category($category_id, $record)))
            return array(0 => $arr_filter, 1 => $array_exit);
        //			print_r($arr_filter_id_current);//,$arr_filter_fieldname_current
        //			echo "hhh";
        // check xem đã duyệt lặp ngược chưa. Nếu rồi thì ko duyệt filter con nữa
        if ($this->check_exits($array_exit, $arr_filter_id_current, $category_id))
            return array(0 => $arr_filter, 1 => $array_exit);
        $str_ids_parent = count($arr_filter_id_current) ? implode(',', $arr_filter_id_current) :
            '';
        // duyệt con
        foreach ($filters as $filter)
        {
            // khong duyệt cùng field_name
            if (in_array($filter->field_name, $arr_filter_fieldname_current))
                continue;
            $str_ids_current = $str_ids_parent ? $str_ids_parent . ',' : '';
            $str_ids_current .= $filter->id;
            if (!isset($arr_filter[$category_id][$str_ids_current]))
                $arr_filter[$category_id][$str_ids_current] = 0;
            if ($this->calculate_record_compatible_filter($record, $filter->filter_value, $filter->
                calculator, $filter->field_name))
            {
                $arr_filter[$category_id][$str_ids_current]++;
                // gọi đệ quy để duyệt con:
                $arr_filter_id_current_child = $arr_filter_id_current;
                $arr_filter_id_current_child[] = $filter->id;
                $arr_filter_fieldname_current_child = $arr_filter_fieldname_current;
                $arr_filter_fieldname_current_child[] = $filter->field_name;
                $array_exit_child = $this->generate_filter_array_exit($array_exit, $filter->id,
                    $arr_filter_id_current);
                $rs = $this->genate_array_filter($arr_filter, $filters, $arr_filter_id_current_child,
                    $arr_filter_fieldname_current_child, $array_exit, $record, $category_id);
                $arr_filter = $rs[0];
                $array_exit = $rs[1];
            }
        }
        return array(0 => $arr_filter, 1 => $array_exit);
    }
    function calculate_filter_common_for_category($data)
    {
    }
    /*
    * Kiểm tra trùng lặp khi duyệt trong trường hợp đảo duyệt. VD [1][2][3] = [2][1][3] sẽ bị trùng nhau
    * $array_exit: có dạng array('0,1,2' => '2,0,1') dùng để check các filter đã duyệt. VD [1][2][3] = [2][1][3] sẽ bị trùng nhau
    * true: đã tồn tại
    * false: chưa => phải duyệt
    */
    function check_exits($array_exit = array(), $arr_filter_id_current = array(), $category_id =
        0)
    {
        // chưa tồn tại => true
        if (!count($array_exit) || !count($arr_filter_id_current))
            return false;
        // sắp xếp lại:
        $arr_filter_id_current_sort = $arr_filter_id_current;
        ksort($arr_filter_id_current_sort);
        // chuyển qua chuỗi
        $str_filter_fieldname_current_sort = implode(',', $arr_filter_id_current_sort);
        $str_filter_fieldname_current = implode(',', $arr_filter_id_current);
        // nếu chưa tồn tại trong mảng array_exit
        if (!isset($array_exit[$category_id][$str_filter_fieldname_current_sort]))
            return false;
        // kiểm tra xem có giống mảng đang gọi ko?
        if ($array_exit[$category_id][$str_filter_fieldname_current_sort] != $str_filter_fieldname_current)
            return true;
        return false;
    }
    /*
    * Tính toán xem record này có thỏa mãn điều kiện filter đưa ra
    * record: 1 record
    * math: filter math
    * field: filter filter
    * return: yes or no
    */
    function calculate_record_compatible_filter($record, $filter_value, $math, $field)
    {
        $record_value = @$record->$field;
        $filter_value1 = '';
        $filter_value2 = '';
        if ($math > 9 && $math < 14)
        {
            $arr_value = explode(",", $filter_value, 2);
            $filter_value1 = @$arr_value[0] ? $arr_value[0] : "";
            $filter_value2 = @$arr_value[1] ? $arr_value[1] : "";
        }
        switch ($math)
        {
            case '1':
                return false;
            case '2': // LIKE
                if ($filter_value)
                {
                    if (stripos(mb_strtolower($record_value, 'UTF-8'), $filter_value) !== false)
                    {
                        return true;
                    }
                }
                return false;
            case '3': // Null
                if (!$record_value || trim($record_value) == "")
                    return true;
                return false;
            case '4':
                if (isset($item->$field) && trim($record_value) != "")
                    return true;
                return false;
            case '5': //==
                if ($record_value == $filter_value)
                    return true;
                return false;
            case '6':
                if ($record_value > $filter_value)
                    return true;
                return false;
            case '7':
                if ($record_value < $filter_value)
                    return true;
                return false;
            case '8':
                if ($record_value >= $filter_value)
                    return true;
                return false;
            case '9':
                if ($record_value <= $filter_value)
                    return true;
                return false;
            case '10':
                if ($record_value < $filter_value1 && $record_value > $filter_value2)
                    return true;
                return false;
            case '11':
                if ($record_value < $filter_value1 && $record_value >= $filter_value2)
                    return true;
                return false;
            case '12':
                if ($record_value <= $filter_value1 && $record_value > $filter_value2)
                    return true;
                return false;
            case '13':
                if ($record_value <= $filter_value1 && $record_value > $filter_value2)
                    return true;
                return false;
            case '14': //FOREIGN_ONE
                if ($record_value == $filter_value)
                {
                    return true;
                }
                return false;
            case '15': //FOREIGN_MULTI
                if ($filter_value)
                {
                    if (stripos(mb_strtolower($record_value, 'UTF-8'), $filter_value) !== false)
                    {
                        return true;
                    }
                }
                return false;
            default:
                return false;
        }
    }
    /*
    * Sinh ra mảng chứa các filter_id đã duyệt
    */
    function generate_filter_array_exit($array_exit, $filter_id, $filter_parrent_id)
    {
        $filter_parrent_current = $filter_parrent_id;
        $filter_parrent_current[] = $filter_id;
        $filter_parrent_current_sort = $filter_parrent_current;
        ksort($filter_parrent_current_sort);
        $str_filter_parrent_current_sort = implode(',', $filter_parrent_current_sort);
        // nếu tồn tại thì ko thực hiện
        if (isset($array_exit[$str_filter_parrent_current_sort]))
            return $array_exit;
        $array_exit[$str_filter_parrent_current_sort] = implode(',', $filter_parrent_current);
        return $array_exit;
    }
    /*
    * Kiểm tra xem item này có nằm trong category ko
    */
    function check_item_in_category($category_id, $record)
    {
        if (!$category_id)
            return false;
        if (stripos(mb_strtolower($record->category_id_wrapper, 'UTF-8'), ',' . $category_id .
            ',') !== false)
            return true;
        return false;
    }
    /*
    * table_name == ''? common:extend
    * $arr_filter: mảng kết quả filter sau khi tính toán
    * $filters: mảng filter lấy từ db ra để đối chiếu
    * $calculator_empty: có tính toán với biến count == 0 hay ko?
    */
    function save_filter($arr_filter, $filters, $table_name = '', $categories, $calculator_empty =
        0)
    {
        if (!count($arr_filter))
            return;
        // remove old common data
        $this->_remove('is_common = 1', 'fs_' . $this->type . '_filters_values');
        // remove old extend data
        if ($table_name)
        {
            $this->_remove('tablename = "' . $table_name . '"', 'fs_' . $this->type .
                '_filters_values');
        }
        foreach ($arr_filter as $category_id => $filters_in_cat)
        {
            if (!count($filters_in_cat))
                continue;
            $category_alias = $category_id ? $categories[$category_id]->alias : '';
            foreach ($filters_in_cat as $ids => $count)
            {
                // nếu không đếm trường hợp count == 0
                if (!$calculator_empty && !$count)
                    continue;
                $row = array();
                $arr_ids = explode(',', $ids);
                $url_id = '';
                $url_alias = '';
                $total_ids = count($arr_ids);
                $j = 0;
                for ($i = $total_ids - 1; $i >= 0; $i--)
                {
                    if ($i == ($total_ids - 1))
                    {
                        $filter_current_id = $arr_ids[$i];
                    } else
                    {
                        if (!$j)
                        {
                            $url_id .= ',';
                            $url_alias .= ',';
                        }
                        $url_id .= $arr_ids[$i] . ',';
                        $url_alias .= $filters[$arr_ids[$i]]->alias . ',';
                        $j++;
                    }
                }
                $filter_current = $filters[$filter_current_id];
                // row
                $row['category_id'] = $category_id;
                $row['category_alias'] = $category_alias;
                $row['url_ids'] = $url_id;
                $row['url_alias'] = $url_alias;
                $row['url_total_params'] = ($total_ids - 1);
                $row['record_id'] = $filter_current_id;
                $row['total'] = $count;
                $row['filter_show'] = $filter_current->filter_show;
                //					$row['tablename']  = $filter_current -> tablename;
                $row['tablename'] = $table_name;
                $row['field_name'] = $filter_current->field_name;
                $row['field_show'] = $filter_current->field_show;
                $row['alias'] = $filter_current->alias;
                $row['calculator'] = $filter_current->calculator;
                $row['calculator_show'] = $filter_current->calculator_show;
                $row['filter_value'] = $filter_current->filter_value;
                $row['published'] = $filter_current->published;
                $row['is_common'] = $filter_current->is_common;
                $row['is_condition'] = $filter_current->is_condition;
                $this->_add($row, 'fs_' . $this->type . '_filters_values');
            }
        }
    }
}
?>