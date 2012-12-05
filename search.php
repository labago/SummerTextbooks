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
<h1>See what we can give you</h1>
<p>Just enter the 10 or 13 digit ISBN number of the books you are curious about. You can enter one at a time and they will be added to the table below, then
  use the buttons to decide what you want to do with them<br>
<br>
<b><font size="3">(Do not include dashes)</font></b></p>
<script>
function removeElement(node) {
    node.parentNode.removeChild(node);
}
function search(isbn) 
{
     if(isbn.length > 9)
     {
       var old = $('#result_table').html();
       document.search_form.isbn.value = '';
       $('#result_table').html(old+'<tr><center><td><img src="images/loading17.gif" width="100"></td></center></tr>');
       $.ajax({
              type: "GET",
              url: "resources/ajax/amazon-lookup.php",
              data: "isbn="+isbn,
              success: function(data){
                  $('#result_table').html(old+data);
              }
        });
     }
     else
      alert('Please enter a valid ISBN number.');
}
function add(isbn, price, title, el) 
{
     $(el).html('<img src="images/loading17.gif" width="50">');
     $.ajax({
            type: "GET",
            url: "add-remove.php",
            data: "isbn="+isbn+"&title="+title+"&price="+price+"&add=2",
            success: function(data){
                if(data == 'Success')
                  $(el.parentNode).html('<font size="2"><b>Added!</b></font>');
                else
                  $('.results').html('Something Went Wrong');
            }
    });
}
$(document).ready(function () {
  $('#search_button').click(function(){
    search(document.search_form.isbn.value); return false;
  });
});
</script>

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

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="search_form"> 
			ISBN #: <input type="text" name="isbn" size="36" maxlength="13" id="isbn_search">
		<input type="submit" value="Search" name="search" id="search_button"> 
</form>
<br>
<div class="results">
  <center>
    <table border="1" bordercolor="black" style="background-color:white" width="100%" cellpadding="3" cellspacing="3" id="result_table">
      <tr>
          <td>ISBN #</td>
          <td>Title</td>
          <td>Cover Image</td>
          <td>Our Offer</td>
          <td>Decision</td>
      </tr>
    </table>
  </center>
</div>
<br>
<a href="sell.php" ><input type="submit" value="Sell Added Books!" name="agree"></a>

<br>
<br>
<font size="3">To view your book queue and orders, and to confirm an order, go to your <a href="account.php" ><font color="3399FF">My Account</font></a> page</font>

