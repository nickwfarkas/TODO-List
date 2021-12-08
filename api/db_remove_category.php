<?php
if (isset($_POST['category_id'])) {
    require("db_creds.php");
    $category=$_POST['category_id'];
    $conn = mysqli_connect($servername,$username,$password,$database);
    if (strpos($category, ':') !== false) {
            $arr = explode(':', $category);
                if(isset($arr[0])){
                    $sub=$arr[0];
                    $p=$arr[1];
         $stmt = mysqli_prepare($conn, 'UPDATE db_TaskList JOIN db_Category ON db_TaskList.c_id = db_Category.c_id SET db_TaskList.c_id = NULL WHERE (db_Category.p_category = ? OR db_Category.t_category = ?);');
        mysqli_stmt_bind_param($stmt,"ss", $p , $p);
        
        $stmt2 = mysqli_prepare($conn,'DELETE FROM db_Category WHERE(db_Category.p_category = ? OR db_Category.t_category = ?);');
        mysqli_stmt_bind_param($stmt2,"ss", $p , $p);
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_execute($stmt2);
        mysqli_close($conn);
        
        
    // mysqli_stmt_execute($stmt);
    // mysqli_close($conn);
    header("location:removeCategory.php?insieifdidworkk.php");
        }
        
       
    }
    else{
        $stmt = mysqli_prepare($conn,"UPDATE db_TaskList SET c_id = NULL WHERE c_id = ?;");
        mysqli_stmt_bind_param($stmt,"i",$category);
        $stmt2 = mysqli_prepare($conn,"DELETE from db_Category WHERE c_id=?;");
        mysqli_stmt_bind_param($stmt2,"i",$category);
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_execute($stmt2);
        mysqli_close($conn);
        header("location:removeCategory.php?insieelsestatementworked.php");

    }

    
} 
else {
    header("location:removeCategory.php?didntwork.php");
}
?>