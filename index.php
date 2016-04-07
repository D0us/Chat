<?php

require('includes/classes/database.class.php');

function get_chatrooms() {

	$db = new database;
	$dbh = $db->connect();

	$chatrooms = $db->get_chatrooms($dbh);
	return $chatrooms;
}
?>

<!DOCTYPE html>
<html>
<head>

	<title>Chat</title>
	<meta charset="utf-8">

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/index-style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.js"></script>	
	<script type="text/javascript" src="js/index.js"></script>

</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">

            <div class="navbar-header">
                <a class="navbar-brand" href="chat.html">Chat</a>
            </div>

            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="gallery.html">Image Archive</a></li>
                <li><a href="#">Contribute</a></li>
            </ul>
        </div>
    </nav>

	<div class="container">

	<input class="btn btn-info" id="display-chatroom-creation" type="button" value="Create Chatroom">
	<input class="btn btn-info" id="random-chatroom" type="button" value="Random Chatroom">

	<form id="create-chatroom-form" class="form-group">
		<label>Chatroom Name</label><input class="form-control" id="create-chatroom-name" type="text">	
		<label>Username</label><input class="form-control" id="create-chatroom-username" type="text">
		<label>Password</label><input class="form-control" id="create-chatroom-password" type="text">
		<label></label><input class="form-control" id="create-chatroom-button" type="button" value="Create Chatroom">
	</form>

		<div id="public-chats">
			<h2>Public Chats</h2>

			<table id="chat-table" class="display" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		                <th>Name</th>
		                <th>Status</th>
		                <th>User Count</th>
		                <th>Date Added</th>
		                <th>Join</th>
		            </tr>
		        </thead>
<!-- 		        <tfoot>	
		            <tr>
		                <th>Name</th>
		                <th>Status</th>
		                <th>User Count</th>
		                <th>Date Added</th>
		                <th>lol</th>
		            </tr>
		        </tfoot>
 -->		        <tbody>
 		            <?php
		            	$chatrooms = get_chatrooms();
		            	foreach ($chatrooms as $chatroom) {
		            		echo '<tr><td>' . $chatroom['name'] . '</td><td>' . $chatroom['type'] . '</td><td>count</td><td>' . $chatroom['dateadded'] . '</td><td><input type="button" class="join-chat" value="Join" onclick="location.href = \'chat.html?id=' . $chatroom['id'] . '\'"/></td>';
		            	}
		            ?>
		        </tbody>
		    </table>
		</div>
	</div>
</body>
</html>