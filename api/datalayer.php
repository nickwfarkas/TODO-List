<?php

//Implemented to view only Parent Category
function getCategory(){
     require("db_creds.php");
  $conn = mysqli_connect($servername,$username,$password,$database);
  $query = "SELECT c_id, t_category FROM db_Category WHERE p_category IS NULL ORDER BY t_category ASC;";
  $result = mysqli_query($conn,$query);
  $relation = array();
  while ($row = mysqli_fetch_row($result)) {
      $temp = array();
      array_push($temp,$row[0],$row[1]);
      array_push($relation,$temp);
  }
  mysqli_close($conn);
  foreach ($relation as $r) {
      echo '<option value="'.$r[0].'">'. $r[1]. '</option>';
  }
}

///NOT IMPLEMENTED ANYMORE


// function getTasks(){
//     require("db_creds.php");
//  $conn = mysqli_connect($servername,$username,$password,$database);
//  $query = "SELECT id, t_category, t_description, due_date, p_level, t_status FROM db_TaskList t JOIN db_Category c WHERE t.c_id = c.c_id ORDER BY p_level ASC, due_date ASC";
//  $result = mysqli_query($conn,$query);
//  $relation = array();
//  while ($row = mysqli_fetch_row($result)) {
//      $temp = array();
//      array_push($temp,$row[0],$row[1], $row[2], $row[3], $row[4], $row[5]);
//      array_push($relation,$temp);
//  }
//  mysqli_close($conn);
//  foreach ($relation as $r) {
//      $theid=$r[0];
//      $cat=$r[1];
//      $desc=$r[2];
//      $date=$r[3];
//      $priority=$r[4];
//      $status=$r[5];
      
