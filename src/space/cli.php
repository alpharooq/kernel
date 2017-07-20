<?php
/*
    @author karim mohamed - komicho
    @class MyAutoLoader
    @version 1.0
*/

namespace alpharooq\kernel\space;

use alpharooq\kernel\space\out;

class call
{
    private $out;
    public function __construct ()
    {
        header('Content-Type: application/json');
        $this->out = new out();
        $this->run_func($this->getUrl());
    }
    public function getUrl(){
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return '/' .  explode(URL,$actual_link)[1];

    }
    public function run_func ($data)
    {
        $routes = include 'config/routes.php';
        
        if ( array_key_exists($data, $routes) ) {
            $station = $routes[$data]['station'];
            $function = $routes[$data]['function'];
            $method = strtoupper( $routes[$data]['method'] ); 

            if ($_SERVER['REQUEST_METHOD'] == $method) {

                $file = 'api/stations/' . $station . '.php';

                if (file_exists($file)) {
                    include $file;
                    
                    $station = 'station' . ucfirst($station);
                    
                    $obj = new $station;
                    // // call func _head
                    if ( method_exists($obj, '_head') ) {
                        $funhead = call_user_func( [ $obj, '_head' ] );
                    } else {
                        $funhead = false;   
                    }
                    // call func _server
                    if ( method_exists($obj, '_server') ) {
                        $funserver = call_user_func( [ $obj, '_server' ] );
                    } else {
                        $funserver = false;   
                    }
                    // call func _data
                    if ( method_exists($obj, '_data') ) {
                        $fundata = call_user_func( [ $obj, '_data' ] );
                    } else {
                        $fundata = false;   
                    }
                    // call func select
                    if ( method_exists($obj,$function) ) {
                        $out = call_user_func( [ $obj, $function ] );
                        if ( $fundata == false ) {
                            $out = $out;
                        } else {
                            $out = array_merge($out, $fundata);
                        }
                    } else {
                        $out = [
                            'status' => false,
                            'status_message' => 'Please check the method in station ' . $station,
                        ];
                        $funhead = false;
                        $funserver = false;
                    }
                } else {
                    $out = [
                        'status' => false,
                        'status_message' => 'Please check the station name',
                    ];
                    $funhead = false;
                    $funserver = false;
                }
             } else {
                $out = [
                    'status' => false,
                    'type' => 'Wrong in Method',
                ];
                $funhead = false;
                $funserver = false;
            }
        } else {
            $out = [
                'status' => false,
                'type' => 'not a value in routes.php file',
            ];
        }
        if ( JSONSERVER == true ) {
            if ( $funhead != false ) {
                $_out['head'] = $funhead;   
            }
            $_out['data'] = $out;
        } else {
            $_out = $out;
        }
        $this->out->json($_out, @$funserver);
    }
}
