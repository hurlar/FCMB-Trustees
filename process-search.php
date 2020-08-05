<?php
session_start();
ob_start();

require_once('Connections/conn.php');

$search_p = $_POST['search'];
$search_p = stripslashes($search_p);
$search_p = mysqli_real_escape_string($conn, $search_p);



mysqli_select_db($conn, $database_conn);
$query_search = "SELECT * FROM content WHERE `content` LIKE '%.$search_p.%' OR `pg_name` LIKE '%.$search_p.%' OR `pg_cat` LIKE '%.$search_p.%' ORDER BY id ASC";
$search = mysqli_query($conn, $query_search) or die(mysqli_error());
$row_search = mysqli_fetch_assoc($search);
$totalRows_search = mysqli_num_rows($search);


header("Location: search.php?a=$search_p"); 

?>