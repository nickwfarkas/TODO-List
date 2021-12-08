<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: PUT,GET,POST,DELETE");
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata,true);
    require("db_creds.php");
    $category=$request['id'];
    $conn = mysqli_connect($servername,$username,$password,$database);
    if (strpos($category, ':') !== false) {
            $arr = explode(':', $category);
                if(isset($arr[0])){
                    $sub=$arr[0];
                    $p=$arr[1];
                }
         $stmt = mysqli_prepare($conn, 'UPDATE db_TaskList JOIN db_Category ON db_TaskList.c_id = db_Category.c_id SET db_TaskList.c_id = NULL WHERE (db_Category.p_category = ? OR db_Category.t_category = ?);');
        mysqli_stmt_bind_param($stmt,"ss", $p , $p);
        
        $stmt2 = mysqli_prepare($conn,'DELETE FROM db_Category WHERE(db_Category.p_category = ? OR db_Category.t_category = ?);');
        mysqli_stmt_bind_param($stmt2,"ss", $p , $p);
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_execute($stmt2);
        mysqli_close($conn);
    }
    else{
        $stmt = mysqli_prepare($conn,"UPDATE db_TaskList SET c_id = NULL WHERE c_id = ?;");
        mysqli_stmt_bind_param($stmt,"i",$category);
        $stmt2 = mysqli_prepare($conn,"DELETE from db_Category WHERE c_id=?;");
        mysqli_stmt_bind_param($stmt2,"i",$category);
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_execute($stmt2);
        mysqli_close($conn);
    }
    echo json_encode("Success");
}
else {
    echo json_encode("Fail");
}

?>