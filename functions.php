<?php

function search_isbn($isbn)
{

  $host = "books.summertextbooks.com"; 
  $user = "jlane09"; 
  $pass = "counter"; 
  $db = "summer_books"; 

  // open connection 
  $connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
          
  mysql_select_db($db) or die ("Unable to select database!");

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
    
  if (is_file('../api/amazon/sampleSettings.php'))
  {
    include '../api/amazon/sampleSettings.php';
  }

  defined('AWS_ASSOCIATE_TAG') or define('AWS_ASSOCIATE_TAG', 'ASSOCIATE TAG');

  require '../api/amazon/AmazonECS.class.php';

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
      echo '<tr>';
        echo '<td><b>'.$isbn.'</b></td>';
        echo '<td><font size="3"><b>'.$title.'</b></font></td>';
        echo '<td><img src="'.$img.'" style="width: 100px;"></td>';
        echo '<td><font size="4" color="green">$'.$low_price.'</font></td>';

        if($_SESSION['logged_in'] == 1)
        {
            ?>
        <td><a href="#" onclick="add('<?php echo $isbn; ?>', '<?php echo $low_price; ?>', '<?php echo htmlentities(substr($title, 0, 50)); ?>', this); return false;"><button name="add">Add to My Books</button></a>
        <?php
          echo '<a href="#" onclick="removeElement(this.parentNode.parentNode); return false;"><button name="reject">Reject</button></a></td>';
        }
        else 
        {
          echo "<td>To add to your book queue, please <a href='login.php?id=2'><font color='3399FF'>login</font></a> or <a href='sign-up.php'><font color='3399FF'>register</font></a></td>";
        }
      echo '</tr>';
    }
    else 
    {
      $title = "Not Found";
      $price = "N/A";
      echo '<tr><td><b>'.$isbn.'</b></td><td colspan="4">Sorry, that book is too little in value for us to take.</td></tr>';
    }
  }
  catch(Exception $e)
  {
    $title = "Not Found";
    $price = "N/A";
    echo '<tr><td><b>'.$isbn.'</b></td><td colspan="4">Sorry, we could not find the textbook you are looking for. Check to see if you entered the ISBN correctly. Remember, it is a 10 or 13 digit number and <b>do not include dashes</b></td></tr>';
  }

  if($_SESSION['logged_in'] != 1)
  {
    log_search($isbn, 'Guest', $owner, $title, $price);
  }
  else 
  {
    $searcher = $_SESSION['screen_name'];  
    log_search($isbn, $searcher, $owner, $title, $price);
  }
}

function log_search($isbn, $searcher, $owner, $title, $price)
{
    $ip = VisitorIP();
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
    '$isbn',  '$searcher',  '$ip', 
    CURRENT_TIMESTAMP ,  '$owner',  '$title',  '$price'
    );";
    
    mysql_query($query);
}

function VisitorIP()
{ 
  if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
  else 
    $TheIp=$_SERVER['REMOTE_ADDR'];
 
  return trim($TheIp);
}
