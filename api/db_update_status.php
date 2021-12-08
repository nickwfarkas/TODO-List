<?php

if (isset($_GET['id']) && isset($_GET['status'])) {
    require("db_creds.php");
    $id=$_GET['id'];
    $status=$_GET['status'];
    $ref=$_SERVER['HTTP_REFERER'];
    $conn = mysqli_connect($servername,$username,$password,$database);
    $stmt = mysqli_prepare($conn,"UPDATE db_TaskList SET t_status = ? WHERE id=?");
    mysqli_stmt_bind_param($stmt,"ii", $status, $id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    header("location:$ref");
    
} 
else {
    header("location:view.php?");
}
?>