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

function check_password($pass){
	if(strpos($pass, "'") == true){
		return false;	
	}
	return true;
}


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
<h1> My Account </h1>
<br>

 
 <?php 
 if(isset($_GET['changed']) && $_GET['changed'] == 1){

	echo "Your password has succesfully been changed";
	
}	
else if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1)
{ 	
 echo "Please <a href='login.php?id=1'><font color='3399FF'>login</font></a> or <a href='sign-up.php'><font color='3399FF'>sign up</font></a> to view this page";
} 	                                            	
elseif (!isset($_POST['change'])) {
?>

<font size="3"><b>For your book queue</b></font><br>
<a href="books.php" ><font size="3" color='3399FF'>Click Here</font></a>
<br>
<br>
<font size="3"><b>For your recent orders</b></font><br>
<a href="orders.php" ><font size="3" color='3399FF'>Click Here</font></a>
<br>
<br>

<p><font size="4"> Change password </font> </p>
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
			Old Password: <input type="password" name="old_pwd" size="26" maxlength="80">
			<br>
			New Password: <input type="password" name="new_pwd" size="27" maxlength="80">
			<br>
			<br>
		<input type="submit" value="Change Password" name="change"> 
</form>
<?php
}
else { 

session_start();

$screen_name = $_SESSION['screen_name'];

$old = $_POST['old_pwd'];
$new = $_POST['new_pwd'];

$host = "books.summertextbooks.com"; 
$user = "jlane09"; 
$pass = "counter"; 
$db = "summer_books"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
		
mysql_select_db($db) or die ("Unable to select database!");		

$query = "SELECT * 
FROM  `Users` 
WHERE  `Username` LIKE  '$screen_name'
LIMIT 0 , 30";		
		
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());	

$row =  mysql_fetch_row($result);

$fname = $row[0];
$lname = $row[1];
$email = $row[2];
$real_password = $row[4];
$address = $row[5];
$city = $row[6];
$zip = $row[7];
$crypt = $row[8];

if(($old == $real_password) && check_password($new)){

$query = "UPDATE  `summer_books`.`Users` SET  `Password` =  '$new' WHERE  
`Users`.`First Name` =  '$fname ' AND  
`Users`.`Last Name` =  '$lname' AND  
`Users`.`Email` =  '$email' AND  
`Users`.`Username` =  '$screen_name' AND  
`Users`.`Password` =  '$real_password' AND  
`Users`.`Address` =  '$address' AND  
`Users`.`City` =  '$city' AND 
`Users`.`Zip Code` =$zip AND  
`Users`.`Crypt` =  '$crypt' LIMIT 1 ;";

mysql_query($query) or die ("Error in query: $query. ".mysql_error());	

header("Location: account.php?changed=1");
}
else {
	echo "Either your old password did not match the password you entered, or the 
			new password you requested contained the ' character. Go back and try again".$screen_name;
	}
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