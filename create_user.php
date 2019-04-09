<?php include './config/core.php';?>
<?php
header_opts("post");
// get database connection
include_once './config/database.php';
include_once './models/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->username) && !empty($data->password)){
    $user->username = $data->username;
    $user->password = $data->password;
    $success = $user->create();
    
    if($success === true){
        res(201, "New User Created");
    } else {
        res(503, "Unable to Create New User!", $success);
    }
}else {
    res(404, "Request is incomplete.");
}

?>