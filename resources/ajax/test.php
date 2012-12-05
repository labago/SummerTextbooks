  <?php

  $isbn = trim($_GET['isbn']);   
    
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
  } 
    catch(Exception $e)
  {
    echo 'Sorry, we could not find the textbook you are looking for. Check to see if you entered the ISBN correctly. Remember, it is a 10 or 13 digit number and <b>do not include dashes</b></td></tr>';
  }
?>