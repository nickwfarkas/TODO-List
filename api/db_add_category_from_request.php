<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: PUT,GET,POST,DELETE");
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata,true);
    
    $cname = $request['tCategory'];
    $pnum = $request['pCategory'];
    
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
    echo json_encode("Success");
} 
else {
    echo "Fail";
}
?>