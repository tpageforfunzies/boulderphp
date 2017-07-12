<?php
session_start();
include "connect.php";
include "home.php";

if (!isset($_GET['id'])){
    echo "Error: No ID was given.";
    exit;
}


$routeId = mysqli_real_escape_string($link, $_GET['id']);
$ruRes = mysqli_query($link, "SELECT user FROM routes WHERE routeId=".$routeId);
$ruRow = mysqli_fetch_array($ruRes);
$userId = $ruRow['user'];

if ($id == $userId){
    $delete = mysqli_real_escape_string($link, $_GET['id']);
    $delete = trim($_GET['id']);
    $delete = strip_tags($_GET['id']);
    $delete = htmlspecialchars($_GET['id']);
    $deleteRes = mysqli_query($link, "DELETE FROM routes WHERE routeId=".$delete);
    header("Location: home.php");
    echo $_GET['id'];
}
else{
    echo '<script type="text/javascript">alert("Not your climb to delete! Nice try.");</script>';
    echo '<script>self.location = "home.php";</script>';
}
?>