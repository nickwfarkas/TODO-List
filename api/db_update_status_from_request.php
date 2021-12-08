<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: PUT,GET,POST,DELETE");
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    require("db_creds.php");
    $request = json_decode($postdata,true);
    $id=$request['id'];
    $status=$request['status'];
    $conn = mysqli_connect($servername,$username,$password,$database);
    $stmt = mysqli_prepare($conn,"UPDATE db_TaskList SET t_status = ? WHERE id=?");
    mysqli_stmt_bind_param($stmt,"ii", $status, $id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    echo "Success";
} 
else {
    echo "Fail";
}
?>