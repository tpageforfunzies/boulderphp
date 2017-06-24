<?php
ob_start();
session_start();
require_once "connect.php";
$res = mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
$userRow = mysql_fetch_array($res);
$id = $userRow['userId'];

function tableGen(){
    $res = mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
    $userRow = mysql_fetch_array($res);
    $id = $userRow['userId'];
    $routesArray = [];
    $routesRes = mysql_query("SELECT * from routes");
    $index = 0;
    while($row = mysql_fetch_assoc($routesRes)){
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
            echo "<td>";
            echo "<a href=";
            echo '"delete.php?id=';
            echo $row['routeId'];
            echo '">Delete</a>';
            echo "</tr>";
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
        $routeRes = mysql_query($routeQuery);
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
</head>
<body>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Debug Box</h3>
  </div>
  <div class="panel-body">

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
            <th>Remove Route</th>
        </tr>
        <?php tableGen(); ?>
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
<h3><a href="logout.php?logout">LOG OUT</a></h3>

</body>
</html>
<?php ob_end_flush(); ?>