<?php
include('../../functions.php');
session_start();

$isbn = trim($_GET['isbn']);  

search_isbn($isbn);
?>