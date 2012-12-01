<?php 

if(isset($_GET['id']))
  $where = $_GET['id'];
else
  $where = "";

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
<h1> Login </h1>
<br>
<?php 


if (!isset($_POST['login'])) { ?>
<form action="login.php?id=<?php echo $where; ?>" method="post"> 
			Email: <input type="text" name="email" size="31" maxlength="80">
			<br>
			Password: <input type="password" name="password" size="27" maxlength="80">
			<br>
		<input type="submit" value="Login" name="login"> 
</form>
<br>
<p><font size="2">Forgot your password? <a href="get-password.php"><font color='3399FF'>Click Here</font></a></font></p>
<p><font size="2">Dont have an account? <a href="sign-up.php"><font color='3399FF'>Sign Up</font></a> now!</font></p>
<?php
}
else { 

$where = $_GET['id'];

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * 
FROM  `Users` 
WHERE  `Email` LIKE  '$email'
LIMIT 0 , 30";		
		
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());	

if (!mysql_num_rows($result) == 1) {
	echo "Wrong Username or Password"; 
}
else {
	
$row = mysql_fetch_row($result);
	
$real_password = $row[4];

if($password == $real_password){
			session_start();
			
			$_SESSION['logged_in'] = 1;
			$_SESSION['screen_name'] = $row[3];
			$_SESSION['first_name'] = $row[0];
			$_SESSION['last_name'] = $row[1];
				
switch ($where)
{
case 1:
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=account.php">';   
  break;
case 2:
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=search.php">'; 
  break;
case 3:
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=books.php">'; 
  break;
case 4:
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=sell.php">'; 
  break;
case 5:
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=orders.php">'; 
  break;       
default:
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">'; 
}					
}
else {
echo "Wrong Username or Password";
}
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