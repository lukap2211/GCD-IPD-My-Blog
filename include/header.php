<?php
/* session_start(); */
/*
echo("<pre>");
print_r($_SESSION);
echo("</pre>");
*/
?>
<!DOCTYPE html>
<html>
<head>
<title>Album Reviews</title>
<link type="text/css" rel="stylesheet"  href="css/style.css" />
</head>
<body>

<div class="frame shadow">
<section id="user_area">

<?php

if(isset($_SESSION['username'])){
    echo "Hi {$_SESSION['username']}, <a href='./logout.php'>Log Out</a>";
  }else{
    echo "<a href='./login.php'>Log in</a>";
  }


?>
</section>
<header>
<h1>Album Reviews</h1>
<ul id="main_menu">
	<li><a href="./?menu=home">home</a></li>
<!--
	<li><a href="./?menu=admin">admin</a></li>
	<li><a href="./?menu=search">search</a></li>
-->
</ul>
</header>

