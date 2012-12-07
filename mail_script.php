<?php

$host = "books.summertextbooks.com"; 
$user = "jlane09"; 
$pass = "counter"; 
$db = "summer_books"; 

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
		
mysql_select_db($db) or die ("Unable to select database!");

$query = "SELECT * 
FROM `Users` 
WHERE `Owner` LIKE 'labago'
LIMIT 0 , 30";

$result = mysql_query($query);

while($row = mysql_fetch_row($result))
{
	if(($row[11] != 'true') && false)
	{
		$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		// Additional headers
		$headers .= 'From: Summer Textbooks <do-not-reply@summertextbooks.com>' . "\r\n";

		$subject = "Announcement";
		$message = "<h2>Summer Textbooks</h2><br>";
		$message .= "Dear ".$row[0].", <br>";
		$message .= "<p>This is just a friendly reminder that even though the site name implies that we are only open
						for business in the summer, we are in fact open for the end of the Fall Semester as well. 
						We are still here to offer you better prices than the book store can, and with some new
						site improvements, its easier than ever to get cash for your books fast. Visit www.summertextbooks.com 
						today. </p>";
		$message .= "<p>In case you have forgotten, your password to login with is below:<br>";
		$message .= '<b>"'.$row[4].'"</b></p><br>';
		$message .= "Sincerely, <br> <br> The Summer Textbook Team";
		$message .= "<br><br><br><font size='1'>Unsubscribe from future emails <a href='http://www.summertextbooks.com/opt-out.php?id=".$row[2]."'>here</a>";               

		// sent a notification to new user
		if(mail($row[2], $subject, $message, $headers))
			echo "Email sent to ".$row[2]." successfully<br>";
		else
			echo "Email sent to ".$row[2]." falied";	
	}
	else
		echo $row[2]." has unscubscribed from emails.<br>";
}