<?php 

	//open connection
	require("include/connect.php");
	
	// header
	include("include/header.php");

	// open main container
	echo "<section id='container'>";

	// login form
	include("include/login_form.php");
	
	// close main container
	echo "</section>";

	// footer
	include("include/footer.php");

	//close connection
	mysql_close($conn);

?>