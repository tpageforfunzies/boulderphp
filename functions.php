<?php
ob_start();
session_start();
error_reporting(-1);

require_once "connect.php";
require_once "home.php";

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
}

if ( isset($_POST['btn-search']) ) {
        header("Location: search.php");

    
    
}




function filterAvg($link, $id, $routesRes){
    $fromDate = ($_POST['dateFrom']);
    $toDate = ($_POST['dateTo']);
    if ($toDate > date('Y-m-d')){
        echo '<script type="text/javascript">alert("I know this is awesome, but it can\'t predict the future yet!");</script>';
    }else {
        $filterQuery = "SELECT * FROM routes WHERE sentDate BETWEEN '" . $fromDate . "' AND  '" . $toDate . "'
ORDER by routeId DESC";
    $filterRes = mysqli_query($link, $filterQuery);
    $f_avg = 0;
    $f_avgIndex = 0;
    while($filterRow = mysqli_fetch_assoc($filterRes)){
        if ($filterRow['user'] == $id){
            $f_avg += $filterRow['routeGrade'];
            $f_avgIndex++;
        }
    }
    $f_avg /= $f_avgIndex;
    echo $f_avg;
        return $fromDate;
        return $toDate;
    }
    
}
function filterMax($link, $id, $routesRes){
    $fromDate = ($_POST['dateFrom']);
    $toDate = ($_POST['dateTo']);
    if ($toDate > date('Y-m-d')){        
    }else {
    $filterQuery = "SELECT * FROM routes WHERE sentDate BETWEEN '" . $fromDate . "' AND  '" . $toDate . "'
ORDER by routeId DESC";
    $filterRes = mysqli_query($link, $filterQuery);
    $f_Max = 0;
    while($f_MaxRow = mysqli_fetch_assoc($filterRes)){
        if ($f_MaxRow['user'] == $id){
            if ($f_MaxRow['routeGrade'] >= $f_Max){
                $f_Max = $f_MaxRow['routeGrade'];
            }
        }
    }
    echo $f_Max;
    }
}
function filterMin($link, $id, $routesRes){
    $f_Min = 16;
    $fromDate = ($_POST['dateFrom']);
    $toDate = ($_POST['dateTo']);
    if ($toDate > date('Y-m-d')){        
    }
    else {
    $filterQuery = "SELECT * FROM routes WHERE sentDate BETWEEN '" . $fromDate . "' AND  '" . $toDate . "'
ORDER by routeId DESC";
    $filterRes = mysqli_query($link, $filterQuery);
    while($f_MinRow = mysqli_fetch_assoc($filterRes)){
        if ($f_MinRow['user'] == $id){
            if ($f_MinRow['routeGrade'] <= $f_Min){
                $f_Min = $f_MinRow['routeGrade'];
            }
        }
    }
    echo $f_Min;
    }
}


function getMax($link, $id, $routesRes){
    $max = 0;
    $result = mysqli_query($link, "SELECT * FROM `routes` WHERE user=".$id);
    while($maxRow = mysqli_fetch_assoc($result)){
        if ($maxRow['routeGrade'] >= $max){
                $max = $maxRow['routeGrade'];
            }
    }
    echo $max;
}


function getAvg($link, $id, $routesRes){
    $avg = 0;
    $avgIndex = 0;
    while($avgRow = mysqli_fetch_assoc($routesRes)){
        if ($avgRow['user'] == $id){
            $avg += $avgRow['routeGrade'];
            $avgIndex++;
        }
    }
    $avg /= $avgIndex;
    echo $avg;
}

function getMin($link, $id, $routesRes){
    $min = 16;
    $minRes = mysqli_query($link, "SELECT * FROM `routes` WHERE user=".$id);
    while($minRow = mysqli_fetch_assoc($minRes)){
        if ($minRow['routeGrade'] <= $min){
                $min = $minRow['routeGrade'];
            }
    }
    echo $min;
}


function tableGen($link, $id, $routesRes){
    $index = 0;
    $routesArray = [];
    $routesRes = mysqli_query($link, "SELECT * from routes");
    while($row = mysqli_fetch_assoc($routesRes)){
        $routesArray[$index] = $row;
        if ($row['user'] == $id){
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
?>