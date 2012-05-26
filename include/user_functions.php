<?php
//user functions
function view_user($usr_id,$action){

	global $conn;

	// get user
	$query = "SELECT u.usr_id, u.username, u.bio, u.first_name, u.last_name";
	$query.= " FROM users u";
	$query.= " WHERE u.usr_id = $usr_id;";
		
	$result = mysql_query($query,$conn);	
		
	while($row = mysql_fetch_array($result)){
		extract($row);

	$bio = nl2br($bio);
	//view user details
	$view_user = <<<VIEW

<article class='header shadow'>
	<h2>{$username}</h2>
		<div class='user_details'>
			<span >First Name: {$first_name}</span></a><br />
			<span >Last name: {$last_name}</span> </a><br />
		</div>
	<div class="clear"></div>
	<div class='bio'>{$bio}</div>

VIEW;

	echo $view_user;
	}
	
	// admin section
	if(isset($_SESSION['username'])){
		$admin_section = <<<ADMIN

		<ul class="admin_area">
			<li><a class="admin delete" href='user.php?id={$usr_id}&amp;action=delete' onclick="if(!confirm('Delete?')) return false;">Delete User</a></li>
			<li><a class="admin" href='user.php?id={$usr_id}&amp;action=edit'>Edit User</a></li>
	
		</ul>
ADMIN;
	echo $admin_section;
	}	
	
	echo"</article>\n";
	
	// get 10 most recent reviews by user
	$query = "SELECT a.id, a.title, a.artist, a.review, a.review_date, a.stars, a.year, u.usr_id, u.username, g.genre, g.gen_id";
	$query.= " FROM albums a, users u, genres g";
	$query.= " WHERE a.usr_id = u.usr_id and a.gen_id = g.gen_id and u.usr_id= {$usr_id}";
	$query.= " ORDER BY a.review_date desc limit 0,10;";
	
	$result = mysql_query($query, $conn);
	
	// error check
	if(!$result){
		echo "<div class='error'>ERROR: " . mysql_error() ."</div>";
	} else {	
		// listing results
		echo "<ul class='albums_listing'>";
		while($row = mysql_fetch_array($result)){
			extract($row);	
	
			$review = substr($review,0,400)."...";
			$list_reviews_by_user = <<<LIST

	<li>
		<h2>{$title}</h2>
		<div class='published'>Published: <strong>{$review_date}</strong> by <a href='user.php?action=view&amp;id={$usr_id}'>{$username}</a></div>
		<div class='details'>
			<span class='artist'>Artist: <a href='index.php?filter=on&artist={$artist}'>{$artist}</a></span> | 
			<span class='year'>Year: <a href='index.php?filter=on&year={$year}'>{$year}</a></span> | 
			<span class='genre'>Genre: <a href='index.php?filter=on&genre={$genre}'>{$genre}</a></span> |
			<span class='stars'>Stars: <a href='index.php?filter=on&stars={$stars}'><img src='./images/stars_{$stars}.png' alt='stars' /></a></span>
		</div>
		<div class="clear"></div>
		<div class='review'>{$review}</div>
		<div class='full_review'><a href='album.php?id={$id}&amp;action=view'>Read full review</a></div>
	</li>

LIST;

			echo $list_reviews_by_user;
		}
		echo "</ul>";
	}	
		
}

function add_user(){

	global $conn;

	//add user details
	$add_user = <<<ADD

<article>
	<h2>Add User</h2>
	<form action="user.php" method="post">
	<p>
		<label>Username:</label>	
		<input type="text" name="username" value="" />	
	</p>	
	<p>
		<label>Password:</label>	
		<input type="password" name="password" value="" />	
	</p>	
	<p>
		<label>First Name:</label>	
		<input type="text" name="first_name" value="" />	
	</p>	

	<p>
		<label>Last Name:</label>	
		<input type="text" name="last_name" value="" />	
	</p>
	<div class='review'>
		<label>Bio:</label>
		<textarea rows="20" cols="70" name="bio"></textarea>
		<div class="clear"></div>
	</div>
	<input type="hidden" name="action" value="add" />
	<p><input class="admin" type="submit" /></p>
	</form>	
	
</article>\n

ADD;

	echo $add_user;
}

