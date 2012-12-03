<?php

$host = "books.summertextbooks.com"; 
$user = "jlane09"; 
$pass = "counter"; 
$db = "summer_books"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
		
mysql_select_db($db) or die ("Unable to select database!");

if(isset($_GET['id']))
	$email = $_GET['id'];

if(isset($_GET['id']) && !isset($_COOKIE['opt']))
{
	$query = "UPDATE `summer_books`.`Users` SET `Email Opt-Out` = 'true' 
	WHERE `Users`.`Email` = '$email' 
	LIMIT 1 ;";

	mysql_query($query);

	setcookie("opt", 1, time()+3600*24*30);
	echo "You have been unsubscribed from future emails.";
}
else
{
	echo "Either something went wrong or you are already unsubscribed.";
}
?>