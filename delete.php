<?php
ob_start();
session_start();
require_once 'connect.php';

if (!isset($_GET['id'])){
    echo "Error: No ID was given.";
    exit;
}

$res = mysqli_query($link, "SELECT * FROM users WHERE userId=".$_SESSION['user']);
$userRow = mysqli_fetch_array($res);
$id = $userRow['userId'];


$ruRes = mysqli_query($link, "SELECT user FROM routes WHERE routeId=".$_GET['id']);
$ruRow = mysqli_fetch_array($ruRes);
$userId = $ruRow['user'];

if ($id == $userId){
    $delete = trim($_GET['id']);
    $delete = strip_tags($_GET['id']);
    $delete = htmlspecialchars($_GET['id']);
    $delete = mysqli_real_escape_string($link, $_GET['id']);
    $deleteRes = mysqli_query($link, "DELETE FROM routes WHERE routeId=".$delete);
    header("Location: home.php");
    echo $_GET['id'];
}
else{
$msg = 'Woah there, not your climb to delete!  Try again.';
header("Location: home.php");


}


