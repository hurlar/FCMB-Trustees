<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"


$hostname_conn = "localhost";
$database_conn = "sr11apm4_wp926";
$username_conn = "sr11apm4_user";
$password_conn = "user@2018";

// Create connection
$conn = mysqli_connect($hostname_conn, $username_conn, $password_conn, $database_conn) or trigger_error(mysqli_connect_error(),E_USER_ERROR);

?>