<?php
    header('Access-Control-Allow-Origin: *');
    require("db_creds.php");
	$conn = mysqli_connect($servername,$username,$password,$database);
 	$query = "SELECT c_id, t_category FROM db_Category;";
	$result = mysqli_query($conn,$query);
	$relation = array();
	while ($row = mysqli_fetch_row($result)) {
	    $temp = array();
	    array_push($temp,$row[0],$row[1]);
	    array_push($relation,$temp);
	}
	mysqli_close($conn);
	echo json_encode($relation);
?>