//      $date=date("m-d-Y", strtotime($date));
//      if($status){
//        $statustext="Completed"; //1 == Completed
//        $updatelink='<a href="db_update_status.php?id='.$theid.'&status=0">Mark Active</a>';
//      }
//      else{
//        $statustext="Active"; //0 == Active
//          $updatelink='<a href="db_update_status.php?id='.$theid.'&status=1">Mark Completed</a>';
//      }
//      echo '
//      <tr>
//      <td><a class="btn" href="db_delete_task.php?id='.$theid.'"><i class="fa fa-close" style="color:red"></i></a></td>
//         <td>'.$cat.'</td>
//         <td>'.$desc.'</td>
//         <td>'.$date.'</td>
//         <td>'.$priority.'</td>
//         <td>'.$statustext.'</td>
//         <td>'.$updatelink.'</td>
//         </tr>';
//  }
// }

 function getCategoryAndSub(){
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
  foreach ($relation as $r) {
      if(!empty($r[2])){
      echo '<option value="'.$r[0].'">'.$r[2].' - '. $r[1]. ' </option>';
  }
  else{
          echo '<option value="'.$r[0].':'. $r[1]. '">'. $r[1]. ' </option>';
  }
  }
}

 function getAllTasks($parent, $subcategory, $date){
    require("db_creds.php");
  $conn = mysqli_connect($servername,$username,$password,$database);
  
  //for parent category only 
  if(!is_null($parent)){
      if($parent == "All"){
          if($date == 'Today'){
                  $query='SELECT id, t_category, t_description, DAYNAME(due_date) as ddate, p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c WHERE (due_date = DATE(NOW()) AND t.c_id = c.c_id) ORDER BY ddate ASC, p_level ASC ;' ;
              }
              else if($date == 'Tomorrow'){
                  $query='SELECT id, t_category, t_description, DAYNAME(due_date) as ddate, p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c ON due_date = CURDATE() + INTERVAL 1 DAY WHERE (t.c_id = c.c_id) ORDER BY ddate ASC, p_level ASC';
              }
              else if($date == 'Seven Days'){
                  $query='SELECT id, t_category, t_description, DAYNAME(due_date) as ddate, p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c WHERE (due_date <= DATE(NOW() + INTERVAL 7 DAY) AND t.c_id = c.c_id) ORDER BY ddate ASC, p_level ASC ;'; 
          }
          else if($date == 'All Time'){
                  $query='SELECT id, t_category, t_description, DATE_FORMAT(due_date, "%m-%d-%Y") as ddate, p_level, t_status, p_category FROM db_TaskList t LEFT OUTER JOIN db_Category c ON t.c_id = c.c_id ORDER BY p_level ASC'; 
          }
          else{
             $query='SELECT id, t_category, t_description, due_date, p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c WHERE (t.c_id = c.c_id) ORDER BY due_date ASC, p_level ASC ;'; 
          }
      }
    else{
              if($date == 'Today'){
              $query='SELECT id, t_category, t_description, DAYNAME(due_date) as ddate, p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c ON t.c_id = c.c_id  AND due_date = DATE(NOW()) WHERE (c.p_category = "'.$parent.'" OR c.t_category = "'.$parent.'") ORDER BY due_date ASC, p_level ASC ;' ;
          }
          else if($date == 'Tomorrow'){
              $query='SELECT id, t_category, t_description, DAYNAME(due_date) as ddate, p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c ON t.c_id = c.c_id AND due_date = CURDATE() + INTERVAL 1 DAY WHERE ( c.p_category = "'.$parent.'" OR c.t_category = "'.$parent.'") ORDER BY due_date ASC, p_level ASC ;';
          }
          else if($date == 'Seven Days'){
              $query='SELECT id, t_category, t_description, DAYNAME(due_date) as ddate, p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c ON t.c_id = c.c_id WHERE (due_date <= DATE(NOW() + INTERVAL 7 DAY) AND c.p_category = "'.$parent.'" OR c.t_category = "'.$parent.'") ORDER BY due_date ASC, p_level ASC ;'; 
      }
      else if($date == 'All Time'){
              $query='SELECT id, t_category, t_description, due_date, p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c ON t.c_id = c.c_id WHERE (c.p_category = "'.$parent.'" OR c.t_category = "'.$parent.'") ORDER BY due_date ASC, p_level ASC ;'; 
      }
      else{
         $query='SELECT id, t_category, t_description, due_date, p_level, t_status FROM db_TaskList t JOIN db_Category c WHERE (due_date = DATE(NOW()) OR t_status=0) ORDER BY due_date ASC, p_level ASC ;'; 
      }
    }

  }   
  
  
  //for subcategory only
  else if(!is_null($subcategory) && !is_null($date)){
  if($date == "Today"){
              $query="SELECT id, t_category, t_description, DAYNAME(due_date), p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c WHERE (t.c_id = c.c_id AND due_date = DATE(NOW()) AND c.c_id =$subcategory ) ORDER BY due_date ASC, p_level ASC ;" ;
          }
          else if($date == "Tomorrow"){
              $query="SELECT id, t_category, t_description, DAYNAME(due_date), p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c ON t.c_id = c.c_id AND due_date = CURDATE() + INTERVAL 1 DAY WHERE(c.c_id =$subcategory) ORDER BY due_date ASC, p_level ASC;";
          }
          else if($date == "Seven Days"){
              $query="SELECT id, t_category, t_description, DAYNAME(due_date), p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c WHERE (t.c_id = c.c_id AND due_date <= DATE(NOW() + INTERVAL 7 DAY) AND c.c_id =$subcategory) ORDER BY due_date ASC, p_level ASC ;"; 
      }
      else if($date == "All Time"){
          $query="SELECT id, t_category, t_description, due_date, p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c WHERE (t.c_id = c.c_id  AND c.c_id =$subcategory) ORDER BY due_date ASC, p_level ASC ;" ;
      }
     else{
          $query="SELECT id, t_category, t_description, due_date, p_level, t_status, p_category FROM db_TaskList t JOIN db_Category c WHERE (t.c_id = c.c_id) ORDER BY due_date ASC, p_level ASC ;" ;
      }
  }
  else{
      $query = "SELECT id, t_category, t_description, DATE_FORMAT(due_date, '%m-%d-%Y') as ddate, p_level, t_status FROM db_TaskList t JOIN db_Category c on t.c_id =c.c_id WHERE (due_date <= DATE(NOW()) AND t_status=0) GROUP BY p_level ASC";
  }
  $result = mysqli_query($conn,$query);
  $relation = array();
  while ($row = mysqli_fetch_row($result)) {
      $temp = array();
      array_push($temp,$row[0],$row[1], $row[2], $row[3], $row[4], $row[5]);
      array_push($relation,$temp);
  }
  mysqli_close($conn);
    return $relation;
}

?>