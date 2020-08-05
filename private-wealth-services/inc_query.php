<?php
date_default_timezone_set('Africa/Lagos');
require_once ("Connections/conn.php");



mysqli_select_db($conn, $database_conn);
$query_lyt = "SELECT * FROM layout";
$lyt = mysqli_query($conn, $query_lyt) or die(mysqli_error($conn));
$row_lyt = mysqli_fetch_assoc($lyt);
$totalRows_lyt = mysqli_num_rows($lyt);

mysqli_select_db($conn, $database_conn);
$query_mgt = "SELECT * FROM management WHERE category = 'Management Team' AND rate_ord > '0' ORDER BY rate_ord ASC ";
$mgt = mysqli_query($conn, $query_mgt) or die(mysqli_error($conn));
$row_mgt = mysqli_fetch_assoc($mgt);
$totalRows_mgt = mysqli_num_rows($mgt);

mysqli_select_db($conn, $database_conn);
$query_bod = "SELECT * FROM management WHERE category = 'Board of Directors' AND rate_ord > '0' ORDER BY rate_ord ASC ";
$bod = mysqli_query($conn, $query_bod) or die(mysqli_error($conn));
$row_bod = mysqli_fetch_assoc($bod);
$totalRows_bod = mysqli_num_rows($bod);

mysqli_select_db($conn, $database_conn);
$slug = mysqli_real_escape_string($conn, $_GET['slug']);
$query_tm = "SELECT * FROM management WHERE slug = '$slug'";
$tm = mysqli_query($conn, $query_tm) or die(mysqli_error($conn));
$row_tm = mysqli_fetch_assoc($tm);
$totalRows_tm = mysqli_num_rows($tm);
$mgtcat = $row_tm['category'];

mysqli_select_db($conn, $database_conn);
$query_cattype = "SELECT * FROM management WHERE category = '$mgtcat' AND slug != '$slug' AND rate_ord > '0' ";
$cattype = mysqli_query($conn, $query_cattype) or die(mysqli_error($conn));
$row_cattype = mysqli_fetch_assoc($cattype);
$totalRows_cattype = mysqli_num_rows($cattype);
//$mgtcat = $row_tm['category'];

$query_faq = "SELECT * FROM faq WHERE category = 'trust-faq' AND rate_ord > '0' "; 
$faq = mysqli_query($conn, $query_faq) or die(mysqli_error($conn)); 
$row_faq = mysqli_fetch_assoc($faq);  

$query_willfaq = "SELECT * FROM faq WHERE category = 'will-faq' AND rate_ord > '0' "; 
$willfaq = mysqli_query($conn, $query_willfaq) or die(mysqli_error($conn)); 
$row_willfaq = mysqli_fetch_assoc($willfaq); 

$a = mysqli_real_escape_string($conn, $_GET['a']);  
$query_search = "SELECT * FROM content WHERE `content` LIKE '%$a%' OR `pg_name` LIKE '%$a%' OR `pg_cat` LIKE '%$a%' AND rate_ord > '0' ORDER BY id ASC";
$search = mysqli_query($conn, $query_search) or die(mysqli_error($conn));
$row_search = mysqli_fetch_assoc($search);
$totalRows_search = mysqli_num_rows($search);

function word_striperblog($summ){
  $original_string = $summ;
  $count = 30;
  $words = explode(' ', $original_string); //explode breaks a string into an array
            
  if (count($words) > $count){
    $words = array_slice($words, 0, $count); //start slicing ($words) from the first word and return $count number of words
    $summ = implode(' ', $words);
  }
  return $summ;
}

function word_striperblog2($summ2){
  $original_string = $summ2;
  $count = 20;
  $words = explode(' ', $original_string); //explode breaks a string into an array
            
  if (count($words) > $count){
    $words = array_slice($words, 0, $count); //start slicing ($words) from the first word and return $count number of words
    $summ2 = implode(' ', $words);
  }
  return $summ2;
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
  {
    Global $conn;
    if (PHP_VERSION < 6) {
      $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }

    $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($conn, $theValue) : mysqli_escape_string($conn, $theValue);

    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;    
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
        break;
      case "date":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }
}

$colname_page = "-1";
if (isset($_GET['a'])) {
  $colname_page = $_GET['a'];
}
mysqli_select_db($conn, $database_conn);
$query_page = sprintf("SELECT * FROM content WHERE pg_alias = %s", GetSQLValueString($colname_page, "text"));
$page = mysqli_query($conn, $query_page) or die(mysqli_error($conn));
$row_page = mysqli_fetch_assoc($page);
$totalRows_page = mysqli_num_rows($page);
$pagecat = $row_page['pg_cat'];
$incpage = $row_page['pg_url'];

mysqli_select_db($conn, $database_conn);
$query_rtd = sprintf("SELECT * FROM content WHERE pg_cat = '%s' AND pr_status = '0' AND rate_ord > '0' ORDER BY rate_ord ASC" , $pagecat);
$rtd = mysqli_query($conn, $query_rtd) or die(mysqli_error($conn));
$row_rtd = mysqli_fetch_assoc($rtd);
$totalRows_rtd = mysqli_num_rows($rtd);

if ($row_page['pg_type'] == "default") {
$pageinc = "inc_page.php";
}
elseif ($row_page['pg_type'] == "contact") {
$pageinc = "inc_contact.php";
}
elseif ($row_page['pg_type'] == "faq") {
$pageinc = "inc_faq.php";
}
elseif ($row_page['pg_type'] == "will-faq") {
$pageinc = "inc_will-faq.php";
}
elseif ($row_page['pg_type'] == "board") {
$pageinc = "inc_board.php";
}
elseif ($row_page['pg_type'] == "management") {
$pageinc = "inc_management.php";
}
elseif ($row_page['pg_type'] == "step-guide") {
$pageinc = "inc_step-guide.php";
}
elseif ($row_page['pg_type'] == "downloads") {
$pageinc = "inc_downloads.php";
}
elseif ($row_page['pg_type'] == "partners") {
$pageinc = "inc_partners.php";
}
elseif ($row_page['pg_type'] == "downloads") {
$pageinc = "inc_downloads.php";
}
elseif ($row_page['pg_type'] == "rsa-form") {
$pageinc = "inc_rsaform.php";
}
elseif ($row_page['pg_type'] == "fund1") {
$pageinc = "inc_fund1.php";
}
elseif ($row_page['pg_type'] == "fund2") {
$pageinc = "inc_fund2.php";
}
elseif ($row_page['pg_type'] == "fund3") {
$pageinc = "inc_fund3.php";
}
elseif ($row_page['pg_type'] == "fund4") {
$pageinc = "inc_fund4.php";
}
elseif ($row_page['pg_type'] == "multifund") {
$pageinc = "inc_multifund.php";
}
else {
$pageinc = "inc_page.php";
} 

?>