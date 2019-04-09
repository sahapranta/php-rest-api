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
$both = 0;
if (isset($data->username) && !empty($data->username)) {
    $user->username = $data->username;
    $both += 1;
}
if (isset($data->password) && !empty($data->password)) {
    $user->password = $data->password;
    $both += 1;
}

if ($data->id && $data->username || $data->password) {
    $user->id = $data->id;
    if ($user->update($both)) {
        res(200, "User has been successfully updated");
    } else {
        res(503, "Unable update User!");
    }
} else {
    res(404, "Data is not sufficient");
}

?>