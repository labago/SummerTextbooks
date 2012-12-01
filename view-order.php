<?php 

include("header2.php"); 

$username = $_SESSION['screen_name'];
$owner = "labago";
$order_num = $_GET['id'];

$query = "SELECT * 
FROM  `Orders` 
WHERE  `Customer` LIKE  '$username'
AND  `Number` =$order_num
AND  `Owner` LIKE  '$owner'
LIMIT 0 , 30";

$host = "books.summertextbooks.com"; 
$user = "jlane09"; 
$pass = "counter"; 
$db = "summer_books"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
		
mysql_select_db($db) or die ("Unable to select database!");

$result = mysql_query($query);

$row = mysql_fetch_row($result);

$date = date('M j, Y g:i A', strtotime($row[1]));
$status = $row[3];
$ship_cost = $row[5];

if($ship_cost != '0.00' && $ship_cost != '0'){
$ship_page = true;	
}
else {
$ship_page = false;	
}

?>
<h1>Your Order</h1>
<h2> Order  #<?php echo $order_num; ?> <br> Status: <?php echo $status; ?> <br> Made on <?php echo $date; ?> </h2>
<?php 

$_SESSION['order_num'] = $order_num;
$_SESSION['user_order'] = $username;
$_SESSION['user_owner'] = $owner;

if(isset($order_num)){
$query = "SELECT * 
FROM  `User Books` 
WHERE  `Customer` LIKE  '$username'
AND  `Owner` LIKE  '$owner'
LIMIT 0 , 30";

// execute query 
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error()); 

echo "<br>";
echo "<br>";

// see if any rows were returned 
if (mysql_num_rows($result) > 0) { 

$total = 0.0;
    // yes 
    // print them one after another 
    echo "<table cellpadding=10 border=1>"; 
    echo "<td><b>Title</b></td>
          <td><b>Value</b></td>";
    while($row = mysql_fetch_row($result)) {
    if($row[5] == $order_num){ 
    $total += ($row[2]);
        echo "<tr>"; 
        echo "<td>".$row[0]."</td>"; 
        echo "<td><font color='green'>$".$row[2]."</font></td>"; 
        echo "</tr>"; 
       }
    } 
    echo "</table>";
} 
else { 
    // no 
    // print status message 
    echo "You dont have any books to sell yet!"; 
} 


echo "<br>";
echo "<br>";
if($ship_page){
echo "<h2>Shipping credit given for this order: <font color='green'>$".$ship_cost."</font></h2>";
$total += $ship_cost;
}
echo "<h2>Total value of this order is <font color='green'>$".$total."</font></h2>";
echo "<br>";
echo "<br>";
echo "<font size='3'><a href='contact-us.php'>Contact us</a> with any questions.</font>";
}
else {
	
echo "An error has occured go <a href='index.php?id=5'><font color='3399FF'>here</font></a> to go back to the home page";
	
} 
 
if($status != 'Cancelled'){ 
?> 
<script type="text/javascript">
function confirm_cancel(){
var answer = confirm ("Are you sure you want to cancel this order?")
if (answer)
return true;
else
return false;
}
</script>
<p>If for any reason you would like to cancel this order, click cancel.</p>
<br>
<div style="padding-left: 200px;">
<span class="art-button-wrapper">
<span class="l"> </span>
<span class="r"> </span>
<a href="update-order.php?id=2" onclick="return confirm_cancel();"><input name="status-button" value="Cancel" type="submit" class="art-button"></a>
</span></div> 
 <?php 
 }
 
include("footer2.php"); 
?>
