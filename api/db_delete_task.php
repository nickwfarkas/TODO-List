<?php

if (isset($_GET['id'])) {
    require("db_creds.php");
    $id=$_GET['id'];
    $ref=$_SERVER['HTTP_REFERER'];
    $conn = mysqli_connect($servername,$username,$password,$database);
    $stmt = mysqli_prepare($conn,"DELETE FROM db_TaskList WHERE id=?");
    mysqli_stmt_bind_param($stmt,"i",$id);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    header("location:view.php?id=$ref");
    
} 
else {
    header("location:view.php?");
}
?>