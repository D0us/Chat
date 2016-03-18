<!DOCTYPE html>
<html>
<head>

	<title>Chat</title>
	<meta charset="utf-8">

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.css"/>	 
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.timeago.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>

	<script>
	</script>

</head>
<body>

	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#">Chat</a>
	    </div>
	    <ul class="nav navbar-nav">
	      <li class="active"><a href="index.php">Home</a></li>
	      <li><a href="#">Login</a></li>
	    </ul>
	  </div>
	</nav>

	<div class="container">

		<h1>Chat</h1>
			<div id="chat-log">
				<div id="chat-log-top"></div>
					<!-- Messages go here -->
				<div id="chat-log-bottom"></div>
			</div>

			<form id="chat-box-input" class="form-inline">
				<label for="message-from-input">Name</label>
			    <input id="message-from-input" class="form-control" tabindex="2" type="text">
			    <label for="message-body-input">Text</label>
			    <input id="message-body-input" class="form-control" tabindex="1" type="text">
			    <input id="send-button" class="form-control" type="button" value="Send">
			    <p id="alert" style="display: none">Enter message</p>
			</div>
	</div>
</body>
</html>