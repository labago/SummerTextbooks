<?php
session_start();

$isbn = $_GET['isbn'];
$username = $_SESSION['screen_name'];

$host = "books.summertextbooks.com"; 
$user = "jlane09"; 
$pass = "counter"; 
$db = "summer_books"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
		
mysql_select_db($db) or die ("Unable to select database!");

$query = "SELECT * 
FROM  `User Books` 
WHERE  `ISBN` =$isbn
AND  `Customer` LIKE  '$username'
LIMIT 0 , 30";

$result = mysql_query($query);

$row = mysql_fetch_row($result);

$title = $row[0];
$price = $row[2];

$query = "DELETE FROM `summer_books`.`User Books` WHERE 
`User Books`.`Title` = '$title' AND 
`User Books`.`ISBN` = $isbn AND 
`User Books`.`Price` = '$price' AND 
`User Books`.`Customer` = '$username' 
LIMIT 1";

mysql_query($query);

header("Location: books.php");

?>