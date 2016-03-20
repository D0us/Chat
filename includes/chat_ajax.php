<?php
require('classes/database.class.php');


$data = $_REQUEST['data'];

$function = $data['function'];
$input = $data['input'];

// $offset = 0;

switch ($function) {
	case 'post_message':
		post_message($input);
	break;

	case 'get_messages':
		get_messages($input);
	break;

	case 'post_image':
		post_image($input);
	break;
}


function get_messages($offset) {

	$params = array(
		'limit' => 10,
		'offset' => (int)$offset
	);


	$db = new database;
	$dbh = $db->connect();

	$history = $db->get_messages($dbh, $params);
	$history = array_reverse($history);

	$encoded_history = json_encode($history);
	echo $encoded_history;

}

function post_message($array) {

	if ($array[0] != '') { $message_from = sanitize_inputs($array[0]); }
	$message_body = sanitize_inputs($array[1]);

	$db = new database;
	$dbh = $db->connect();

	$db->add_message($dbh, $message_body, $message_from);

}

function get_images($offset) {

	$params = array(
		'limit' => 10,
		'offset' => (int)$offset
	);


	$db = new database;
	$dbh = $db->connect();

	$history = $db->get_images($dbh, $params);

	echo $history;

	// $history = array_reverse($history);

	// $encoded_history = json_encode($history);
	// echo $encoded_history;

}

function post_image($array) {

	$url = $array[0];

	$db = new database;
	$dbh = $db->connect();

	$db->add_image($dbh, $url);

}

function sanitize_inputs($input) {
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
	/*  
	'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
    */
  );
 
    $output = preg_replace($search, '', $input);
    return $output;
}


?>