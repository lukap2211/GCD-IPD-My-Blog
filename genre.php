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

// genre validation
include("include/genre_validate.php");	

// genre functions
include("include/genre_functions.php");	

// check mode for GET
if($_GET){
	switch ($action){
		case 'add':
			if ($action) add_genre();
			break;
/*
		case 'view':
			if ($genre_id) view_genre($genre_id,$action);
			break;
*/
		case 'edit':
			if ($genre_id) edit_genre($genre_id,$action);
			break;
		case 'delete':
			if ($genre_id) delete_genre($genre_id,$action);
			break;
		case 'delete':
			break;
			
			
	}
} elseif($_POST) {	
	// add & edit submit
	switch ($action_success){
		case 'add':
			add_genre_success($genre);
			break;
		case 'edit':
			edit_genre_success($genre,$gen_id);
			break;
	}
}

global $error;
if (!$error){
	// get all genres
	$query = "select g.gen_id, g.genre FROM genres g ORDER BY genre";
	
	$result = mysql_query($query, $conn);
	
	// error check
	if(!$result){
		echo "<div class='error'>ERROR: " . mysql_error() ."</div>";
	}else{
	
		// listing results
		echo "<h2>Genres Listing</h2>";
		echo "<ul class='genres_listing'>";
		while($row = mysql_fetch_array($result)){
			extract($row);	
	
		$list_genres = <<<LIST
	
		<li>
			<div class='genre'>
				{$genre}
				<span><a class='edit' href='genre.php?action=edit&gen_id={$gen_id}'>Edit</a></span> 
				<span><a class='delete' href='genre.php?action=delete&gen_id={$gen_id}' onclick="if(!confirm('Delete?')) return false;">Delete</a></span> 
			<div class="clear"></div>
			</div>
		</li>
	
LIST;
	
		echo $list_genres;
		}
		
		echo "</ul>\n";
		echo "<a class='admin' href='genre.php?action=add'>Add Genre</a>";
	}

}
// close main container
echo "</section>";

// sidebar
include("include/aside.php");	

//get footer
include("include/footer.php");

?>