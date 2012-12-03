<?php 

if(isset($_GET['ship']))
{
  if($_GET['ship'] == 'true')
  {
    $ship_page = true;
  }
  else 
  {
    $ship_page = false;	
  }	
}
else
{
    $ship_page = false;
}

$owner = "labago";

if(isset($_GET['error']) && $_GET['error'] == 'true'){
$error = true;
}
else {
$error = false;	
}

include("header2.php"); 
$username = $_SESSION['screen_name'];
?>
<h1>Confirmation</h1>
<br>
Check if order is correct, then select a payment method.
<br>
<?php 

if($_SESSION['logged_in'] == 1){

$query = "SELECT * 
FROM  `Settings` 
WHERE  `Owner` LIKE  '$owner'
LIMIT 0 , 30";

$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());	

$row = mysql_fetch_row($result);

$owner = $row[0];
$old_theme = $row[1];
$work_email = $row[3];
$contact = $row[2];
$percent = $row[4];
$minimum = $row[5];
$paypal = $row[6];
$cash = $row[7];
$check = $row[8];
$shipping = $row[9];
if($shipping == 'true')
    $shipping = true;

$query = "SELECT * 
FROM  `User Books` 
WHERE  `Customer` LIKE  '$username'
AND  `Owner` LIKE  '$owner'
LIMIT 0 , 30";

// execute query 
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error()); 

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
    if($row[4] == "False"){ 
    $total += ($row[2]);
        echo "<tr>"; 
        echo "<td><i>".$row[0]."</i></td>"; 
        echo "<td><font color='green'>$".$row[2]."</font></td>"; 
        echo "</tr>"; 
       }
    } 
    echo "</table>";
   
    if(isset($ship_page) && $ship_page){
    if($total < 50.00){
    $ship_total = 3.99;
    }
    else {
    $ship_total = 7.99;	
    }
    $total += $ship_total;
    }    
    
?>    

<?php if((isset($shipping) && $shipping) && (isset($ship_page) && !$ship_page)) { ?>
		<form action="sell.php?ship=true" method="post" name="ship_form">	<br> <br>
			<b><font size="4">Would you like to ship these to us free of charge?<br> 
			                  (More info on next page if yes, ignore if no.)</font></b><br>
<input type="submit" name="ship" value="Yes Please!" />
</form>
<?php } if(isset($ship_page) && $ship_page){ ?>
<br>	
<font size="4"><b>You have chosen to ship these books to us. A total of <font color="green">$<?php echo $ship_total; ?></font> has been added to your
               total to compensate for shipping costs. If instead you would prefer not to ship these books, click cancel below. </font></b>	
<br>
<form action="sell.php" method="post" name="cancel_form">
<input type="submit" name="cancel" value="Cancel" />
</form>
<?php } ?>



<?php

if(isset($ship_page) && $ship_page){
$location = "jump.php?ship=true";	
}
else {
$location = "jump.php";	
} ?>
<script type="text/javascript" language="JavaScript">
function valbutton(thisform) {
// place any other field validations that you require here
// validate myradiobuttons
myOption = -1;
for (i=thisform.payment.length-1; i > -1; i--) {
if (thisform.payment[i].checked) {
myOption = i; i = -1;
}
}
if (myOption == -1) {
alert("You must select a payment method");
return false;
}
thisform.submit(); // this line submits the form
}
</script> 
 
    <br>
    <form action="<?php echo $location; ?>" method="post" name="form">
    <?php if($error){
    	echo "<font color='red' size='2'>You must select a payment method!</font><br>";
    	} ?> 
			<b>Payment Method:</b> <br><br>
			<?php if($paypal == 'True'){ ?>
			Paypal<input type="radio" size="5" name="payment" id="r1" value="paypal" /><br>
			<?php } if($cash == 'True' && (!isset($ship_page) || !$ship_page)) { ?> 
			Cash<input type="radio" size="5" name="payment" id="r1" value="cash" /><br>
			<?php } if($check == 'True'){ ?>
			Check<input type="radio" size="5" name="payment" id="r1" value="a check" />
			<?php } ?>
 <?php   
	 echo "<br>";
	 echo "<br>";
	 echo "Your total order comes to <font size='3' color='green'>$".$total.'.</font> To confirm this, click "Confirm" below. You will recive an email confirmation.';      
    echo "<br>";
    echo "<br>";
    ?>
    
<?php if(isset($ship_page) && $ship_page){ ?>
<input type="submit" name="submitit" value="Confirm" />
<?php } else { ?>    
<input type="submit" name="submitit" onclick="valbutton(form);return false;" value="Confirm" />
<?php } ?>  
 </form>   
    <?php 
} 
else { 
    // no 
    // print status message 
    echo "You dont have any books to sell yet!"; 
} 
}
else {
	
echo "Please <a href='login.php?id=4'><font color='3399FF'>login</font></a> or <a href='sign-up.php'><font color='3399FF'>sign up</font></a> to view this page";
	
}
 
include("footer2.php"); 
?>
