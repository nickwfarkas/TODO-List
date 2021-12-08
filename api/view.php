<?php 
require("datalayer.php");

function tasks(){
    if (isset($_GET)) {
        if(isset($_GET['view_date']) && isset($_GET['category_type'])){
            $date=$_GET['view_date'];
            $category=$_GET['category_type'];
            //used for to get only parent category tasks or subcategories task
            //when submitted with category only (ex. Homework --- 4:Homework is submited )
            //when submitted subcategory(ex. CSC 4710- Homework ---- 5 is submitted)
            
            if($category == "All"){
               $tasks=getAllTasks("All", null, $date); ///parent category only
            }
            else if (strpos($category, ':') !== false) {
            $arr = explode(':', $category);
                if(isset($arr[0])){
                    $sub=$arr[0];
                    $p=$arr[1];
                    $tasks=getAllTasks($p, $sub, $date); ///parent category only
                }
            }
            else{
                    $tasks=getAllTasks(null, $category, $date); //subcategory only
            }
        }
        else{
             $tasks=getAllTasks(null, null, null); ///parent category only
        }
        
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
	    
	    if($cat){
	      $catname=$cat; 
	    }
	    else{
	        $catname="None";
	    }
	    echo '
	    <tr>
        <td>'.$catname.'</td>
        <td>'.$desc.'</td>
        <td>'.$date.'</td>
        <td>'.$priority.'</td>
        <td>'.$statustext.'</td>
        <td>'.$updatelink.'</td>
        </tr>';
	}
}
}
?>

<html lang="en">
<head>
  <title>Task View</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php include("navbar.php");?>


<div class="container">
    
    <div class="container">
  <h2>Select A View</h2>
  <form action="/view.php">
    <div class="form-group">
    	<label for="category_type">Select Category:</label>
    	 <select class="form-control" id="category_type" name="category_type">
    	 	<option selected="selected">All</option>
         <?php getCategoryAndSub(); ?>
    	 </select>
    	 </div>
        <div class="form-group">
    	<label for="view_date">View Tasks Due:</label>	 
    	 <select class="form-control" id="view_date" name="view_date">
            <option>All Time</option>
            <option>Today</option>
            <option>Tomorrow</option>
            <option>Seven Days</option>
    	 </select>
    	</div>
    <button type="submit" class="btn btn-primary">Submit View</button>
    <a href="/view.php?default" class="btn btn-secondary">Default View</a>
  </form>
</div>
<br>
<br>
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
</div>
</body>
</html>