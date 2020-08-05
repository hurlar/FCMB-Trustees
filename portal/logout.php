<?php require ('Connections/conn.php');
// Destroying All Sessions
if(session_destroy())
{
// Redirecting To Home Page
header("Location: index.php");
}
?>