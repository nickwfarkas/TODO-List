<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: PUT,GET,POST,DELETE");
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    require("db_creds.php");
    $request = json_decode($postdata,true);
    $ids=$request['ids'];
    $conn = mysqli_connect($servername,$username,$password,$database);
    
    for ($i = 0; $i < count($ids); $i++) {
        $stmt = mysqli_prepare($conn,"DELETE FROM db_TaskList WHERE id=?");
        mysqli_stmt_bind_param($stmt,"i",$ids[$i]);
        mysqli_stmt_execute($stmt);
        echo sids[$i];
    }
    mysqli_close($conn);
    echo "Success";
} 
else {
    echo "Fail";
}
?>