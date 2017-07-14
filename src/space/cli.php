<?php

namespace alpharooq\kernel\space;

class cli
{
    public function init ()
    {
        self::build_htaccess();
        echo 'We\'re ready :)' . PHP_EOL;
    }
    public function build_htaccess ()
    {
        $file = fopen('.htaccess', "w") or die("Unable to open file!");
        if ( NAMESCRIPT == 'space' ) {
        $txt = "RewriteEngine On
 
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteCond %{SCRIPT_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !-l

RewriteRule ^(.*)$ index.php?function=$1 [QSA,L]
RewriteRule api index.php
RewriteRule bin index.php
RewriteRule config index.php
RewriteRule vendor index.php
##################### Header #####################
# Header always append X-Frame-Options SAMEORIGIN";
        }
        fwrite($file, $txt);
        fclose($file);
    }

    // function make new station
    public function mk_station ($array)
    {
        // var path controller
        $filePath = 'api/stations/' . $array[0] . '.php';
        // exist controller
        if (!file_exists($filePath)) {
            // code in file
            $file = fopen($filePath, "w") or die("Unable to open file!");
            $txt = "<?php

use alpharooq\kernel\space\model;
use alpharooq\kernel\space\station;

class station" . ucfirst($array[0]) . " extends station
{
    public function __construct ()
    {}
}";
            fwrite($file, $txt);
            fclose($file);
            // print
            echo 'The station is built' . PHP_EOL;
        } else {
            // print
            echo 'The station already exists' . PHP_EOL;
        }
    }
    // function make new station
    public function mk_model ($array)
    {
        // var path controller
        $filePath = 'api/models/' . $array[0] . '.php';
        // exist controller
        if (!file_exists($filePath)) {
            // code in file
            $file = fopen($filePath, "w") or die("Unable to open file!");
            $txt = "<?php

use alpharooq\kernel\space\model;

class model" . ucfirst($array[0]) . " extends model
{
    public function __construct ()
    {}
}";
            fwrite($file, $txt);
            fclose($file);
            // print
            echo 'The model is built' . PHP_EOL;
        } else {
            // print
            echo 'The model already exists' . PHP_EOL;
        }
    }
    public function serve ()
    {
        echo 'http://localhost:8808/' . PHP_EOL;
        exec('php -S localhost:8808');
    }
}
