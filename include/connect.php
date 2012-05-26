<?php
//database settings 
//localhost
//$host="localhost"; $db_username="root"; $db_password="root"; $database="my_blog";

//remote
$host="localhost"; $db_username="lukapin_student"; $db_password="Student123"; $database="lukapin_ipd";


// database connection
$conn = mysql_connect($host, $db_username, $db_password) or die(mysqli_connect_error());
mysql_select_db($database) or die("ERROR: can not select database!") ;

?>