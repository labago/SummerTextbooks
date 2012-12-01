
<?php 

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
  include("header2.php"); 
}

// make a unique number for the user
function encrypt_user(){
	$value = rand(0, 1000000000);
	
$query_check = "SELECT * 
FROM  `Users` 
WHERE  `Crypt` LIKE  '$value'
LIMIT 0 , 30";	
	
	// query to see if the number exists
	$check_result = mysql_query($query_check) or die ("Error in query: $query. ".mysql_error());	
	
	// if it does exist, find another
   if(!(mysql_num_rows($check_result) > 0))
   return $value;
   else return encrypt_user();
}

function check_password($pass){
	if(strpos($pass, "'") == true){
		return false;	
	}
	return true;
}

function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
↪([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

if (!isset($_POST['signup'])) {
?>
<script type="text/javascript" >
function check_form(form){

var checked = true;	
	
if(form.fname.value == ''){
checked = false;	
}
if(form.lname.value == ''){
checked = false;	
}
if(form.email.value == ''){
checked = false;	
}
if(form.email_check.value == ''){
checked = false;	
}
if(form.screen_name.value == ''){
checked = false;	
}
if(form.pwd1.value == ''){
checked = false;	
}
if(form.pwd2.value == ''){
checked = false;	
}
if(form.address.value == ''){
checked = false;	
}
if(form.city.value == ''){
checked = false;	
}
if(form.zip.value == ''){
checked = false;	
}	

if(checked){
	if(form.terms.checked != false){
	return true;
	}
	else {
alert("You must agree to the terms and conditions!");
return false;		
		}
}
else {
alert("Make sure all parts are filled out");
return false;	
}
}



</script>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return check_form(this)">
			*First Name: <input type="text" name="fname" size="26" maxlength="80">
			<br>
			<br>
			*Last Name: <input type="text" name="lname" size="26" maxlength="80">
			<br>
			<br>
			*Email: <input type="text" name="email" size="30" maxlength="90">
			<br>
			<br>
			*Re-enter Email: <input type="text" name="email_check" size="23" maxlength="90">
			<br>
			<br>
			*Username: <input type="text" name="screen_name" size="26" maxlength="80">
			<br>
			<br>
		   *Password: <input type="password" name="pwd1" size="27" maxlength="20">
			<br>
			<br>
			*Re-enter Password: <input type="password" name="pwd2" size="21" maxlength="20">
			<br>
			<br>
			*Address: <input type="text" name="address" size="21" maxlength="50">
			<br>
			<br>
			*City: <input type="text" name="city" size="21" maxlength="50">
			<br>
			<br>
			*Zip Code: <input type="text" name="zip" size="5" maxlength="5">
			<br>
			<br>
			Phone Number: <input type="text" name="number" size="21" maxlength="25">
			<br>
			<br>
			<input type="checkbox" name="terms" /> I have read and understand the <a href="terms.php" >Terms and Conditions</a>
			<br>
			<br>
			<font size="1">Items with an * before them are required</font> <br><br>
		<input type="submit" value="Sign Up" name="signup"> 
</form>
<?php
}
else { 

if($_POST['pwd1'] != $_POST['pwd2']){
		echo "Passwords do not much, go back!";
	}
	else if(!check_password($_POST['pwd1'])){
		echo "Password cannot contain the ' symbol go back";
	}
	else if(!check_password($_POST['screen_name'])){
		echo "Username cannot contain the ' symbol go back";
	}
	else if($_POST['email'] != $_POST['email_check']){
		echo "Emails do not much, go back!";
		}
		else {
		
$username = $_POST['email'];
$screen_name = $_POST['screen_name'];

$query = "SELECT * 
FROM  `Users` 
WHERE  `Email` LIKE  '$username'
LIMIT 0 , 30";		
		
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());	

	if ((mysql_num_rows($result) > 0)) {
		echo "Email already used, use another";
		echo "<br>";
		echo "<a href='sign-up.php'>Retry</a>";
		}
	else if(!check_email_address($_POST['email'])) {
		echo "Not a valid email address!";
		echo "<br>";
		echo "<a href='sign-up.php'>Retry</a>";
		} 
	else {
		
$query = "SELECT * 
FROM  `Users` 
WHERE  `Username` LIKE  '$screen_name'
LIMIT 0 , 30";		
		
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());	

	if ((mysql_num_rows($result) > 0)) {
		echo "Username already used, use another";
		echo "<br>";
		echo "<a href='sign-up.php'>Retry</a>";
		} 
	else {

$fname = str_replace("'", "", $_POST['fname']); 
$lname = str_replace("'", "", $_POST['lname']);
$email = str_replace("'", "", $_POST['email']);
$address = str_replace("'", "", $_POST['address']);
$city = str_replace("'", "", $_POST['city']);
$zip = str_replace("'", "", $_POST['zip']);
$password = $_POST['pwd1'];
$screen_name = $_POST['screen_name'];
$phone = $_POST['number'];
$crypt = encrypt_user();	

// select database 
mysql_select_db($db) or die ("Unable to select database!"); 

// create query 
$query = "INSERT INTO  `summer_books`.`Users` (
`First Name` ,
`Last Name` ,
`Email` ,
`Username` ,
`Password` ,
`Address` ,
`City` ,
`Zip Code` ,
`Crypt`,
`Owner`,
`Phone`
)
VALUES (
'$fname',  '$lname',  '$email',  '$screen_name',  '$password',  '$address',  '$city',  '$zip',  '$crypt', 'labago', '$phone'
);";

// execute query 
mysql_query($query) or die ("Error in query: $query. ".mysql_error());

session_start();

$_SESSION['logged_in'] = 1;
$_SESSION['screen_name'] = $screen_name;
$_SESSION['owner'] = $owner;
	
$query = "SELECT * 
FROM  `Page Owners` 
WHERE  `Username` LIKE  '$owner'
LIMIT 0 , 30";	
		
$result = mysql_query($query);

$row = mysql_fetch_row($result);

$owner_email = $row[2];
	
$screen_name = $_SESSION['screen_name'];	
$header = 'From: new-member-service Reviews'."\r\n";
$user_header = 'Content-type: text/html; charset=iso-8859-1'."\r\n";
$user_header .= 'From: new-member-service'."\r\n";
$subject = $_POST['subject'];
$owner_message = $screen_name." has become a member of your summertextbooks.com page";
$user_message = "Dear ".$fname.", <br><br>";
$user_message .= "<p>Welcome to summertextbooks.com, we are pleased to be at your service. You can start adding books to your queue at anytime 
                  by using the search form located on our homepage or search page. Once you have all the books you want to sell
                  in your queue, go to your account page and view your book queue. From there you just click the 'Sell These books'
                  button and follow the steps from there. We hope you find our site useful. </p> <br> <br> <br>";
$user_message .= "Sincerely, <br> <br> <b>The Summer Textbook Team</b>";               

// sent a notification to new user
mail($email, "Welcome!", $user_message, $user_header);

// sent a notification to owner
mail($owner_email, "New Member", $owner_message, $header);
		
$my_message = $screen_name." has become a member of ".$owner."'s page";	
		
// sent a notification to ME		
mail('jlane09sjp@gmail.com', 'New Page Member', $my_message, $header);		
		
		
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
}
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
  include("footer2.php"); 
}?>
