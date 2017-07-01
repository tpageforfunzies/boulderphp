<?php
error_reporting(-1);
ob_start();



function getMax($link, $id, $routesRes){
    $max = 0;
    $result = mysqli_query($link, "SELECT * FROM `routes` WHERE user=".$id);
    while($maxRow = mysqli_fetch_assoc($result)){
        if ($maxRow['routeGrade'] >= $max){
                $max = $maxRow['routeGrade'];
            }
    }
    if ($max > 0){
        echo $max; 
    }
    else {
        echo " - They haven't logged any climbs yet.";
    }
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
    if ($avgIndex > 0){
        $avg /= $avgIndex;
        echo $avg; 
    }
    else {
        echo " - They haven't logged any climbs yet.";
    }
}

function getMin($link, $id, $routesRes){
    $min = 16;
    $minRes = mysqli_query($link, "SELECT * FROM `routes` WHERE user=".$id);
    while($minRow = mysqli_fetch_assoc($minRes)){
        if ($minRow['routeGrade'] <= $min){
                $min = $minRow['routeGrade'];
            }
    }
    if ($min < 16){
        echo $min; 
    }
    else {
        echo " - They haven't logged any climbs yet.";
    }
}
function filterAvg($link, $id, $routesRes){
    $fromDate = ($_POST['searchFrom']);
    $toDate = ($_POST['searchTo']);
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
    $fromDate = ($_POST['searchFrom']);
    $toDate = ($_POST['searchTo']);
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
    $fromDate = ($_POST['searchFrom']);
    $toDate = ($_POST['searchTo']);
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


?>