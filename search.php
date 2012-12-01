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
<h1>See what we can give you</h1>
<p>Just enter the 10 or 13 digit ISBN number of the book you are curious about, and we will tell you what we can give you for it.<br>
<br>
<b><font size="3">(Do not include dashes, search may take up to 5 seconds)</font></b></p>
<br>
<br>


<?php 

$query = "SELECT * 
FROM  `Page Owners` 
WHERE  `Site Name` LIKE  'Testing123'
LIMIT 0 , 30";

$result = mysql_query($query);

$row = mysql_fetch_row($result);

$owner = $row[3];

$query = "SELECT * 
FROM  `Settings` 
WHERE  `Owner` LIKE  '$owner'
LIMIT 0 , 30";

$result = mysql_query($query);

$row = mysql_fetch_row($result);

$owner_rate = $row[4];
$owner_min = $row[5];
$owner_rank_min = $row[10];

if(!isset($_GET['added'])){
if(!isset($_POST['search'])){ ?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
			ISBN #: <input type="text" name="isbn" size="36" maxlength="13">
		<input type="submit" value="Search" name="search"> 
</form>

<br>
<br>
<font size="3">To view your book queue and orders, and to confirm an order, go to your <a href="account.php" ><font color="3399FF">My Account</font></a> page</font>

<?php } else {
	
function find_title($string){

$needle = "<title>"; 
	
$start = strpos($string, $needle);

$new_string = substr($string, ($start + 7) , 1000);

$end_of_title = strpos($new_string, ',');

$title = substr($new_string, 0, $end_of_title);	
	
return $title;
}	
	
	
	
	
	
$isbn = trim($_POST['isbn']);	
	
if(strlen($isbn) > 10){

$isbn = substr($isbn, 3);	
		
$url = 'http://www.cheapesttextbooks.com/Computers-Internet-Textbooks/Networking-Textbooks/Introducing-the-Theory-of-Computation-Wayne-Goddard-'.$isbn.'-978'.$isbn.'.html';
}
else {
$url = 'http://www.cheapesttextbooks.com/Computers-Internet-Textbooks/Networking-Textbooks/Introducing-the-Theory-of-Computation-Wayne-Goddard-'.$isbn.'-978'.$isbn.'.html';
}	

$needle = 'Amazon<br />(Marketplace)</a>'; 
$contents = file_get_contents($url); 
if(strpos($contents, $needle)!== false && (strlen($isbn) >= 10)) { 

$start = strpos($contents, $needle);

$new_string = substr($contents, $start, 1000);

$price_start = strpos($new_string, '<span class="price">');

$new_string2 = substr($new_string, ($price_start + 21), 10);

$end_of_price = strpos($new_string2, '</');

$original_price = substr($new_string2, 0, $end_of_price);

// use the rate specified by the owner
$price = round(($original_price * $owner_rate), 2);
$title = find_title($contents);

$needle = "<!-- begin product_card_large -->"; 
$contents = file_get_contents($url); 
$start = strpos($contents, $needle);

$new_string = substr($contents, $start, 2000);

$img_start = strpos($new_string, '<img src="');

$new_string2 = substr($new_string, ($img_start + 10), 1000);

$end_of_img = strpos($new_string2, '" alt');

$img = substr($new_string2, 0, $end_of_img);

$test = explode('.', $price);
$length = strlen($test[1]);

if($owner_rank_min != 1000000){
//start rank search
$url = "http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords=".$isbn."&x=0&y=0";

$needle = '<td align="center" width="115">';
$contents = file_get_contents($url);  
if(strpos($contents, $needle)!== false){
  
$start = strpos($contents, $needle);  

$new_string = substr($contents, $start, 1000);

$url_start = strpos($new_string, '<a href="');

$new_string2 = substr($new_string, ($url_start + 9), 300);

$end_of_url = strpos($new_string2, '">');  

$original_url = substr($new_string2, 0, $end_of_url);

// book url found, search for rank  
$url = $original_url;

$needle = 'Amazon Bestsellers Rank:';
$contents = file_get_contents($url);  
if(strpos($contents, $needle)!== false){

$start = strpos($contents, $needle);  

$new_string = substr($contents, $start, 1000);

$url_start = strpos($new_string, '#');

$new_string2 = substr($new_string, ($url_start + 1), 2000);

$end_of_url = strpos($new_string2, 'in Books');  

$original_url = substr($new_string2, 0, $end_of_url);

$rank = str_replace(",", "", trim($original_url));
$rank = $rank + 0;
}
else {
$rank = "Not Found";  
}
}
else {
$rank = "Not Found";  
}

if($rank == "Not Found"){
$url = "http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords=978".$isbn."&x=0&y=0";

$needle = '<td align="center" width="115">';
$contents = file_get_contents($url);  
if(strpos($contents, $needle)!== false){
  
$start = strpos($contents, $needle);  

$new_string = substr($contents, $start, 1000);

$url_start = strpos($new_string, '<a href="');

$new_string2 = substr($new_string, ($url_start + 9), 300);

$end_of_url = strpos($new_string2, '">');  

$original_url = substr($new_string2, 0, $end_of_url);

// book url found, search for rank  
$url = $original_url;

$needle = 'Amazon Bestsellers Rank:';
$contents = file_get_contents($url);  
if(strpos($contents, $needle)!== false){

$start = strpos($contents, $needle);  

$new_string = substr($contents, $start, 1000);

$url_start = strpos($new_string, '#');

$new_string2 = substr($new_string, ($url_start + 1), 2000);

$end_of_url = strpos($new_string2, 'in Books');  

$original_url = substr($new_string2, 0, $end_of_url);

$rank = str_replace(",", "", trim($original_url));
$rank = $rank + 0;

}
else {
$rank = "Not Found";  
}
}
else {
$rank = "Not Found";  
}
  
}
} //end rank search
else {
$rank = "Not Found";
}

$ranking = false;
if($rank < $owner_rank_min || $rank == 'Not Found')
$ranking = true;

if(($length > 1) || ($length == 0)){
$digits = true;  
}
else {
$digits = false;  
}
// book has to be above users minimum price and ranking
if((!($original_price < $owner_min)) && $ranking){  
if($digits){
echo "<center>";  
echo "<font size='5'><b>".$title."</b></font>";
echo "<br>";
echo '<img src="'.$img.'">';
echo "<br>";
echo "We can give you <font size='3' color='green'>$".$price."</font> for this book.";
echo "</center>";
}
else {
echo "<center>";  
echo "<font size='5'><b>".$title."</b></font>";
echo "<br>";
echo "We can give you <font size='3' color='green'>$".$price."0</font> for this book.";  
echo "</center>";  
}


if($_SESSION['logged_in'] == 1){
  
$_SESSION['title'] = substr($title, 0, 50);
$_SESSION['isbn'] = $isbn;
$_SESSION['price'] = $price;
?>

<a href="add-remove.php?add=1" ><button name="add">Add to My Books</button></a>
<a href="add-remove.php?add=0" ><button name="reject">Reject</button></a>

<?php
}
else {

echo "To add to your book queue, please <a href='login.php?id=2'><font color='3399FF'>login</font></a> or <a href='sign-up.php'><font color='3399FF'>sign up</font></a>";
}

}
else {

echo 'Sorry, either that book is too little in value for us to take, or it too low of a book ranking. <a href="search.php" ><font color="3399FF">Try Another</font></a>';

}


} else { 
echo 'Sorry, we could not find the textbook you are looking for. Check to see if you entered the ISBN correctly or <a href="search.php" ><font color="3399FF">Try Another</font></a>. Remember, it is a 10 or 13 digit number and <b>do not include dashes</b>';
 
$title = "Not Found";
$price = 'N/A'; 
 
}     
}
}
else {

echo "<font size='4'>Added! Go <a href='search.php'><font color='3399FF'>here</font></a> to add another or view your <a href='books.php'><font color='3399FF'>books</font></a></font>";
  
}


$title = str_replace("'", "", $title);
$title = str_replace('"', "", $title);

if(isset($_POST['search'])){
if($_SESSION['logged_in'] != 1){
// store search 
$query = "INSERT INTO  `summer_books`.`Searches` (
`ISBN` ,
`User` ,
`Address` ,
`Time` ,
`Owner` ,
`Title` ,
`Price`
)
VALUES (
'$isbn',  'Guest',  '$ip', 
CURRENT_TIMESTAMP ,  '$owner',  '$title',  '$price'
);";

}
else {
$searcher = $_SESSION['screen_name'];  

$query = "INSERT INTO  `summer_books`.`Searches` (
`ISBN` ,
`User` ,
`Address` ,
`Time` ,
`Owner` ,
`Title` ,
`Price`
)
VALUES (
'$isbn',  '$searcher',  '$ip', 
CURRENT_TIMESTAMP ,  '$owner',  '$title',  '$price'
);";  
}
mysql_query($query) or die ("Error in query: $query. ".mysql_error());
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
