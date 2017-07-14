<?php
/*
    @author karim mohamed - komicho
    @class model
    @version 1.0
*/
namespace alpharooq\kernel\space;

use alpharooq\orm;

class model
{
    // function Medoo db
    protected function db ()
    {
        // get name table from name model
        $name = get_class($this);
        $name = substr($name,5);
        $name = strtolower($name);
        // obj orm
        $db = new orm(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        return $db->table($name);
    }
    // function run model
    public static function get ($model,$data = false)
    {
        // extraction function name
        $nameFunc = explode('@',$model);
        // path file
        $file = 'api/models/' . $nameFunc[0] . '.php';
        // if exists model file
        if (file_exists($file)) {
            // include file
            require_once $file;
            // merge obj name
            $object = 'model' . ucfirst($nameFunc[0]);
            $obj = new $object;
            // check from data
            if ($data == false) {
                // run function without data
                return call_user_func([$obj, $nameFunc[1]]);
            } else {
                // run function by data
                return call_user_func_array([$obj, $nameFunc[1]],$data);
            }
        } else {
            die(json_encode([
                    'status' => false,
                    'status_message' => 'Please check the model name ' . $nameFunc[0],
                ]));
        }
    }
}
