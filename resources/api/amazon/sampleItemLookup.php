<?php
/**
 * For a running Search Demo see: http://amazonecs.pixel-web.org
 */

if ("cli" !== PHP_SAPI)
{
    echo "<pre>";
}


if (is_file('sampleSettings.php'))
{
  include 'sampleSettings.php';
}

defined('AWS_API_KEY') or define('AWS_API_KEY', 'API KEY');
defined('AWS_API_SECRET_KEY') or define('AWS_API_SECRET_KEY', 'SECRET KEY');
defined('AWS_ASSOCIATE_TAG') or define('AWS_ASSOCIATE_TAG', 'ASSOCIATE TAG');

require 'AmazonECS.class.php';

try
{
    $amazonEcs = new AmazonECS('AKIAI4Z5QGF45FO6A2NA', 'GFOKAPtm+Xe5REKUmpDk/T0Nisbw3KG1QdXnQqlt', 'DE', AWS_ASSOCIATE_TAG);

    // Looking up multiple items
    $response = $amazonEcs->category('Books')->search('PHP 5'); 
    var_dump($response);

}
catch(Exception $e)
{
  echo $e->getMessage();
}

if ("cli" !== PHP_SAPI)
{
    echo "</pre>";
}
