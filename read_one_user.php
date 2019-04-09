<?php include './config/core.php';?>
<?php
header_opts("get");

include_once './config/database.php';
include_once './models/user.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);

$user->id = isset($_GET['id']) ? $_GET['id'] : die();

$user->readOne();
if ($user->username != null) {
    $user_arr = array(
        "id" => $user->id,
        "username" => $user->username,
        "password" => $user->password,
        "created_at" => $user->created_at 
    );
    res(200, $user_arr);
} else {
    res(404, "User does not exist");
}

?>
