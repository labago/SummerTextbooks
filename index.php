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

if(!$logged_in){ ?>
<h1>Welcome!</h1>

<h2>Got some textbooks you want to get rid of quick? Want some extra cash? You've come to the right place.<br><br>
   Just tell us what books you want to sell, and we will meet you at your convenience with your payment. 
</h2>
<br>
<p><font size='4' color='red'>All it takes is 3 easy steps!</font></p>
<ol>
<li>Make an account here for FREE! <a href="sign-up.php" ><font color='3399FF'>(Make account here)</font></a></li>
<li>Search for your books using their ISBN #'s, then add them to your <i>queue</i> if you agree with the price shown.<br>
<b>Click </b><a href="search.php" ><font color="3399FF">here</font></a><b> to see what you would get for your book!</b></li> 
<li>Go to your account menu to see your book queue and finish your order, we will then contact you for meeting arrangements so you can get your money <b>a.s.a.p</b></li>
</ol>
<?php }
else
{ 
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=search.php">'; 
}

include("footer2.php"); 
?>