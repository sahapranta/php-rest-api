<?php include './config/core.php';?>
<?php include './config/utilities.php';?>
<?php
header_opts();

include_once './config/database.php';
include_once './models/user.php';

// utilities
$utilities = new Utilities();
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 5;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

$user = new User($db);
// $keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query users
$stmt = $user->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
if($num>0){
    $user_arr=array();
    $user_arr["data"]=array();
    $user_arr["paging"]=array();
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
    // include paging
    $total_rows=$user->count();
    $page_url="{$home_url}user/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $user_arr["paging"]=$paging;
    res(200, $user_arr); 
} else {
    res(404, 'No User found');
}