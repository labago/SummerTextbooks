<?php 

session_start();

$username = $_SESSION['admin_screen_name'];

include("find-theme.php");

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
?>
<h1>Purchased Books</h1><br>
<p>Enter the prices that you sold these books for, then click "Update" </p>

<script type="text/javascript" >

function check_num(num) { 

for(num; num > 0; num--){

var check=document.forms["myform"]["book"+num].value
	
if(isNaN(check){
alert(check+" is not a number! Change it and try again");
return false;	
}
}
alert("test");
return false;
}


</script>

<?php 


if($_SESSION['admin_logged_in'] == 1){
	
$query = "SELECT * 
FROM  `User Books` 
WHERE  `Status` LIKE  'Completed'
AND  `Owner` LIKE  '$username'
ORDER BY  `Date` DESC 
LIMIT 0 , 30";

// execute query 
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error()); 

echo "<br>";
echo "<br>";

$amount = mysql_num_rows($result);

$count = 1;

$total_paid = 0;
$total_ship = 0;
$total_sold = 0;
// see if any rows were returned 
if (mysql_num_rows($result) > 0) {	
    // yes 
    // print them one after another
    echo "<form name='myform' action='update-books.php?count=".$amount."' method='post' onsubmit='return check_num(1)'>"; 
    echo "<table cellpadding=10 border=1>";
    echo "<td><b>Title</b></td>
    		 <td><b>Date</b></td>
          <td><b>Paid</b></td>
          <td><b>Sold</b></td>
          <td><b>Shipping</b></td>";  
    while($row = mysql_fetch_row($result)) {
      if($row[4] == 'Completed'){
      	$date = date('M j, Y', strtotime($row[8]));
      	$total_paid += $row[2];
      	$total_ship += $row[9];
      	$total_sold += $row[7];
        echo "<tr>"; 
        echo "<td>".$row[0]."</td>";
        echo "<td>".$date."</td>"; 
        echo "<td>$".$row[2]."</td>";
        echo "<td>$<input type='text' size='2' name='book".$count."' value='".$row[7]."'></td>";
        echo "<td>$<input type='text' size='2' name='ship".$count."' value='".$row[9]."'></td>"; 
        echo "</tr>";
        $count += 1;
        } 
     } 
     
$profit = $total_sold - ($total_paid + $total_ship);
    echo "</table>";
    echo "<br>";
    echo "<br><center><font size='4'>Total Profit:</font></center><br>";
    if($profit > 0){
    echo "<center><font size='10' color='green'>$".$profit."</font></center>";
    }
    else {
    echo "<center><font size='10' color='red'>$".$profit."</font></center>";
    }
    echo "<br>";
    echo "<center><input type='submit' value='Update' name='update'></center>"; 
    echo "</form>";
    }  
else { 
    // no 
    // print status message 
    echo "<font size='4'>You havent bought any books yet! <a href='admin.php'><font color='3399FF'>Admin Page</font></a></font>"; 
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