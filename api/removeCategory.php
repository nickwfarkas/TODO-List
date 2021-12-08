<?php 
require("datalayer.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Remove a Category</title>
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
  <h2>Remove Category</h2>
  <form action="/db_remove_category.php" method="POST">
    <div class="form-group">
      <label for="category_id">Category:</label>
       <select class="form-control" id="category_id" name="category_id" required>
         <?php getCategoryAndSub(); ?>
       </select>    
      </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
</body>

<script>
$(document).ready(function(){
    var options = $("#category_id option");                    // Collect options         
    options.detach().sort(function(a,b) {               // Detach from select, then Sort
    var at = $(a).text();
    var bt = $(b).text();         
    return (at > bt)?1:((at < bt)?-1:0);            // Tell the sort function how to order
});
options.appendTo("#category_id");   
  });
</script>
</html>
