<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: PUT,GET,POST,DELETE");
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
        $request = json_decode($postdata,true);
        $category = $request['categoryID'];
         if (strpos($category, ':') !== false) {
             $arr = explode(':', $category);
             if(isset($arr[0])){
                    $category=$arr[0];
                }
        }
        $task = $request['taskDescription'];
        $dueDate = $request['dueDate'];

    
    require("db_creds.php");
    $conn = mysqli_connect($servername,$username,$password,$database);
    if(isset($request['priority'])){
        $priority = $request['priority'];
        $stmt = mysqli_prepare($conn,"INSERT INTO db_TaskList (t_description,due_date, c_id,p_level,t_status) VALUES (?,?,?,?,0)");
        mysqli_stmt_bind_param($stmt,"ssii",$task,$dueDate,$category,$priority);
    }
    else{
        $stmt = mysqli_prepare($conn,"INSERT INTO db_TaskList (t_description,due_date, c_id,t_status) VALUES (?,?,?,0)");
        mysqli_stmt_bind_param($stmt,"ssi",$task,$dueDate,$category);
    }
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    echo json_encode("Success");
    // header("location:addTask.php");
} 
else {
    echo empty($postdata);
    echo json_encode("Fail");
    // header("location:addTask.php");
}

?>