<?php } else {
	
$isbn = trim($_POST['isbn']);	
  
if (is_file('resources/api/amazon/sampleSettings.php'))
{
  include 'resources/api/amazon/sampleSettings.php';
}

defined('AWS_ASSOCIATE_TAG') or define('AWS_ASSOCIATE_TAG', 'ASSOCIATE TAG');

require 'resources/api/amazon/AmazonECS.class.php';

try
{
    $amazonEcs = new AmazonECS('AKIAI4Z5QGF45FO6A2NA', 'GFOKAPtm+Xe5REKUmpDk/T0Nisbw3KG1QdXnQqlt', 'com', AWS_ASSOCIATE_TAG);

    $amazonEcs->associateTag(AWS_ASSOCIATE_TAG);

    // Looking up multiple items
    $response = $amazonEcs->responseGroup('ItemAttributes')->optionalParameters(array('Condition' => 'Used'))->lookup($isbn);

    if(isset($response->Items->Item->ItemAttributes->Title))
    {
      $title = $response->Items->Item->ItemAttributes->Title;
      $response = $amazonEcs->responseGroup('Images')->optionalParameters(array('Condition' => 'Used'))->lookup($isbn);

      if(isset($response->Items->Item->MediumImage->URL))
        $img = $response->Items->Item->MediumImage->URL;
      else
        $img = '';

      $response = $amazonEcs->responseGroup('OfferSummary')->optionalParameters(array('Condition' => 'Used'))->lookup($isbn);
      $price = $response->Items->Item->OfferSummary->LowestUsedPrice->FormattedPrice;
      $price_int = intval(substr($price, 1));
      $low_price = $price_int * $owner_rate;
      $rank = 0;
    }
    else
    {
      $new_isbn = "978".$isbn;
      $response = $amazonEcs->responseGroup('ItemAttributes')->optionalParameters(array('Condition' => 'Used'))->lookup($new_isbn);

      if(isset($response->Items->Item->ItemAttributes->Title))
      {
        $title = $response->Items->Item->ItemAttributes->Title;
        $response = $amazonEcs->responseGroup('Images')->optionalParameters(array('Condition' => 'Used'))->lookup($new_isbn);

        if(isset($response->Items->Item->MediumImage->URL))
          $img = $response->Items->Item->MediumImage->URL;
        else
          $img = '';

        $response = $amazonEcs->responseGroup('OfferSummary')->optionalParameters(array('Condition' => 'Used'))->lookup($new_isbn);
        $price = $response->Items->Item->OfferSummary->LowestUsedPrice->FormattedPrice;
        $price_int = intval(substr($price, 1));
        $low_price = $price_int * $owner_rate;
        $isbn = $new_isbn;
        $rank = 0;
      }
      else
      {
        $new_isbn = substr($isbn, 3);
        $response = $amazonEcs->responseGroup('ItemAttributes')->optionalParameters(array('Condition' => 'Used'))->lookup($new_isbn);

        if(isset($response->Items->Item->ItemAttributes->Title))
        {
          $title = $response->Items->Item->ItemAttributes->Title;
          $response = $amazonEcs->responseGroup('Images')->optionalParameters(array('Condition' => 'Used'))->lookup($new_isbn);

          if(isset($response->Items->Item->MediumImage->URL))
            $img = $response->Items->Item->MediumImage->URL;
          else
            $img = '';

          $response = $amazonEcs->responseGroup('OfferSummary')->optionalParameters(array('Condition' => 'Used'))->lookup($new_isbn);
          $price = $response->Items->Item->OfferSummary->LowestUsedPrice->FormattedPrice;
          $price_int = intval(substr($price, 1));
          $low_price = $price_int * $owner_rate;
          $isbn = $new_isbn;
          $rank = 0;
        }
        else
        {
          throw new Exception("Not Found");
        }
      }
    }

  if($owner_rank_min == 1000000)
  {
    $ranking = true;
  }
  else
  {
    if($rank < $owner_rank_min)
      $ranking = true;
    else
      $ranking = false;
  }

  if(($owner_min < $low_price) && $ranking)
  {
    echo "<center>";  
    echo "<font size='5'><b>".$title."</b></font>";
    echo "<br>";
    echo '<img src="'.$img.'">';
    echo "<br>";
    echo "We can give you <font size='3' color='green'>$".$low_price."</font> for this book.";
    echo "</center>";

    if($_SESSION['logged_in'] == 1)
    {

    echo '<a href="add-remove.php?add=1&title='.htmlentities(substr($title, 0, 50)).'&isbn='.$isbn.'&price='.$low_price.'" ><button name="add">Add to My Books</button></a>';
    echo '<a href="add-remove.php?add=0" ><button name="reject">Reject</button></a>';
    }
    else {

    echo "To add to your book queue, please <a href='login.php?id=2'><font color='3399FF'>login</font></a> or <a href='sign-up.php'><font color='3399FF'>sign up</font></a>";
    }
  }
  else {

  echo 'Sorry, either that book is too little in value for us to take, or it too low of a book ranking. <a href="search.php" ><font color="3399FF">Try Another</font></a>';

  }

  if(!isset($title))   
    $title = "Not Found";
  if(!isset($price))
    $price = 'N/A';   

  if(isset($title))
  {
    $title = str_replace("'", "", $title);
    $title = str_replace('"', "", $title);
  }
  else
    $title = "";

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

  }
catch(Exception $e)
{
  echo 'Sorry, we could not find the textbook you are looking for. Check to see if you entered the ISBN correctly or <a href="search.php" ><font color="3399FF">Try Another</font></a>. Remember, it is a 10 or 13 digit number and <b>do not include dashes</b>';
}
}
}
else {

echo "<font size='4'>Added! Go <a href='search.php'><font color='3399FF'>here</font></a> to add another or view your <a href='books.php'><font color='3399FF'>books</font></a></font>";
  
}
include("footer2.php"); 
?>
