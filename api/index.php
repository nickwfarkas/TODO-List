<?php
require("datalayer.php");
function tasks(){
        $tasks=getAllTasks(null, null, null); ///parent category only
    	foreach ($tasks as $r) {
	    $theid=$r[0];
	    $cat=$r[1];
	    $desc=$r[2];
	    $date=$r[3];
	    $priority=$r[4];
	    $status=$r[5];
	    
	    if($status){
	    	$statustext="Completed"; //1 == Completed
	    	$updatelink='<a href="db_update_status.php?id='.$theid.'&status=0">Mark Active</a>';
	    }
	    else{
	    	$statustext="Active"; //0 == Active
	        $updatelink='<a href="db_update_status.php?id='.$theid.'&status=1">Mark Completed</a>';
	    }
	    echo '
	    <tr>
        <td>'.$cat.'</td>
        <td>'.$desc.'</td>
        <td>'.$date.'</td>
        <td>'.$priority.'</td>
        <td>'.$statustext.'</td>
        <td>'.$updatelink.'</td>
        </tr>';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php include("navbar.php");?>

<div class="container-fluid">
<h3 class="text-center">TASKS</h3>
<table class="table">
    <thead>
      <tr>
        <th>CATEGORY</th>
        <th>TASK</th>
        <th>DUE DATE</th>
        <th>PRIORITY LEVEL</th>
        <th>STATUS</th>
        <th>CHANGE STATUS</th>
      </tr>
    </thead>
    <tbody>
      <!--<tr style="color: red">-->
      <!--  <td><a class="btn" href="#"><i class="fa fa-close" style="color:red"></i></a></td>-->
      <!--  <td>Homework</td>-->
      <!--  <td>Feed the dog</td>-->
      <!--  <td>11/21/25</td>-->
      <!--  <td>1</td>-->
      <!--  <td>Active</td>-->
      <!--  <td><a href="#">Mark Completed</a></td>-->
      <!--</tr>-->
      <!--<tr style="color: red">-->
      <!--  <td><a class="btn" href="#"><i class="fa fa-close" style="color:red"></i></a></td>-->
      <!--  <td>Housework</td>-->
      <!--  <td>First step</td>-->
      <!--  <td>11/25/25</td>-->
      <!--  <td>4</td>-->
      <!--  <td>Active</td>-->
      <!--  <td><a href="#">Mark Completed</a></td>-->
      <!--</tr>-->
      <?php tasks();?>
    </tbody>
  </table>
</body>
</html>
