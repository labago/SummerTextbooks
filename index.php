<?php 

$host = "books.summertextbooks.com"; 
$user = "jlane09"; 
$pass = "counter"; 
$db = "summer_books"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
    
mysql_select_db($db) or die ("Unable to select database!");

include("header2.php"); 
?>

<?php 

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] != 1){ ?>
<h1>Welcome!</h1>

<h2>Got some textbooks you want to get rid of quick? Want some extra cash? You've come to the right place.<br><br>
   Just tell us what books you want to sell, and we will meet you at your convenience with your payment. 
</h2>
<br>
<p><font size='4' color='red'>All it takes is 3 easy steps!</font></p>
1. Make an account here for FREE! <a href="sign-up.php" ><font color='3399FF'>(Make account here)</font></a>
<br>
<br>
2. Search for your books using their ISBN #'s, then add them to your <i>queue</i> if you agree with the price shown.<br>
<b>Click </b><a href="search.php" ><font color="3399FF">here</font></a><b> to see what you would get for your book!</b> 
<br>
<br>
3. Go to your account menu to see your book queue and finish your order, we will then contact you for meeting arrangements so you can get your money <b>a.s.a.p</b>
<br>
<br>
<br>
<center>
<form action="search.php" method="post"> 
      ISBN #: <input type="text" name="isbn" size="36" maxlength="13">
    <input type="submit" value="Try It!" name="search"> 
</form>
</center> 
<?php }
else { ?>

<h1>See what we can give you</h1>
<p>Just enter the 10 or 13 digit ISBN number of the book you are curious about, and we will tell you what we can give you for it.<br>
<b>(Do not include dashes, search may take up to 5 seconds)</b></p>
<br>
<br>

<center>
<form action="search.php" method="post"> 
      ISBN #: <input type="text" name="isbn" size="36" maxlength="13">
    <input type="submit" value="Search" name="search"> 
</form>
</center>
       
 
 <br>
 <br>
 
<font size="3">To view your book queue and orders go to your <a href="account.php" ><font color="3399FF">My Account</font></a> page</font>
<?php 
}

include("footer2.php"); 
?>