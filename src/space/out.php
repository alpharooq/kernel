<?php
/*
    @author karim mohamed - komicho
    @class MyAutoLoader
    @version 1.0
*/

namespace alpharooq\kernel\space;

class out
{
    // function construct 
    public function json ($out, $funserver = false)
    {
        if ( JSONSERVER == true ) {
            $out['server'] = [
                'code' => http_response_code(),
                'status' => true,
                'status_message' => 'called function',
                'server_time' => time(),
            ];   
            if ( $funserver != false ) {
                $out['server'] = array_merge($out['server'], $funserver);
            } else {
                $out['server'];
            }
        }
        echo json_encode($out);
    }
}
