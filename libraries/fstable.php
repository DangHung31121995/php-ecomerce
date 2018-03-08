<?php
class FSTable
{
    function __construct()
    {
    }
    public function _($table, $multi_lang = 0)
    {
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
        if (!$multi_lang || $lang == 'vi')
            return $table;
        return $table . '_' . $lang;
    }
    public function getTable($table, $multi_lang = 0)
    {
        if (!$multi_lang)
            return $table;
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
        return $table . '_' . $lang;
    }
}
?>