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
<h1>Your Books</h1>

<?php 


if($_SESSION['logged_in'] == 1){
$query = "SELECT * 
FROM  `User Books` 
WHERE  `Customer` LIKE  '$username'
LIMIT 0 , 30";

// execute query 
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error()); 

echo "<br>";
echo "<br>";

$new = false;

while($row = mysql_fetch_row($result)) {  
    if($row[4] == "False"){
        $new = true; 
      }
}


// see if any rows were returned 
if (mysql_num_rows($result) > 0 && $new) {
	
$query = "SELECT * 
FROM  `User Books` 
WHERE  `Customer` LIKE  '$username'
LIMIT 0 , 30";

// execute query 
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error()); 
	
	 
?>

Only click "Sell These Books" <i>when you are ready</i> to sell the books listed below, you will be contacted and a meeting time and place will be set up.
Payment options include: <b>Cash, Check, or Paypal</b>
<br>
<br>
<a href="sell.php" ><input type="submit" value="Sell These Books" name="agree"></a>
<br>
<br>

<?php
    // yes 
    // print them one after another 
    echo "<table cellpadding=10 border=1>";
    echo "<td><b>Title</b></td>
          <td><b>Value</b></td>
          <td><b>Remove</b></td>";  
    while($row = mysql_fetch_row($result)) {
      if($row[4] == "False"){
        echo "<tr>"; 
        echo "<td><i>".$row[0]."</i></td>"; 
        echo "<td><font color='green'>$".$row[2]."</font></td>"; 
        echo "<td>".'<a href="remove.php?isbn='.$row[1].'"><font color="3399FF">Remove</font></a>'."</td>"; 
        echo "</tr>"; 
        }
     } 
    echo "</table>";
    }  
else { 
    // no 
    // print status message 
    echo "You dont have any books here yet!"; 
} 
}
else {

echo "Please <a href='login.php?id=3'><font color='3399FF'>login</font></a> or <a href='sign-up.php'><font color='3399FF'>sign up</font></a> to view this page";
	
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