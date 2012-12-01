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
?>
<h1> Password Retrieval  </h1>

<?php if (!isset($_POST['sent'])) {
?>
<br>
Enter your email and click "Send". Check your inbox for your password.
<br>
<br>
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
			Email: <input type="text" name="email" size="26" maxlength="80">
		<input type="submit" value="Send" name="sent"> 
</form>

<?php }
else {
	
$email = $_POST['email'];	
	
$host = "books.summertextbooks.com"; 
$user = "jlane09"; 
$pass = "counter"; 
$db = "summer_books"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
		
mysql_select_db($db) or die ("Unable to select database!");		

$query = "SELECT * 
FROM  `Users` 
WHERE  `Email` LIKE  '$email'
LIMIT 0 , 30";		
		
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());	
	
if(mysql_num_rows($result) > 0){	
$row = mysql_fetch_row($result);

$password = $row[4];
$email = $row[2];

$screen_name = $_SESSION['screen_name'];	
$header = 'From: password-service \r\n';
$message = "Your password for Summer Textbooks is: '".$password."' \n \n if you have recieved this emal in error, please disregard";

// sent a notification to MEEE
mail($email, "Your Password", $message, $header);

echo "Your password has been sent, go <a href='login.php'><font color='3399FF'>here</font></a> to login";

}
else {
echo "That email is not in our records, go back and try again";
	
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
  }
  ?> 