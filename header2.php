<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!-- page title -->
<title>Summer Textbooks</title>

<!--
A free web template by spyka Webmaster (http://www.spyka.net)
//-->

<link rel="stylesheet" href="css/core.css" type="text/css" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34638038-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<div id="wrapper">

  <div id="sitename" class="clear">
      <!-- YOUR SITE NAME -->
    <h1><a href="#">Summer Textbooks</a></h1>
  </div>
  
  <div id="navbar">  
    <div class="clear">
      <ul class="sf-menu clear">
<li><a href="index.php">Home</a></li>
          <li><a href="contact-us.php">Contact Us</a></li>
          <li><a href="search.php">Search</a></li>
          <li><a href="account.php">My Account</a></li>
          <li><a href="terms.php">Terms</a></li>
          <?php 
            session_start();                            
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1){ ?>
          <li><a href="logout.php">Logout</a></li>
          <?php } else {  ?><li><a href="login.php">Login</a></li> <?php }
          if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1){ ?>
          <li><a href="sign-up.php">Sign Up</a></li>
          <?php } ?>
      </ul>
    </div>
  </div>
  
  <?php $page = $_SERVER['REQUEST_URI'];
  
    $array = explode('/', $page);
    
    $page = $array[1];
    
    if(($page == 'index.php' || $page == '') && $_SESSION['logged_in'] !=  1){
  
   ?>
  <div id="header" class="clear">
    <div class="header-text">
      <h2><strong>How much is your book worth?</strong></h2><br><br>
      <center>
      <form action="search.php" method="post"> 
      <font size='4' color='white'>ISBN #: </font> <input type="text" name="isbn" size="36" maxlength="13">
     <input type="submit" value="Search" name="search">
     </form>
     </center>
      
    </div>
    
  </div>
  <?php } ?>
  <div class="header-bottom"></div>
  
  <div id="body-wrapper">
  
      <!-- BREADCRUMB NAVIGATION -->
    <div class="bcnav">
      <div class="bcnav-left">
        <div class="bcnav-right clear">
        </div>
      </div>
    </div>
    
    <div id="body" class="clear">

      
      <div class="clear">
        <div class="column column-650 column-left">


<?php 
 function VisitorIP()
    { 
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else $TheIp=$_SERVER['REMOTE_ADDR'];
 
    return trim($TheIp);
    }

$ip = VisitorIP();

$host = "books.summertextbooks.com"; 
$user = "jlane09"; 
$pass = "counter"; 
$db = "summer_books"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
    
mysql_select_db($db) or die ("Unable to select database!");    

$query5 = "SELECT * 
FROM  `Visits` 
WHERE  `Address` LIKE  '$ip'
LIMIT 0 , 30";

$result5 = mysql_query($query5) or die ("Error in query: $query. ".mysql_error());  

if(!mysql_num_rows($result5) > 0){
// add the IP to the list

$query5 = "INSERT INTO  `summer_books`.`Visits` (
`Address` ,
`Time`
)
VALUES (
'$ip', 
CURRENT_TIMESTAMP
);";

mysql_query($query5) or die ("Error in query: $query. ".mysql_error());
}
else {
// increment this IP visit count by 1
  
$row =  mysql_fetch_row($result5);

$ip_address = $row[0];
$ip_time = $row[1];
$ip_count = $row[2];

$ip_new_count = $ip_count + 1;

$query5 = "UPDATE  `summer_books`.`Visits` SET  `Count` =  '$ip_new_count' WHERE  
`Visits`.`Address` =  '$ip_address' AND  
`Visits`.`Time` =  '$ip_time' AND  
`Visits`.`Count` =$ip_count LIMIT 1 ;";

mysql_query($query5) or die ("Error in query: $query. ".mysql_error());
}
?>
