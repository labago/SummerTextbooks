<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
<link rel="stylesheet" type="text/css" href="style.css" />
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



<body>
    <div id="page">
              <div id="header">
                  <img src="logo.png" alt="Summer Textbooks" />
                    <!-- Include an <h1></h1> tag with your site's title here, or make a transparent PNG like the one I used -->
                </div>
    
                </div>

                <div id="content">
                  <div id="container">

                        <div id="main">
                        <div id="menu">
                            <ul>
                             <?php 
                    session_start();                            
                            if($_SESSION['logged_in'] == 1){ ?>
                              <li><a href="logout.php">Logout</a></li>
                              <?php } else {  ?><li><a href="login.php">Login</a></li> <?php } ?>
                                <li><a href="terms.php">Terms</a></li>
                                <li><a href="account.php">My Account</a></li>
                                <li><a href="search.php">Search</a></li>
                                <li><a href="contact-us.php">Contact Us</a></li>
                                <li><a href="index.php">Home</a></li>
                            </ul>
                        </div>
                        <div id="text">

