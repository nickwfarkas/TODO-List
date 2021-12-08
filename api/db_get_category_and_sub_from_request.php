<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: PUT,GET,POST,DELETE");
    header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
    header('Access-Control-Allow-Credentials: true');
    
    require("db_creds.php");
    $conn = mysqli_connect($servername,$username,$password,$database);
    $query = "SELECT c_id, t_category, p_category FROM db_Category;";
    $result = mysqli_query($conn,$query);
    $relation = array();
    while ($row = mysqli_fetch_row($result)) {
      $temp = array();
      array_push($temp,$row[0],$row[1], $row[2]);
      array_push($relation,$temp);
    }
    mysqli_close($conn);
    echo json_encode($relation);
?>