<?php

session_start();

if (!isset($_SESSION["user"])) {
	die( json_encode(array(
        	'success' => 0,
        	'message' => 'Sign in to post reply'
    )) );
}

$content = trim(filter_input(INPUT_POST, "rpl_content", FILTER_SANITIZE_STRING));
$thread_id = trim(filter_input(INPUT_POST, "thr_id", FILTER_VALIDATE_INT));

if (empty($content)) {
	die( json_encode(array(
        'success' => 0,
        'message' => 'Comment cannot be empty'
    )) );
}

require_once 'config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$query = "INSERT INTO Comments (thread_id, username, content)
		  VALUES (?,?,?)";
$stmt = $mysqli->stmt_init();
$stmt->prepare($query);
$stmt->bind_param("iss",$thread_id,$_SESSION["user"],$content);
if ($stmt->execute()) {
    $new_comment_id = $mysqli->insert_id;
	echo json_encode(array(
        'success' => 1,
        'id' => $thread_id,
        'content' => '<div class="section-comment" id="'.$new_comment_id.'sc"><b>'.$_SESSION["user"].'</b> (just now):<br>'.$content.'<br><a class="scomment-delete" id="'.$new_comment_id.'sd">delete</a></div>'
    ));
} else {
	echo json_encode(array(
        'success' => 0,
        'message' => 'Failed to add comment to database'
    ));
}
$stmt->close();

$mysqli->close();

?>