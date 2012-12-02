<?php
include('../../functions.php');

$isbn = trim($_GET['isbn']);  

search_isbn($isbn);
?>