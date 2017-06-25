<?php
ob_start();
session_start();
require_once "connect.php";
$res = mysqli_query($link, "SELECT * FROM users WHERE userId=".$_SESSION['user']);
$userRow = mysqli_fetch_array($res);
global $id;
$id = $userRow['userId'];



function tableGen($link, $id){
    $routesArray = [];
    $routesRes = mysqli_query($link, "SELECT * from routes");
    $index = 0;
    while($row = mysqli_fetch_assoc($routesRes)){
        $routesArray[$index] = $row;
        if ($row['user'] == $id){
            echo "<tr>";
            echo "<td>";
            echo $row['routeName'];
            echo "</td>";
            echo "<td>";
            echo $row['routeGrade'];
            echo "</td>";
            echo "<td>";
            echo $row['sentDate'];
            echo "</td>";
            echo "<td align='center'>";
            echo "<a href=";
            echo '"delete.php?id=';
            echo $row['routeId'];
            echo '">Delete</a>';
            echo "</td></tr>";
        }
        $index++;
    }
}




if( !isset($_SESSION["user"]) ){
    header("Location: index.php");
    exit;
}

if ( isset($_POST['btn-route']) ) {

    // clean user inputs to prevent sql injections
    $routeName = trim($_POST['routeName']);
    $routeName = strip_tags($routeName);
    $routeName = htmlspecialchars($routeName);

    $grade = trim($_POST['grade']);
    $grade = strip_tags($grade);
    $grade = htmlspecialchars($grade);

    $date = trim($_POST['date']);
    $date = strip_tags($date);
    $date = htmlspecialchars($date);

    // basic name validation
    if (empty($routeName)) {
        $error = true;
        $nameError = "Please enter a route name.";
    } else if (strlen($routeName) < 3) {
        $error = true;
        $nameError = "Route name must have atleat 3 characters.";
    } else if (!preg_match("/^[a-zA-Z ]+$/",$routeName)) {
        $error = true;
        $nameError = "Route name must contain alphabets and space.";
    }

    // if there's no error, add to table
    if( !$error ) {
        $routeQuery = "INSERT INTO routes(routeName,routeGrade,sentDate, user) VALUES('$routeName','$grade','$date', '$id')";
        $routeRes = mysqli_query($link, $routeQuery);
    if ($routeRes) {
        $errTyp = "success";
        $errMSG = "Route Added!  Congratulations on the send!";
        unset($routeName);
        unset($grade);
        unset($date);
        unset($id);
        unset($_POST);
        header('location:home.php');
    } else {
        $errTyp = "danger";
        $errMSG = "Something went wrong, try again later...";
        }
    }
} //close if issetPOST

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BoulderTracker</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="style.css" type="text/css" />
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $( function() {
      $( "#datepicker" ).datepicker();
    });
    </script>
</head>
<body>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Debug Box</h3>
  </div>
  <div class="panel-body">
    <p>Date: <input type="text" id="datepicker"></p>
  </div>
</div>
<div class="panel panel-primary">
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
            <th><center>Remove Route</center></th>
        </tr>
        <?php tableGen($link, $id); ?>
    </table>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h2 class="panel-title">Submit a Sent Route</h2>
    </div>
    <div class="panel-body">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
            Route Name: <input type="text" name="routeName"><br>
            Grade: <input type="text" name="grade"><br>
            Date Sent: <input type="text" name="date"><br>
            <button type="submit" value="Submit" name="btn-route">SUBMIT ROUTE</button>
        </form>
    </div>
</div>
<div class="panel panel-success">
  <div class="panel-heading">Your Climbing Statistics</div>
  <div class="panel-body">
    <p>Feature climbing stats according to your list of sent routes.</p>
  </div>
    <ul class="list-group">
      <li class="list-group-item">Your average grade is: </li>
      <li class="list-group-item">Your highest grade is: </li>
      <li class="list-group-item">Your lowest grade is: </li>
    </ul>
</div>
<div class="panel panel-danger">
  <div class="panel-heading">
<h3><a href="logout.php?logout">LOG OUT</a></h3>
  </div>


</body>
</html>
<?php ob_end_flush(); ?>