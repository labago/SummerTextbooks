<?php

session_start();

$_SESSION['confirmed'] = "confirmed";
$_SESSION['payment'] = $_POST['payment'];


if(!(strlen($_POST['payment']) > 0)){
if($_GET['ship'] == 'true'){
$location = "sell.php?ship=true&error=true";
}
else {
$location = "sell.php?error=true";
}	
}
else {
if($_GET['ship'] == 'true'){
$location = "confirm.php?ship=true";
}
else {
$location = "confirm.php";
}
}

header("Location: ".$location);



?>
