<?php

session_start();

if (!isset($_SESSION["user"])) {
	die( json_encode(array(
        	'success' => 0,
        	'message' => 'Sign in to post comment'
    )) );
}

$content = trim(filter_input(INPUT_POST, "cmt_content", FILTER_SANITIZE_STRING));
$latitude = trim(filter_input(INPUT_POST, "cmt_lat", FILTER_VALIDATE_FLOAT));
$longitude = trim(filter_input(INPUT_POST, "cmt_lng", FILTER_VALIDATE_FLOAT));
$article_id = trim(filter_input(INPUT_POST, "cmt_article", FILTER_VALIDATE_INT));

if (empty($content)) {
	die( json_encode(array(
        'success' => 0,
        'message' => 'Comment cannot be empty'
    )) );
}

require_once 'config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$query = "INSERT INTO Comments (content, article_id, username, 
								x_coord, y_coord)
		  VALUES (?,?,?,?,?)";
$stmt = $mysqli->stmt_init();
if ($stmt->prepare($query)) {
	$stmt->bind_param("sisdd",
					  $content,
					  $article_id,
					  $_SESSION["user"],
					  $longitude,
					  $latitude);
	$stmt->execute();
}

if ($mysqli->affected_rows > 0) {
	echo json_encode(array(
        'success' => 1,
        'content' => $content
    ));
} else {
	echo json_encode(array(
        'success' => 0,
        'message' => 'Failed to add comment to database'
    ));
}

?>