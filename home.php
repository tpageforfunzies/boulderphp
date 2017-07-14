<?php
ob_start();
session_start();
include "connect.php";
include "functions.php";
include "navbar.php";


if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}
if (isset($_POST['btn-search'])) {
    $_SESSION['search'] = $_POST['emailSearch'];
    echo $_SESSION['search'];
    header("Location: search.php");
}
?>

    <!DOCTYPE html>
    <html>

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

    <div id="mainTable" class="panel panel-primary col-md-12">
        <div class="panel-body">
            <h4 style="text-align:center">BoulderTracker will show you how hard you
                have climbed for the day and you can compare it to other days
                and the week/month/year as a whole.</h4>
        </div>
        <table class="table" id="mainTable">
            <caption class="topCaption">
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

    <div id="overallPanel" class="panel panel-success col-md-6">
        <div id="overallHead" class="panel-heading">Your Overall Climbing Statistics!</div>
        <div class="panel-body">
            <p>Featured climbing stats according to your list of sent routes.</p>
        </div>
        <ul id="overallList" class="list-group">
            <li id="overallList" class="list-group-item">Your average grade is:
                V<?php getAvg($link, $id, $routesRes); ?>
            </li>
            <li id="overallList" class="list-group-item">Your highest grade is:
                V<?php getMax($link, $id, $routesRes); ?>
            </li>
            <li id="overallList" class="list-group-item">Your lowest grade is:
                V<?php getMin($link, $id, $routesRes); ?></li>
        </ul>
    </div>

    <div id="filterPanel" class="panel panel-success col-md-6">
        <div id="filterHead" class="panel-heading">Filter Your Statistics!</div>
        <div class="panel-body">
            <p>Choose your time frame and find out your stats!</p>
            <form id="filterForm" name="Filter" method="POST">
                <span id="filterInput">From:</span>
                <input type="date" name="dateFrom" value="<?php echo date('Y-m-d'); ?>"/>
                <br/>
                <span id="filterInput">To:</span>
                <input type="date" name="dateTo" value="<?php echo date('Y-m-d'); ?>"/>
                <input type="submit" name="btn-filter" value="Filter"/>
            </form>
        </div>
        <ul class="list-group">
            <li id="filterList" class="list-group-item">Your average grade is: V<?php
                if (isset($_POST['btn-filter'])) {
                    filterAvg($link, $id, $routesRes);
                }
                ?>
            </li>
            <li id="filterList" class="list-group-item">Your highest grade is: V<?php
                if (isset($_POST['btn-filter'])) {
                    filterMax($link, $id, $routesRes);
                }
                ?>
            </li>
            <li id="filterList" class="list-group-item">Your lowest grade is: V<?php
                if (isset($_POST['btn-filter'])) {
                    filterMin($link, $id, $routesRes);
                }
                ?>
            </li>
        </ul>
    </div>

    </body>
    </html>
<?php ob_end_flush(); ?>