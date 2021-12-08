<?php
if (isset($_POST['category_name']) && isset($_POST['parent_category'])) {
        $cname = $_POST['category_name'];
        $pnum = $_POST['parent_category'];
    
    require("db_creds.php");
    $conn = mysqli_connect($servername,$username,$password,$database);
    if($pnum == "None"){
        $stmt = mysqli_prepare($conn,"INSERT INTO db_Category (t_category) VALUES (?)");
        mysqli_stmt_bind_param($stmt,"s",$cname);
    }
    else{
        $q = "SELECT t_category  FROM db_Category WHERE c_id ='" . $pnum . "'";
        $result = $conn->query($q);
        $row = $result->fetch_assoc();
        $t_parent=$row["t_category"];
        $stmt = mysqli_prepare($conn,"INSERT INTO db_Category (t_category,p_category) VALUES (?,?)");
        mysqli_stmt_bind_param($stmt,"ss",$cname,$t_parent);
    }
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    header("location:addCategory.php");
    
} 
else {
    header("location:addCategory.php");
}
?>