<?php

session_start();

if (!isset($_SESSION["user"])) {
	die( json_encode(array(
        	'success' => 0,
        	'message' => 'Sign in to post comment'
    )) );
}

$content = trim(filter_input(INPUT_POST, "cmt_content", FILTER_SANITIZE_STRING));
$article_id = trim(filter_input(INPUT_POST, "cmt_article", FILTER_VALIDATE_INT));

if (empty($content)) {
	die( json_encode(array(
        'success' => 0,
        'message' => 'Comment cannot be empty'
    )) );
}

require_once 'config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$mysqli->autocommit(false);
$success = true;

$query = "INSERT INTO Threads (article_id,on_map)
		  VALUES (?,0)";
$stmt = $mysqli->stmt_init();
$stmt->prepare($query);
$stmt->bind_param("i",$article_id);
if (!$stmt->execute()) {
	$success = false;
} else {

$stmt->close();
$new_thread_id = $mysqli->insert_id;

$query = "INSERT INTO Comments (thread_id, username, content)
		  VALUES (?,?,?)";
$stmt = $mysqli->stmt_init();
$stmt->prepare($query);
$stmt->bind_param("iss",$new_thread_id,$_SESSION["user"],$content);
if (!$stmt->execute()) {
	$success = false;
} else {
	$new_comment_id = $mysqli->insert_id;
}

}
$stmt->close();

if ($success) {
	$mysqli->commit();
	echo json_encode(array(
        'success' => 1,
        'content' => '<div class="section-thread" id="'.$new_thread_id.'st"><div class="section-comment" id="'.$new_comment_id.'sc"><b>'.$_SESSION["user"].'</b> (just now):<br>'.$content.'<br><a class="scomment-delete" id="'.$new_comment_id.'sd">Delete</a></div></div>'
    ));
} else {
	$mysqli->rollback();
	echo json_encode(array(
        'success' => 0,
        'message' => 'Failed to add comment to database'
    ));
}

$mysqli->close();

?>