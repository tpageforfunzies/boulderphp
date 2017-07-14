<?php
session_start();
ob_start();


include "connect.php";
include "functions.php";
include "navbar.php";


//set and sanitize email from input
$search = $_SESSION['search'];
$search = mysqli_real_escape_string($link, $search);

//gets userId and userName of searched e-mail
$searchRes = mysqli_query($link, "SELECT * FROM users WHERE userEmail='$search'");
$searchRow = mysqli_fetch_array($searchRes);
if (!$searchRow) {
    echo '<script type="text/javascript">alert("No one has registered with that e-mail");</script>';
    echo '<script>self.location = "home.php";</script>';
}
$searchId = $searchRow['userId'];
$searchName = $searchRow['userName'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoulderTracker</title>
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script
            src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Search And See Other Climbers' Sends!</h3>
    </div>
    <div class="panel-body">
        <div class="well">
            <table class="table" id="mainTable">
                <caption style="text-align:center">
                    <h2><?php echo $searchName; ?>'s Sent Routes</h2>
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
            <li class="list-group-item"><?php echo $searchName; ?>'s average grade is:
                V<?php getAvg($link, $searchId, $routesRes); ?>
            </li>
            <li class="list-group-item"><?php echo $searchName; ?>'s highest grade is:
                V<?php getMax($link, $searchId, $routesRes); ?>
            </li>
            <li class="list-group-item"><?php echo $searchName; ?>'s lowest grade is:
                V<?php getMin($link, $searchId, $routesRes); ?></li>
        </ul>
    </div>
    <div class="panel panel-success col-md-6">
        <div class="panel-heading">Filter <?php echo $searchName; ?>'s Statistics!</div>
        <div class="panel-body">
            <p>Choose your time frame and find out <?php echo $searchName; ?>'s stats!</p>
            <form name="Filter" method="POST">
                From:
                <input type="date" name="dateFrom" value="<?php echo date('Y-m-d'); ?>"/>
                <br/>
                To:
                <input type="date" name="dateTo" value="<?php echo date('Y-m-d'); ?>"/>
                <input type="submit" name="search-filter" value="Filter"/>
            </form>
        </div>
        <ul class="list-group">
            <li class="list-group-item"><?php echo $searchName; ?>'s average grade is: V<?php
                if (isset($_POST['search-filter'])) {
                    filterAvg($link, $searchId, $routesRes);
                }
                ?>
            </li>
            <li class="list-group-item"><?php echo $searchName; ?>'s highest grade is: V<?php
                if (isset($_POST['search-filter'])) {
                    filterMax($link, $searchId, $routesRes);
                }
                ?>
            </li>
            <li class="list-group-item"><?php echo $searchName; ?>'s lowest grade is: V<?php
                if (isset($_POST['search-filter'])) {
                    filterMin($link, $searchId, $routesRes);
                }
                ?></li>
        </ul>
    </div>


</body>
</html>