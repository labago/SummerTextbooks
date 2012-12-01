<?php 

$host = "books.summertextbooks.com"; 
$user = "jlane09"; 
$pass = "counter"; 
$db = "summer_books"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
		
mysql_select_db($db) or die ("Unable to select database!");

$query = "SELECT * 
FROM  `Settings` 
WHERE  `Owner` LIKE  'jlane09'
LIMIT 0 , 30";

$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());	

$row = mysql_fetch_row($result);

$theme = $row[1];

switch ($theme)
{
case 1:
  include("header.php");   
  break;
case 2:
  include("header2.php"); 
  break;
case 3:
  include("header3.php"); 
  break;
case 4:
  include("header4.php"); 
  break;    
default:
  include("header.php"); 
}

$username = $_SESSION['screen_name'];
?>
<h1>My Orders</h1>

<?php 

if($_SESSION['logged_in'] == 1){
$query = "SELECT * 
FROM  `Orders` 
WHERE  `Customer` LIKE  '$username'
ORDER BY  `Number` ASC 
LIMIT 0 , 30";

// execute query 
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error()); 

echo "<br>";
echo "<br>";

// see if any rows were returned 
if (mysql_num_rows($result) > 0) { 

    // yes 
    // print them one after another 
    echo "<table cellpadding=10 border=1>";
    echo "<td><b>Date</b></td>
          <td><b>#</b></td>
          <td><b>Status</b></td>
          <td><b>Details</b></td>"; 
    while($row = mysql_fetch_row($result)) {
    	$date = date('M j, Y', strtotime($row[1]));
        echo "<tr>"; 
        echo "<td>".$date."</td>"; 
        echo "<td>".$row[2]."</td>";
		  echo "<td>".$row[3]."</td>"; 
        echo "<td>"."<a href='view-order.php?id=".$row[2]."'>Details</a></td>";
        echo "</tr>"; 
    } 
    echo "</table>";
} 
else { 
    // no 
    // print status message 
    echo "You havent made any orders yet!"; 
} 
}
else {
	
echo "Please <a href='login.php?id=5'><font color='3399FF'>login</font></a> or <a href='sign-up.php'><font color='3399FF'>sign up</font></a> to view this page";
	
}
 
switch ($theme)
{
case 1:
  include("footer.php");   
  break;
case 2:
  include("footer2.php"); 
  break;
case 3:
  include("footer3.php"); 
  break;
case 4:
  include("footer4.php"); 
  break;    
default:
  include("footer.php"); 
}?>