function add_user_success($username,$password,$first_name,$last_name,$bio){

	global $conn,$error;
	
	if ($error) {
		add_user();
	} else {
	
		// get user details
		$query = "INSERT INTO users ";
		$query.= " (username, password, bio, first_name, last_name)";
		$query.= " VALUES ('{$username}','{$password}', '{$bio}', '{$first_name}', '{$last_name}');";
		
/* 		echo "Query: $query"; */
		
		$result = mysql_query($query,$conn);
		
		if ($result){
			echo "<div class='message'>User added!</div>";
		} else {
			printf("<div class='error'>ERROR: %s!</div>",mysql_error());		
		}
		
		view_user(mysql_insert_id(),'view');
	}
}

function edit_user($usr_id,$action){

	global $conn;

	// get user
	$query = "SELECT u.usr_id, u.username, u.password, u.bio, u.first_name, u.last_name";
	$query.= " FROM users u";
	$query.= " WHERE u.usr_id = $usr_id;";
	
	$result = mysql_query($query,$conn);	
		
	while($row = mysql_fetch_array($result)){
		extract($row);

	//edit user details
	$edit_user = <<<EDIT

<article>
	<h2>Edit User</h2>
	<form action="user.php" method="post">
	<p>
		<label>Username:</label>	
		<input type="text" name="username" value="{$username}" />	
	</p>	
	<p>
		<label>Password:</label>	
		<input type="password" name="password" value="{$password}" />	
	</p>	
	<p>
		<label>First Name:</label>	
		<input type="text" name="first_name" value="{$first_name}" />	
	</p>	

	<p>
		<label>Last Name:</label>	
		<input type="text" name="last_name" value="{$last_name}" />	
	</p>
	<div class='review'>
		<label>Bio:</label>
		<textarea rows="20" cols="70" name="bio">{$bio}</textarea>
		<div class="clear"></div>
	</div>
	<input type="hidden" name="action" value="edit" />
	<input type="hidden" name="usr_id" value="{$usr_id}" />
	<p><input class="admin" type="submit" /> <a class="" href="user.php?action=view&amp;id={$usr_id}"/>Cancel</a></p>
	</form>	
	
</article>\n

EDIT;

		echo $edit_user;
	}
}

function edit_user_success($username,$password,$first_name,$last_name,$bio,$usr_id){

	global $conn,$error;
	

	if ($error) {
/* 		edit_user(); */
	} else {

		// update user
		$query = "UPDATE users";
		$query.= " SET username = '{$username}', password = '{$password}', bio = '{$bio}', "; 
		$query.= " first_name = '{$first_name}', last_name = '{$last_name}'";
		$query.= " WHERE usr_id= {$usr_id};";
				
/* 		echo "Query: $query"; */
		
		$result = mysql_query($query,$conn);
		
		if ($result){
			echo "<div class='message'>User details updated! </div>";
		} else {
			printf("<div class='error'>ERROR: %s! </div>",mysql_error());		
		}
			
		view_user($usr_id,'view');
	}
}

function delete_user($usr_id,$action){

	global $conn;

	//check if user exist
	$query = "SELECT usr_id FROM users WHERE usr_id = $usr_id;";
	$result = mysql_query($query,$conn);
	if (mysql_num_rows($result) < 1) {
		echo "<div class='error'>ERROR: User id = $usr_id doesn't exist!</div>";
	} else {

		// delete user
		$query = "DELETE FROM users WHERE usr_id = $usr_id;";
		$result = mysql_query($query,$conn);
	
		if ($result){
			echo "<div class='message'>User deleted! </div>";
		} else {
			printf("<div class='error'>ERROR: %s! </div>",mysql_error());		
		}	
	}
}
?>