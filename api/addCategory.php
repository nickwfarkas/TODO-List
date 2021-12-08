<?php
	require("datalayer.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Category</title>
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
  <h2>Add Category</h2>
  <form action="/db_add_category.php" method="post">
    <div class="form-group">
      <label for="category_name">Category:</label>
      <input type="text" class="form-control" id="category_name" placeholder="Enter Category Name" name="category_name" required>
    </div>
    <div class="form-group">
    	<label for="parent_category">Select Parent:</label>
    	 <select class="form-control" id="parent_category" name="parent_category">
    	 	<option selected="selected">None</option>
    	 	<?php getCategory();?>
    	 </select>    
    	</div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
</body>
</html>
