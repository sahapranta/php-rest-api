<?php
// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
 
// home page url
$home_url="http://localhost:3000/";

function res($code , $data, $err = null){
    http_response_code($code);
    if (is_array($data)) {
        echo json_encode($data);
    } elseif (!$err == null) {
        echo json_encode(array("msg" => $data, "err" => $err));
    } elseif (is_string($data)) {
        echo json_encode(array("msg" => $data));
    } else {
        echo $data;
    }
}

function header_opts($opt = null){
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("x-powered-by: express@10.9.3");
    if ($opt === 'post') {
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }
    if ($opt === 'get') {
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
    }

}
?>