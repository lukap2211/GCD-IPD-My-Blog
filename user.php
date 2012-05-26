<?php
session_start();
// only for signed in users
if(!isset($_SESSION['username']) && (!isset($_GET['action']) || ($_GET['action']!='view'))){
	header("location:logout.php?login=false");
}

//get header
include("include/header.php");

// connect to database
require("include/connect.php");

// open main container
echo "<section id='container'>";

// user validation
include("include/user_validate.php");	

// user functions
include("include/user_functions.php");	

// check mode for GET
if($_GET){
	switch ($action){
		case 'add':
			if ($action) add_user();
			break;
		case 'view':
			if ($user_id) view_user($user_id,$action);
			break;
		case 'edit':
			if ($user_id) edit_user($user_id,$action);
			break;
		case 'delete':
			if ($user_id) delete_user($user_id,$action);
			break;
	}
} elseif($_POST) {	
	// add & edit submit
	switch ($action_success){
		case 'add':
			add_user_success($username,$password,$first_name,$last_name,$bio);
			break;
		case 'edit':
			edit_user_success($username,$password,$first_name,$last_name,$bio,$usr_id);
			break;
	}
}
// close main container
echo "</section>";

// sidebar
include("include/aside.php");	

//get footer
include("include/footer.php");

?>