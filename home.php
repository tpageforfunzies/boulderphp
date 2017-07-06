<?php
ob_start();
session_start();
require_once "connect.php";
require_once "functions.php";

if( !isset($_SESSION["user"]) ){
    header("Location: index.php");
    exit;
}
if ( isset($_POST['btn-search']) ) {
    $_SESSION['search'] = $_POST['emailSearch'];
    echo $_SESSION['search'];
    header("Location: search.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>BoulderTracker</title>
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
<div class="panel panel-info col-md-6">

    <div class="panel-heading">
        <h2 class="panel-title">Submit a Sent Route</h2>
    </div>
    <div class="panel-body">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
            Route Name: <input type="text" name="routeName"><br>
            Grade (V):
                <select id="grade" name="grade">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                    <option>13</option>
                    <option>14</option>
                    <option>15</option>
                </select><br>
            Date Sent:<input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" /><br>
            <button type="submit" value="Submit" name="btn-route">SUBMIT ROUTE</button>
        </form>
    </div>
</div>
<div class="panel panel-info col-md-6">
    <div class="panel-heading">
        <h2 class="panel-title">Search For Another Climber</h2>
    </div>
    <div class="panel-body">
     <form method="post" autocomplete="off">
            Climber's Email: <input type="text" name="emailSearch"><br>
            <button type="submit" value="Submit" name="btn-search">Search</button>
        </form>
    </div>
</div>
<div class="panel panel-primary col-md-12">
    <div class="panel-heading">
        <h3 class="panel-title">BoulderTracker</h3>
    </div>
    <div class="panel-body">
        <p>BoulderTracker will show you how hard you
        have climbed for the day and you can compare it to other days
        and the week/month/year as a whole.</p>
    </div>
    <table class="table" id="mainTable">
        <caption style="text-align:center">
            <h2>
                Your Sent Routes
            </h2>
        </caption>
        <tr>
            <th>Route/Problem Name</th>
            <th>Grade</th>
            <th>Date Sent</th>
            <th style="text-align: center;">Remove Route</th>
        </tr>
        <?php tableGen($link, $id, $routesRes); ?>
    </table>
</div>
<div class="panel panel-success col-md-6">
  <div class="panel-heading">Your Overall Climbing Statistics!</div>
  <div class="panel-body">
    <p>Featured climbing stats according to your list of sent routes.</p>
  </div>
    <ul class="list-group">
      <li class="list-group-item">Your average grade is: V<?php getAvg($link, $id, $routesRes);?>
      </li>
      <li class="list-group-item">Your highest grade is: V<?php getMax($link, $id, $routesRes);?>
      </li>
      <li class="list-group-item">Your lowest grade is: V<?php getMin($link, $id, $routesRes);?></li>
    </ul>
</div>
<div class="panel panel-success col-md-6">
  <div class="panel-heading">Filter Your Statistics!</div>
  <div class="panel-body">
    <p>Choose your time frame and find out your stats!</p>
        <form name="Filter" method="POST">
        From:
        <input type="date" name="dateFrom" value="<?php echo date('Y-m-d'); ?>" />
        <br/>
        To:   
        <input type="date" name="dateTo" value="<?php echo date('Y-m-d'); ?>" />
        <input type="submit" name="btn-filter" value="Filter"/>
        </form>
  </div>
    <ul class="list-group">
      <li class="list-group-item">Your average grade is: V<?php 
          if ( isset($_POST['btn-filter']) ) {
              filterAvg($link, $id, $routesRes);
          }
          ?>  
     </li>
      <li class="list-group-item">Your highest grade is: V<?php 
          if ( isset($_POST['btn-filter']) ) {
              filterMax($link, $id, $routesRes);
          }
          ?>  
      </li>
      <li class="list-group-item">Your lowest grade is: V<?php 
          if ( isset($_POST['btn-filter']) ) {
              filterMin($link, $id, $routesRes);
          }
          ?></li>
    </ul>
</div>
<div class="panel panel-danger col-md-12">
  <div class="panel-heading">
<h3><a href="logout.php?logout">LOG OUT</a></h3>
  </div>


</body>
</html>
<?php ob_end_flush(); ?>