<?php

session_start();

if (!isset($_SESSION["user"])) {
	die( json_encode(array(
        	'success' => 0,
        	'message' => 'Sign in to delete comment'
    )) );
}

$comment_id = trim(filter_input(INPUT_POST, "cmt_id", FILTER_VALIDATE_INT));

require_once 'config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$query = "SELECT thread_id
		  FROM comments
		  WHERE comment_id = $comment_id";
if ($result = $mysqli->query($query)) {
	$thread_id = $result->fetch_row()[0];
} else {
	die( json_encode(array(
        	'success' => 0,
        	'message' => 'Cannot find comment in database'
    )) );
}

$query = "DELETE FROM comments
		  WHERE comment_id = $comment_id";
$mysqli->query($query);

$query = "SELECT COUNT(*)
		  FROM comments
		  WHERE thread_id = $thread_id";
$result = $mysqli->query($query);

if (((int) $result->fetch_row()[0]) === 0) {
	$query = "DELETE FROM threads
			  WHERE thread_id = $thread_id";
	$mysqli->query($query);
}

echo json_encode(array('success' => 1));

?>