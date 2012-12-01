<?php 

$owner = "labago";

if(isset($_GET['ship'])){
if($_GET['ship'] == 'true'){
$ship_page = true;
}
else {
$ship_page = false;	
}	
}

include("header2.php"); 
$username = $_SESSION['screen_name'];
?>
<h1>Thank You!</h1>
<br>
<?php

if($_SESSION['logged_in'] == 1){
if(isset($_SESSION['confirmed'])){
	
	unset($_SESSION['confirmed']);

$payment = $_SESSION['payment'];

$query = "SELECT * 
FROM  `Orders` 
WHERE  `Customer` LIKE  '$username'
AND  `Owner` LIKE  '$owner'
LIMIT 0 , 30";

$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error()); 

$real_order = (mysql_num_rows($result) + 1);

$query = "SELECT * 
FROM  `User Books` 
WHERE  `Customer` LIKE  '$username'
AND  `Owner` LIKE  '$owner'
LIMIT 0 , 30";

// execute query 
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error()); 

$message = "The book(s) that you are selling to us include the following: <br> <br>";
$total = 0.0;

// see if any rows were returned 
if (mysql_num_rows($result) > 0) { 
    // yes 
    // print them one after another 
    while($row = mysql_fetch_row($result)) {
      if($row[4] == "False"){
      $total += ($row[2]);
      	
$title = $row[0];
$ISBN = $row[1];
$price = $row[2];
$cust = $row[3];
$sold = $row[4];
$order = $row[5];     	
     	
$query = "UPDATE  `summer_books`.`User Books` SET  `Status` =  'Ordered',
`Order` =  '$real_order' WHERE  
`User Books`.`Title` =  '$title' AND  
`User Books`.`ISBN` =$ISBN AND  
`User Books`.`Price` =  '$price' AND  
`User Books`.`Customer` =  '$cust' AND  
`User Books`.`Status` =  '$sold' AND  
`User Books`.`Order` =$order AND
`User Books`.`Owner` =  '$owner' LIMIT 1 ;";

mysql_query($query);      	
      	
$message = $message.$title." - $".$price."<br>";
        }
    }
    
    if(isset($ship_page) && $ship_page){
    if($total < 50.00){
    $ship_total = 3.99;
    }
    else {
    $ship_total = 7.99;	
    }
    $total += $ship_total;
    }
    else {
    $ship_total = '0.00';	
    }    
    

$query = "INSERT INTO  `summer_books`.`Orders` (
`Customer` ,
`Date` ,
`Number`,
`Status`,
`Owner`,
`Shipping`
)
VALUES (
'$username', 
CURRENT_TIMESTAMP ,  '$real_order' , 'In Progress' , '$owner', '$ship_total'
);";

mysql_query($query);      	

$query = "SELECT * 
FROM  `Users` 
WHERE  `Username` LIKE  '$username'
AND  `Owner` LIKE  '$owner'
LIMIT 0 , 30";

$result = mysql_query($query);

$row = mysql_fetch_row($result);

$user_email = $row[2];

$query = "SELECT * 
FROM  `Page Owners` 
WHERE  `Username` LIKE  '$owner'
LIMIT 0 , 30";

$result = mysql_query($query);

$row = mysql_fetch_row($result);

$owner_email = $row[2];
$site_name = $row[8];

$fname = $row[0];
$lname = $row[1];
$state = $row[5];
$city = $row[6];
$address = $row[9];
$zip = $row[10];


if(isset($ship_page) && $ship_page){
$shipping_choice = "You have been given $".$ship_total." for shipping, please ship to the address below: <br> <br>".
                    $fname." ".$lname."<br>".
                    $address."<br>".
                    $city.", ".$state." ".$zip."<br>";
}
else {
$shipping_choice = "You will be contacted soon to set up a meeting arrangement."; 	
}

$message = $message."<br> The total comes to $".$total.", and you have selected ".$payment." as your payment method. ".$shipping_choice;
$message = $message."<br> <br> You can view your order <a href=\"http://www.summertextbooks.com/orders.php\">Here</a>";
$header = 'Content-type: text/html; charset=iso-8859-1'."\r\n";
$header .= 'From: confirmation'."\r\n"; 

// send a notification to user
mail($user_email, "Your Order Confirmation", $message, $header);

$message = '"'.$message.'" <br> <br>'.'The above message has been sent to '.$username.'. You should respond soon';
 
// send a notification to site owner
mail($owner_email, "New Order!", $message, $header);

	
echo "Thank you for your order, you can view it <a href='orders.php'>Here</a>. A confirmation email has been sent to your inbox and you will be contacted shortly, thanks so much for using localbookbuyback.com";
        
}    
       
}
else {

   echo "An error has occured, please go back to the homepage <a href='index.php'><font color='3399FF'>here</font></a>";
	
}
}
else {

echo "Please <a href='login.php'><font color='3399FF'>login</font></a> or <a href='sign-up.php'><font color='3399FF'>sign up</font></a> to view this page";	
	
}  

include("footer2.php"); 
?>
