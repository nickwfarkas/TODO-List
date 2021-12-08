<?php
	require("datalayer.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>View Options</title>
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
  </form>
<div class="form-group">
   <form action="/view.php?default">
    <button type="submit" class="btn btn-secondary">Default View</button>
    </form>
</div>

</body>
</html>
