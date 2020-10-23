<?php
require('classes/database.class.php');

use voku\helper\AntiXSS;

require_once __DIR__ . '/../vendor/autoload.php';

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

	case 'get_images':
		get_images($input);
	break;	

	case 'create_chatroom':
		create_chatroom($input);
	break; 

	case 'get_chatrooms':
		get_chatrooms();
	break;

}

function get_chatrooms() {

	$db = new database;
	$dbh = $db->connect();

	$chatrooms = $db->get_chatrooms($dbh);
	$encoded_rooms = json_encode($chatrooms);

	echo $encoded_rooms;

}

function create_chatroom($input) {

	$params = array(
		'name' => $input,
		'type' => 'Anonymous'
	);

	$db = new database;
	$dbh = $db->connect();

	$result = $db->create_chatroom($dbh, $params);

	echo $result;
}

function get_messages($input) {

	$params = array(
		'chatroom_id' => $input[0],
		'limit' => 10,
		'offset' => (int)$input[1]
	
	);


	$db = new database;
	$dbh = $db->connect();

	$history = $db->get_messages($dbh, $params);
	$history = array_reverse($history);

	$encoded_history = json_encode($history);
	echo $encoded_history;

}

function post_message($array) {

	$chatroom_id = (int) $array[0];
	if ($array[1] != '') { $message_from = sanitize_inputs($array[1]); }
	$message_body = sanitize_inputs($array[2]);

	$db = new database;
	$dbh = $db->connect();

	$db->add_message($dbh, $message_body, $message_from, $chatroom_id);

}

function get_images($offset) {

	$params = array(
		'limit' => 10,
		'offset' => (int)$offset
	);

	$db = new database;
	$dbh = $db->connect();

	$history = $db->get_images($dbh, $params);
	$history = array_reverse($history);

	$encoded_history = json_encode($history);
	echo $encoded_history;

}

function post_image($array) {

	$chatroom_id = $array[0];
	//delet this 
	$url = $array[1][0];

	$db = new database;
	$dbh = $db->connect();

	$db->add_image($dbh, $url, $chatroom_id);

}

function sanitize_inputs($input) {
   $antiXss = new AntiXSS();
   $harmless_string = $antiXss->xss_clean($input);
   return $harmless_string;
}

?>