<?php

$isbn = $_GET['isbn'];

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
    $response = $amazonEcs->responseGroup('Large')->optionalParameters(array('Condition' => 'Used'))->lookup($isbn);
    var_dump($response->Items);

    echo "Title: ".$response->Items->Item->ItemAttributes->Title."<br>";
    echo "<img src='".$response->Items->Item->MediumImage->URL."'><br>";
    echo "Price: ".$response->Items->Item->OfferSummary->LowestUsedPrice->FormattedPrice."<br>";
    echo "Rank: ".$response->Items->Item->SalesRank."<br>";

}
catch(Exception $e)
{
  echo $e->getMessage();
}
