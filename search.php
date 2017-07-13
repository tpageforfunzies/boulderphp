<?php
session_start();
ob_start();


include "connect.php";
include "functions.php";

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


<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">BoulderTracker!</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Submit a Route! <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <form class="navbar-form navbar-left" method="post"
                              action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
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
                            Date Sent:<input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"/><br>
                            <button type="submit" value="Submit" name="btn-route">SUBMIT ROUTE</button>
                        </form>
                    </ul>
                </div>

                <div class="btn-group">

                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true">
                        Search Climbers! <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            <form method="post" autocomplete="off">
                                Climber's Email: <input type="text" name="emailSearch"><br>
                                <button type="submit" value="Submit" name="btn-search">Search</button>
                            </form>
                        </li>
                    </ul>
                    <button type="button" class="btn btn-danger"><a href="logout.php?logout">LOG OUT</a></button>
                    <button type="button" class="btn btn-warning"><a href='home.php'>RETURN HOME</a></button>
</nav>


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