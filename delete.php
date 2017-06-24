<?php
ob_start();
session_start();
require_once 'connect.php';

if (!isset($_GET['id'])){
    echo "Error: No ID was given.";
    exit;
}

$res = mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
$userRow = mysql_fetch_array($res);
$id = $userRow['userId'];


$ruRes = mysql_query("SELECT user FROM routes WHERE routeId=".$_GET['id']);
$ruRow = mysql_fetch_array($ruRes);
$userId = $ruRow['user'];

if ($id == $userId){
    $delete = trim($_GET['id']);
    $delete = strip_tags($_GET['id']);
    $delete = htmlspecialchars($_GET['id']);
    $deleteRes = mysql_query("DELETE FROM routes WHERE routeId=".$delete);
    header("Location: home.php");
    echo $_GET['id'];
}
else{
$msg = 'Woah there, not your climb to delete!  Try again.';
echo '<script type="text/javascript">alert("' . $msg . '"); </script>';
header("Location: home.php");


}


