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

if (isset($data->id) && !empty($data->id) && is_numeric($data->id)) {
    $user->id = $data->id;   
    $success = $user->delete();
    if ($success === 1) {
        res(200, "User Successfully Deleted!");
    } else {
        res(503, "Unable to delete the user, ID not found!");
    }
} else {
    res(404, "Insufficient Data, Try Again!");
}

