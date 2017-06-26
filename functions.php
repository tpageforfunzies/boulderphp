<?php
ob_start();
session_start();
error_reporting(-1);

require_once "connect.php";
require_once "home.php";

function getAvg($link, $id, $routesRes){
    $avg = 0;
    $avgIndex = 0;
    while($avgRow = mysqli_fetch_assoc($routesRes)){
        $avgArray[$avgIndex] = $avgRow;
        if ($avgRow['user'] == $id){
            $avg += $avgRow['routeGrade'];
            $avgIndex++;
        }
    }
    $avg /= $avgIndex;
    echo $avg;
}

//function getMin($link, $id, $routesRes){
//    $minVal = 0;
//    $minIndex = 0;
//    $minArray = [];
//    while($minRow = mysqli_fetch_assoc($routesRes)){
//        if ($minRow['user'] == $id){
//        }
//            
//
//    }
//    echo $minVal;
//}
//
//function getMax($link, $id, $routesRes){
//    $max = 0;
//    $maxIndex = 0;
//    while($avgRow = mysqli_fetch_assoc($routesRes)){
//        $maxArray[$maxIndex] = $avgRow;
//        if ($maxRow['user'] == $id){
//            if ($max <= $maxRow[$maxIndex]['routeGrade']){
//                $max = $maxRow[$maxIndex]['routeGrade'];
//            }
//        }
//        $maxIndex++;
//        echo $max;
//        print_r($maxArray);
//    }
//
//}
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
?>