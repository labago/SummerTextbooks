<?php
session_start();

$decision = $_GET['add'];
$username = $_SESSION['screen_name'];
$owner = "labago";

$title = str_replace("'","", $_SESSION['title']);
$isbn = $_SESSION['isbn'];
$price = $_SESSION['price'];

$host = "books.summertextbooks.com"; 
$user = "jlane09"; 
$pass = "counter"; 
$db = "summer_books"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
		
mysql_select_db($db) or die ("Unable to select database!");

if($decision == 1){
	
$query = "INSERT INTO  `summer_books`.`User Books` (
`Title` ,
`ISBN` ,
`Price` ,
`Customer` ,
`Status` ,
`Order` ,
`Owner`
)
VALUES (
'$title',  '$isbn',  '$price',  '$username',  'False',  '0',  '$owner'
);";	
	
mysql_query($query) or die ("Error in query: $query. ".mysql_error());
	
header("Location: search.php?added=1");
	
}
else {

header("Location: search.php");
	
}
?>
