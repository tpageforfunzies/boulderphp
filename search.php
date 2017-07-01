<?php
session_start();
ob_start();


require_once "connect.php";
require_once "search_functions.php";

//set and sanitize email from input
$search = $_SESSION['search'];
$search = mysqli_real_escape_string($link, $search);

//gets userId and userName of searched e-mail
$searchRes = mysqli_query($link, "SELECT * FROM users WHERE                userEmail='$search'");
$searchRow = mysqli_fetch_array($searchRes);
if (!$searchRow){
    echo '<script type="text/javascript">alert("Noone has registered with that e-mail");</script>';
    echo '<script>self.location = "home.php";</script>';
}
$searchId = $searchRow['userId'];
$searchName = $searchRow['userName'];

function searchTable($link, $id, $searchId){
    //loops through routes, printing routes with matching userId
    $index = 0;
    $searchArray = [];
    $routesRes = mysqli_query($link, "SELECT * from routes");
    while($row = mysqli_fetch_assoc($routesRes)){
        $searchArray[$index] = $row;
        if ($row['user'] == $searchId){
            echo "<tr>";
            echo "<td>";
            echo $row['routeName'];
            echo "</td>";
            echo "<td>";
            echo "V";
            echo $row['routeGrade'];
            echo "</td>";
            echo "<td>";
            echo date('m-d-Y', strtotime($row['sentDate']));
            echo "</td>";
        }
        $index++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Search Climbers</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Search And See Other Climbers' Sends!</h3>
  </div>
      <div class="panel-body">
         <button><a href='home.php'>RETURN HOME</a></button>
          <br>
          <br>
           <div class="well">
            <table class="table" id="mainTable">
                <caption style="text-align:center">
                    <h2><?php echo $searchName;?>'s Sent Routes</h2>
                </caption>
            <tr>
                <th>Route/Problem Name</th>
                <th>Grade</th>
                <th>Date Sent</th>
            </tr>
            <?php searchTable($link, $id, $searchId); ?>
            </table>
          </div>
          <br><br>
  </div>
  <div class="panel panel-success col-md-6">
  <div class="panel-heading"><?php echo $searchName; ?>'s Overall Climbing Statistics!</div>
  <div class="panel-body">
    <p>Featured climbing stats according to <?php echo $searchName; ?>'s list of sent routes.</p>
  </div>
    <ul class="list-group">
      <li class="list-group-item"><?php echo $searchName; ?>'s average grade is: V<?php getAvg($link, $searchId, $routesRes); ?>
      </li>
      <li class="list-group-item"><?php echo $searchName; ?>'s highest grade is: V<?php getMax($link, $searchId, $routesRes); ?>
      </li>
      <li class="list-group-item"><?php echo $searchName; ?>'s lowest grade is: V<?php getMin($link, $searchId, $routesRes); ?></li>
    </ul>
</div>
<div class="panel panel-success col-md-6">
  <div class="panel-heading">Filter <?php echo $searchName; ?>'s Statistics!</div>
  <div class="panel-body">
    <p>Choose your time frame and find out <?php echo $searchName; ?>'s stats!</p>
        <form name="Filter" method="POST">
        From:
        <input type="date" name="searchFrom" value="<?php echo date('Y-m-d'); ?>" />
        <br/>
        To:   
        <input type="date" name="searchTo" value="<?php echo date('Y-m-d'); ?>" />
        <input type="submit" name="search-filter" value="Filter"/>
        </form>
  </div>
  <ul class="list-group">
      <li class="list-group-item"><?php echo $searchName; ?>'s average grade is: V<?php 
          if ( isset($_POST['search-filter']) ) {
              filterAvg($link, $searchId, $routesRes);   
          }
          ?>  
     </li>
      <li class="list-group-item"><?php echo $searchName; ?>'s highest grade is: V<?php 
          if ( isset($_POST['search-filter']) ) {
              filterMax($link, $searchId, $routesRes);    
          }
          ?>  
      </li>
      <li class="list-group-item"><?php echo $searchName; ?>'s lowest grade is: V<?php 
          if ( isset($_POST['search-filter']) ) {
              filterMin($link, $searchId, $routesRes);
          }
          ?></li>
    </ul>
</div>



</body>

</html>