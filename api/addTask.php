<?php 
require("datalayer.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add a Task</title>
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
  <h2>Add Task</h2>
  <form action="/db_add_task.php" method="POST">
    <div class="form-group">
      <label for="category_id">Category:</label>
       <select class="form-control" id="category_id" name="category_id" required>
          <option selected>None</option>
         <?php getCategoryAndSub(); ?>
       </select>    
      </div>
    <div class="form-group">
      <label for="task_desc">Task Description:</label>
      <input type="text" class="form-control" id="task_desc" placeholder="Enter Task Description" name="task_desc" required>
    </div>
    <div class="form-group">
      <label class="control-label" for="date">Date</label>
      <input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" type="date" required/>
    </div>
    <div class="form-group">
      <label for="priority_level">Priority Level:</label>
       <select class="form-control" id="priority_level" name="priority_level">
         <option>1</option>
         <option>2</option>
         <option>3</option>
         <option>4</option>
       </select>    
      </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
</body>

<script>
$(document).ready(function(){
    var options = $("#category_id option"); 
    options.detach().sort(function(a,b) {
    var at = $(a).text();
    var bt = $(b).text();         
    return (at > bt)?1:((at < bt)?-1:0); 
});
options.appendTo("#category_id");   
  });
</script>
</html>
