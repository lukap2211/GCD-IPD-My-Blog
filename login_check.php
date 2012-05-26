<?php 
// login check
ob_start();

// login form validation
$error_message = NULL;

// validate username
if(!empty($_POST['username']) && is_string($_POST['username'])){
	$username = $_POST['username'];
}else{
	$error_message = "<li>Please insert username</li>";
	$username = NULL;
}

// validate password
if(!empty($_POST['password']) && is_string($_POST['password'])){
	$password = $_POST['password'];
}else{
	$error_message .= "<li>Please insert password</li>";
	$password = NULL;
}

if(!$error_message){
	//open connection
	require("include/connect.php");
	
	// MySQL injection prevention
	if (!get_magic_quotes_gpc()) {
		$username = stripslashes($username);
		$password = stripslashes($password);
	}
	$username = mysql_real_escape_string($username,$conn);
	$password = mysql_real_escape_string($password,$conn);

	// check if there is a match in db
	$query = "SELECT * FROM users WHERE username='$username' AND password ='$password'";
/* 	echo $query; */
	$result = mysql_query($query);
	$count = mysql_num_rows($result);
	if($count==1){
		while($row = mysql_fetch_array($result)){
			extract($row);
			// register $username, $password and redirect to file "login_success.php"
			session_register("username");
			session_register("password"); 
			session_register("usr_id","$usr_id");
			header("location:login_success.php");
		} 
		
	} else {
		// error
		$error_message .= "<li>Wrong username or password</li>";
	}
		
}

// header
include("include/header.php");

// open main container
echo "<section id='container'>";

// throw error;
echo "<div class='error'><ul>$error_message</ul></div>";

// login form
include("include/login_form.php");

// close main container
echo "</section>";

// footer
include("include/footer.php");

ob_end_flush();

?>