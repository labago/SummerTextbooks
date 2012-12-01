<?php 
session_start();


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

if($_SESSION['logged_in'] == 1){
	
$username = $_SESSION['screen_name'];	
	
$query = "SELECT * 
FROM  `Users` 
WHERE  `Username` LIKE  '$username'
LIMIT 0 , 30";

$result = mysql_query($query);

$row = mysql_fetch_row($result);

$pre_fill = $row[2];
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
<h1> Contact Us </h1>
<p>Questions? Constructive Criticism? Just send a message...</p>

<style>
textarea#styled {
        width: 400px;
        height: 60px;
        border: 3px solid #cccccc;
        padding: 5px;
        font-family: Tahoma, sans-serif;
        background-image: url(bg.gif);
        background-position: bottom right;
        background-repeat: no-repeat;
        resize: none; 
}
</style>
<script type="text/javascript" src="charcount.js"></script>
<script type="text/javascript" language="JavaScript">
function validateForm()
{
var x=document.forms["form"]["email"].value
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  alert("You must supply a valid email address");
  return false;
  }
}
</script>
<br>
<?php                                             
session_start();
       
if (!isset($_POST['sent'])) { ?>
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form" onsubmit="return validateForm()"> 
			Subject: <input type="text" name="subject" size="32" maxlength="80">
			<br>
			<?php if($_SESSION['logged_in'] == 1){ ?>
			Return Email: <input type="text" name="email" style='border: none' readonly size="26" maxlength="80" value="<?php echo $pre_fill; ?>">
			<?php } else { ?>
			Return Email: <input type="text" name="email" size="26" maxlength="80" value="">
			<?php } ?>
			<br>
			<br>
			 <textarea name="message" maxlength="500" wrap=physical id="styled" onkeyup=limiter() onfocus="	if ( this.value == 'Your message here...' ) {	this.value = '';}; setbg('#e5fff3');" onblur="if ( this.value == '' ) {	this.value = 'Your message here...';}; setbg('white')">Your message here...</textarea>
		<br> Characters left: 
			<script type="text/javascript">
document.write("<font color='green'><input type=text style='border: none' name=limit size=4 readonly value="+count+"></font>");
</script>
<br>
<br>
		<input type="submit" value="Send" name="sent"> 
</form>                                   

<?php }
else {
	echo "Message Sent! We will get back to you within 24 hours";
	
$sender = $_POST['email'];	
$header = 'From: '.$sender."\r\n"; 
$subject = $_POST['subject'];
$message = $_POST['message'];

mail('jlane09sjp@gmail.com', $subject, $message, $header);
}
?>	 



<?php
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