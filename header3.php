 <!--
Design by Bryant Smith
http://www.bryantsmith.com
http://www.aszx.net
email: templates [-at-] bryantsmith [-dot-] com
Released under Creative Commons Attribution 2.5 Generic.  In other words, do with it what you please; but please leave the link if you'd be so kind :)

Name       : A Farewell to Colors
Description: One column, with top naviagation
Version    : 1.0
Released   : 20081230
-->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style3.css" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
<title>Summer Textbooks</title>
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
    <div id="page">
    
        <div id="header">
          <h1>Summer Textbooks</h1>
            <h2>Quick money for your old textbooks</h2>
            
      </div>
  <div id="bar">
          <div class="link"><a href="index.php">Home</a></div>
            <div class="link"><a href="contact-us.php">Contact Us</a></div>
            <div class="link"><a href="terms.php">Terms</a></div>
            <div class="link"><a href="account.php">My Account</a></div>
            <div class="link"><a href="search.php">Search</a></div>
            <div class="link"><a href="#">Faq</a></div>
            <?php 
        session_start();                            
            if($_SESSION['logged_in'] == 1){ ?>
           <div class="link"><a href="logout.php">Logout</a></div>
      <?php } else {  ?><div class="link"><a href="login.php">Login</a></div> <?php } ?>
      </div>
      <div class="contentText">
      
      
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
