<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: PUT,GET,POST,DELETE");
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata,true);
    $parent = $request['parent'];
    $date = $request['date'];
    $subcategory = $request['subcategory'];

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
        $query = "SELECT id, t_category, t_description, DATE_FORMAT(due_date, '%m-%d-%Y') as ddate, p_level, t_status FROM db_TaskList t JOIN db_Category c on t.c_id =c.c_id WHERE (due_date = DATE(NOW()) OR t_status=0) ORDER BY  p_level ASC;";
    }
    $result = mysqli_query($conn,$query);
    $relation = array();
    while ($row = mysqli_fetch_row($result)) {
      $temp = array();
      array_push($temp,$row[0],$row[1], $row[2], $row[3], $row[4], $row[5]);
      array_push($relation,$temp);
    }
    mysqli_close($conn);
    echo json_encode($relation);
}
else{
    echo "Fail";
}

?>