<?  
session_start();
session_destroy();

// header
include("include/header.php");

// open main container
echo "<section id='container'>";

//message
if(isset($_GET['login'])){
	echo "<div class='error'>You must be logged in to view this page</div>";
} else{
	echo "<div class='message'>You are logged out.</div>";
}

// close main container
echo "</section>";

// footer
include("include/footer.php");
?>