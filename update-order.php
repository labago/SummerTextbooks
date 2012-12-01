<?php
session_start();

if(isset($_SESSION['order_num']) && isset($_SESSION['user_owner']) && isset($_SESSION['user_order'])){


$owner = $_SESSION['user_owner'];
$order_num = $_SESSION['order_num'];
$user_order = $_SESSION['user_order'];
$update = $_GET['id'];

$host = "books.summertextbooks.com"; 
$user = "jlane09"; 
$pass = "counter"; 
$db = "summer_books"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
		
mysql_select_db($db) or die ("Unable to select database!");

$query = "SELECT * 
FROM  `Orders` 
WHERE  `Customer` LIKE  '$user_order'
AND  `Number` =$order_num
LIMIT 0 , 30";

$result = mysql_query($query);

$row = mysql_fetch_row($result);

$customer = $row[0];
$date = $row[1];
$number = $row[2];
$status = $row[3];
$owner = $row[4];

// if cancelled
if($update == 2){

$message = "This email serves as a notification that the order from ".$user_order." with books listed below has been cancelled <br> <br>";

$query = "UPDATE  `summer_books`.`Orders` SET  `Status` =  'Cancelled' WHERE  
`Orders`.`Customer` =  '$customer' AND  
`Orders`.`Date` =  '$date' AND  
`Orders`.`Number` =$number AND  
`Orders`.`Status` =  '$status' AND  
`Orders`.`Owner` =  '$owner' LIMIT 1 ;";

mysql_query($query);

$query = "SELECT * 
FROM  `User Books` 
WHERE  `Customer` LIKE  '$user_order'
AND  `Order` =$order_num
LIMIT 0 , 100";

$result = mysql_query($query);

while($row = mysql_fetch_row($result)) {

$title = $row[0];
$isbn = $row[1];
$price = $row[2];
$customer = $row[3];
$status = $row[4];
$order = $row[5];
$owner = $row[6];

$message .= $title." - $".$price."<br>";

$query = "UPDATE  `summer_books`.`User Books` SET  `Status` =  'Cancelled' WHERE  
`User Books`.`Title` =  '$title' AND  
`User Books`.`ISBN` =  '$isbn' AND  
`User Books`.`Price` =  '$price' AND  
`User Books`.`Customer` =  '$customer' AND  
`User Books`.`Status` =  '$status' AND  
`User Books`.`Order` =$order AND  
`User Books`.`Owner` =  '$owner' LIMIT 1 ;";

mysql_query($query);
}

$query = "SELECT * 
FROM  `Page Owners` 
WHERE  `Username` LIKE  '$owner'
LIMIT 0 , 30";

$result = mysql_query($query);

$row = mysql_fetch_row($result);

$owner_email = $row[2];
	
$header = 'Content-type: text/html; charset=iso-8859-1'."\r\n";
$header .= 'From: order-cancel'."\r\n"; 

// send a notification to owner
mail($owner_email, "Order Cancelled", $message, $header);
	
header("Location: orders.php");	
}
}


// else error
echo "An error has occured, please go back!";
?>