<?php

	require_once 'admin_functions.php';
	$page = get_page();
	$result = get_comments( $page );

	$all_rows = fetch_all( $result );

	$response = array(
		'comments' => $all_rows,
	);
	//Convert and print the array in json format
	print( json_encode( $response ) );

	// Tell PHP to send the data now
	die();

	function fetch_all( $result ){
		$new_result = array();
		while ( $row = $result->fetch_assoc() ) {
			$new_result[] = $row;
		}
		return $new_result;
	 }
?>