<?php

if (isset($_POST['category_id']) && isset($_POST['task_desc']) && isset($_POST['date'])) {
        $category = $_POST['category_id'];
         if (strpos($category, ':') !== false) {
             $arr = explode(':', $category);
             if(isset($arr[0])){
                    $category=$arr[0];
                }
        }
        $task = $_POST['task_desc'];
        $dueDate = $_POST['date'];

    
    require("db_creds.php");
    $conn = mysqli_connect($servername,$username,$password,$database);
    


    if(isset($_POST['priority_level'])){
        $priority = $_POST['priority_level'];
        if($category == "None"){
        $stmt = mysqli_prepare($conn,"INSERT INTO db_TaskList (t_description,due_date,p_level,t_status) VALUES (?,?,?,0)");
        mysqli_stmt_bind_param($stmt,"ssi",$task,$dueDate,$priority);
        }
        else{
        $stmt = mysqli_prepare($conn,"INSERT INTO db_TaskList (t_description,due_date, c_id,p_level,t_status) VALUES (?,?,?,?,0)");
        mysqli_stmt_bind_param($stmt,"ssii",$task,$dueDate,$category,$priority);
        }
    }
    else{
        if($category == "None"){
        $stmt = mysqli_prepare($conn,"INSERT INTO db_TaskList (t_description,due_date,t_status) VALUES (?,?,0)");
        mysqli_stmt_bind_param($stmt,"ssi",$task,$dueDate);
        }
        else{
        $stmt = mysqli_prepare($conn,"INSERT INTO db_TaskList (t_description,due_date, c_id,t_status) VALUES (?,?,?,0)");
        mysqli_stmt_bind_param($stmt,"ssi",$task,$dueDate,$category);
        }
    }
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    header("location:addTask.php");

    
} 
else {
    header("location:addTask.php");
}

?>