<?php
if (isset($_POST['submit'])) {
  header("Content-type: application/vnd.ms-word");
  header("Content-Disposition: attachment;Filename=".rand().".doc");
  //echo $_POST["content"];
}

?>