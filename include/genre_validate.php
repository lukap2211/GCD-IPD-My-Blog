<?php
//validate genre input

/*
echo "<pre>";
print_r($_GET);
print_r($_POST);
echo "</pre>";
*/

// GET action 

if($_GET){
	
	// id
	if(!empty($_GET['gen_id']) && is_numeric($_GET['gen_id'])){
		$genre_id = $_GET['gen_id'];
	} else {
		$genre_id = NULL;
		$error = true;
	}
	
	// action
	if(!empty($_GET['action']) && in_array($_GET['action'],array('add','edit','delete' ,'view'))){
		$action = $_GET['action'];
	} else {
		$action = NULL;
		echo("<div class='error'>ERROR: please provide action</div>");
		$error = true;
	}
	
	// genre id not required for add
	if (!$genre_id && $_GET['action'] != "add"){
		echo("<div class='error'>ERROR: please enter genre ID as number</div>");
	}

} elseif($_POST) {		
		
	// POST action	
	// validate action
	if(!empty($_POST['action']) && in_array($_POST['action'],array('add','edit'))){
		$action_success = $_POST['action'];
	} else {
		$action_success = NULL;
		$error = true;
	}
	
	// genre
	if(!empty($_POST['genre'])){
		$genre = $_POST['genre'];
	} else {
		echo("<div class='error'>ERROR: Please enter genre as string!</div>");
		$genre = NULL;
		$error = true;
	}
	
	// id
	if(!empty($_POST['gen_id']) && is_numeric($_POST['gen_id'])){
		$gen_id = $_POST['gen_id'];
	}

}


?>