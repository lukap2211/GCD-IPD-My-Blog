<?php
//genre functions
function view_genre($gen_id,$action){

	global $conn;

	// get genre
	$query = "SELECT g.gen_id, g.genre ";
	$query.= " FROM genres g";
	$query.= " WHERE g.gen_id = $gen_id;";
		
	$result = mysql_query($query,$conn);	
		
	while($row = mysql_fetch_array($result)){
		extract($row);

	//view genre details
	$view_genre = <<<VIEW

<article class='header shadow'>
	<h2>{$genre}</h2>
	<div class="clear"></div>


VIEW;

	echo $view_genre;
	}
	
	// admin section
	if(isset($_SESSION['username'])){
		$admin_section = <<<ADMIN

		<ul class="admin_area">
			<li><a class="admin delete" href='genre.php?gen_id={$gen_id}&amp;action=delete' onclick="if(!confirm('Delete?')) return false;">Delete genre</a></li>
			<li><a class="admin" href='genre.php?gen_id={$gen_id}&amp;action=edit'>Edit genre</a></li>
	
		</ul>

</article>\n
ADMIN;
	echo $admin_section;
		
	
	}
	echo "</ul>";
		
}

function add_genre(){

	global $conn;

	//add genre details
	$add_genre = <<<ADD

<article class='header shadow'>
	<h2>Add Genre</h2>
	<form action="genre.php" method="post">
	<p>
		<label>Genre:</label>	
		<input type="text" name="genre" value="" />	
	</p>	
	<input type="hidden" name="action" value="add" />
	<p><input class="admin" type="submit" /> <a class="" href="genre.php"/>Cancel</a></p>
	</form>	
	
</article>\n

ADD;

	echo $add_genre;
}

function add_genre_success($genre){

	global $conn,$error;
	
	if ($error) {
		add_genre();
	} else {
	
		// get genre details
		$query = "INSERT INTO genres ";
		$query.= " (genre)";
		$query.= " VALUES ('{$genre}');";
		
/* 		echo "Query: $query"; */

		$result = mysql_query($query,$conn);
		
		if ($result){
			echo "<div class='message'>Genre added! </div>";
		} else {
			printf("<div class='error'>ERROR: %s! </div>",mysql_error());		
		}
		view_genre(mysql_insert_id(),'view');
	}
}

function edit_genre($gen_id,$action){

	global $conn;

	// get genre
	$query = "SELECT g.gen_id, g.genre";
	$query.= " FROM genres g";
	$query.= " WHERE g.gen_id = $gen_id;";
	
	$result = mysql_query($query,$conn);	
		
	while($row = mysql_fetch_array($result)){
		extract($row);

	//edit album details
	$edit_genre = <<<EDIT

<article class='header shadow'>
	<h2>Edit Genre</h2>
	<form action="genre.php" method="post">
	<p>
		<label>Genre:</label>	
		<input type="text" name="genre" value="{$genre}" />	
	</p>	
	<input type="hidden" name="action" value="edit" />
	<input type="hidden" name="gen_id" value="{$gen_id}" />
	<p><input class="admin" type="submit" /> <a class="" href="genre.php"/>Cancel</a></p>
	</form>	
	
</article>\n

EDIT;

		echo $edit_genre;
	}
}

function edit_genre_success($genre,$gen_id){

	global $conn,$error;

	if ($error) {
/* 		edit_genre(); */
	} else {

		// update genre
		$query = "UPDATE genres";
		$query.= " SET genre = '{$genre}' "; 
		$query.= " WHERE gen_id= {$gen_id};";
				
/* 		echo "Query: $query"; */
		
		$result = mysql_query($query,$conn);
		
		if ($result){
			echo "<div class='message'>Genre details updated! </div>";
		} else {
			printf("<div class='error'>ERROR: %s! </div>",mysql_error());		
		}
			
		view_genre($gen_id,'view');
	}
}

function delete_genre($gen_id,$action){

	global $conn;
	
	//check if genre exist
	$query = "SELECT gen_id FROM genres WHERE gen_id = $gen_id;";
	$result = mysql_query($query,$conn);

	if (mysql_num_rows($result) < 1) {
		echo "<div class='error'>ERROR: Genre id = $gen_id doesn't exist! </div>";
	} else {
	
		// delete genre
		$query = "DELETE FROM genres WHERE gen_id = $gen_id;";
		$result = mysql_query($query,$conn);
	
		if ($result){
			echo "<div class='message'>Genre deleted! </div>";
		} else {
			printf("<div class='error'>ERROR: %s! </div>",mysql_error());		
		}
	}
}
?>