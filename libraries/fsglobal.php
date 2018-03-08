<?php
class FsGlobal
{
    function __construct()
    {
        
    }
    function getConfig($name)
    {
        $fstable = FSFactory::getClass('fstable');
        global $db;
        $sql = " SELECT value FROM " . $fstable->_('fs_config') . " WHERE name = '$name' ";
        $db->query($sql);
        return $db->getResult();
    }
    function get_all_config()
    {
        global $db;
        $fstable = FSFactory::getClass('fstable');
        $sql = " SELECT * FROM " . $fstable->_('fs_config') . "
				WHERE is_common = 1
			 ";
        $db->query($sql);
        $list = $db->getObjectList();
        $array_config = array();
        foreach ($list as $item){
            $array_config[$item->name] = $item->value;
        }
        return $array_config;
    }
}