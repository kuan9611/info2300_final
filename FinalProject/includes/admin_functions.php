<?php

function get_page() {
	//Default to the first page
	$page = 1;

	//Check to see if a page was specified in the request
	$input_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT );
	if( ! empty( $input_page ) ) {

		if( $input_page > 1 ) {
			$page = $input_page;
		}
	}

	return $page;
}

function get_comments( $page = 1 ) {
	require_once 'includes/config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ( $mysqli->connect_error ) {
		die('Connect Error: ' . $mysqli->connect_error);
	}

	//Define the number of comments to show on each page
	$per_page = 10;

	$offset = $per_page * ( $page - 1);


	$comments = $mysqli->query("SELECT comment_id, username, Comments.content AS content, Comments.date AS date, Articles.title AS title   FROM Comments INNER JOIN Threads ON Comments.thread_id = Threads.thread_id INNER JOIN Articles ON Articles.article_id = Threads.article_id ORDER BY Comments.date DESC LIMIT $offset, $per_page");
	if (!$comments) {
		print($mysqli->error);
		exit();
	}	
	return $comments;
}        




//Return the row from the customer table for the given customer_id
function get_article_comments( ) {
	require_once 'includes/config.php';
	$article_id = filter_input( INPUT_GET, 'article_id', FILTER_SANITIZE_NUMBER_INT );
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ( $mysqli->connect_error ) {
		die('Connect Error: ' . $mysqli->connect_error);
	}

	$comments = $mysqli->query("SELECT comment_id, username, Comments.content AS content, Comments.date AS date, Articles.title AS title FROM Comments INNER JOIN Threads ON Comments.thread_id = Threads.thread_id INNER JOIN Articles ON Articles.article_id = Threads.article_id WHERE Articles.article_id = $article_id ORDER BY Comments.date DESC;");

	if (!$comments) {
		print($mysqli->error);
		exit();
	}	
	return $comments;
}

?>
