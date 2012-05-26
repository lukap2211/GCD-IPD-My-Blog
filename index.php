<?php
session_start();
//validate input

/*
if(!empty($_GET['menu']) && is_string($_GET['menu'])){
	$menu=$_GET['menu'];
}else{
	$menu = NULL;
}
*/

// filter by GET
if(!empty($_GET['filter']) && ($_GET['filter'] === 'on' )){
	$filter = $_GET['filter'];
}else{
	$filter = NULL;
}

// search by POST
$filter_title = NULL;
//main search
if(!empty($_POST['search']) && is_string($_POST['search'])){
	$search = addslashes($_POST['search']);
	$filter = "and (UPPER(review) like UPPER('%{$search}%') ";
	$filter.= "or UPPER(artist) like UPPER('%{$search}%') ";
	$filter.= "or UPPER(genre) like UPPER('%{$search}%') ";
	$filter.= "or UPPER(year) like UPPER('%{$search}%') ";
	$filter.= "or UPPER(title) like UPPER('%{$search}%')) ";

	$search = stripslashes($_POST['search']);
	$filter_title = "Search results for: <em><strong>{$search}</strong></em>";
}

if($filter){

	// build filter

	// by year
	if(!empty($_GET['year']) && is_numeric($_GET['year'])){
		$filter = "and year = '{$_GET['year']}'";
		$filter_title = "Filter by year: <strong>{$_GET['year']}</strong>";

	}
	// by artist
	if(!empty($_GET['artist']) && is_string($_GET['artist'])){
		$filter = "and artist = '{$_GET['artist']}'";
		$filter_title = "Filter by artist: <strong>{$_GET['artist']}</strong>";

	}
	// by artist
	if(!empty($_GET['stars']) && is_numeric($_GET['stars'])){
		$filter = "and stars = '{$_GET['stars']}'";
		$filter_title = "Filter by stars: <img src='./images/stars_{$_GET['stars']}.png' alt='stars' />";

	}
	// by genre
	if(!empty($_GET['genre']) && is_string($_GET['genre'])){
		$filter = "and g.genre = '{$_GET['genre']}'";
		$filter_title = "Filter by genre: <strong>{$_GET['genre']}</strong>";

	}

	// by user
	if(!empty($_GET['genre']) && is_string($_GET['genre'])){
		$filter = "and g.genre = '{$_GET['genre']}'";
		$filter_title = "Filter by genre: <strong>{$_GET['genre']}</strong>";

	}

	
}


//open connection
require("include/connect.php");

// get 10 most recent reviews
$query = "SELECT a.id, a.title, a.artist, a.review, a.review_date, a.stars, a.year, u.usr_id, u.username, g.genre, g.gen_id";
$query.= " FROM albums a, users u, genres g";
$query.= " WHERE a.usr_id = u.usr_id and a.gen_id = g.gen_id $filter";
$query.= " ORDER BY a.review_date desc limit 0,10;";


$result = mysql_query($query, $conn);

// error check
if(!$result){

	echo "<div class='error'>ERROR: " . mysql_error() ."</div>";

} else {

	// header
	include("include/header.php");

	// open main container
	echo "<section id='container' class='shadow'>\n";
	
	// filter header
	if($filter_title){
		echo "<div class='header shadow'>$filter_title</div>";
	}

	// listing results
	echo "<ul class='albums_listing'>";
	while($row = mysql_fetch_array($result)){
		extract($row);

		$review = substr($review,0,390)."...";


		$list_albums = <<<LIST

	<li>
		<h2>{$title}</h2>
		<div class='published'>Published: <strong>{$review_date}</strong> by <a href='user.php?action=view&amp;id={$usr_id}'>{$username}</a></div>
		<div class='details'>
			<span class='artist'>Artist: <a href='index.php?filter=on&amp;artist={$artist}'>{$artist}</a></span> |
			<span class='year'>Year: <a href='index.php?filter=on&amp;year={$year}'>{$year}</a></span> |
			<span class='genre'>Genre: <a href='index.php?filter=on&amp;genre={$genre}'>{$genre}</a></span> |
			<span class='stars'>Stars: <a href='index.php?filter=on&amp;stars={$stars}'><img src='./images/stars_{$stars}.png' /></a></span>
		</div>
		<div class="clear"></div>
		<div class='review'>{$review}</div>
		<div class='full_review'><a href='album.php?id={$id}&amp;action=view'>Read full review</a></div>
	</li>

LIST;

		echo $list_albums;
	}
	
	echo "</ul>\n";

	// close main container
	echo "</section>";

	// sidebar
	include("include/aside.php");

	// footer
	include("include/footer.php");

}
?>