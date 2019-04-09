<?php include './config/core.php';?>
<?php
header_opts();

include_once './config/database.php';
include_once './models/user.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);
// query user

$stmt = $user->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $user_arr = array();
    $user_arr['data'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user_ind = array(
            "id" => $id,
            "username" => $username,
            "password" => $password,
            "created_at" => $created_at,
        );
        array_push($user_arr['data'], $user_ind);
    }

    res(200, $user_arr);
} else {
    res(404, array("msg" => "No user found."));
}
