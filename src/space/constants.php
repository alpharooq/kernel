<?php
/*
    @author karim mohamed - komicho
    @class constants
    @version 1.0
*/

namespace alpharooq\kernel\space;

class constants
{
    // function __construct
    public function __construct ()
    {
        $this->app_file();
    }
    public function app_file ()
    {
        // include file app.php in var $arrApp
        $arApp = require_once 'config/app.php';
        # defines
        // key
        @define("KEY", $arApp['key']);
        // url
        @define("URL", $arApp['url']);
        // lang
        @define("LANG", $arApp['lang']);
        // josn_server
        @define("JSONSERVER", $arApp['josn_server']);
        // # db
        // type
        @define("DB_TYPE", $arApp['db']['type']);
        // name server
        @define("DB_HOST", $arApp['db']['info']['host']);
        // username db
        @define("DB_USER", $arApp['db']['info']['user']);
        // password db
        @define("DB_PASS", $arApp['db']['info']['pass']);
        // name db
        @define("DB_NAME", $arApp['db']['info']['name']);
        
    }
}
new constants;
