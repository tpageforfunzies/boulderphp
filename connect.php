<?php
error_reporting( ~E_DEPRECATED & ~E_NOTICE );

define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'boulder');

global $link;
$link = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if ( !$link ) {
    die("Connection failed : " . mysqli_error($link));
}

global $routesRes;
$routesRes = mysqli_query($link, "SELECT * from routes");

global $id;
$userRes = mysqli_query($link, "SELECT * FROM users WHERE userId=".$_SESSION['user']);
$userRow = mysqli_fetch_array($userRes);
$id = $userRow['userId'];