<?php
class FSFactory
{
    var $className = "";
    public static function getClass($className, $folder = "", $prefix = '')
    {
        $className = strtolower($className);
        if ($folder)
        {
            require_once $folder . '/' . $className . '.php';
        } else
        {
            require_once $className . '.php';
        }
        $ob = new $className();
        return $ob;
    }
    public static function include_class($className, $folder = "", $prefix = '')
    {
        $className = strtolower($className);
        if ($folder)
        {
            require_once $folder . '/' . $className . '.php';
        } else
        {
            require_once $className . '.php';
        }
    }
}