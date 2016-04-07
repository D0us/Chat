$(document).ready( function() {

	// alert(get_chatrooms());
	// get_chatrooms();
	
	var $create_chatroom_display = false;

	$('#display-chatroom-creation').click( function() {
		  // $('#create-chatroom-form').show('fast', function() {
		  //   // Animation complete.
		  // });
		  $('#create-chatroom-form').css('display', 'block');
		  var $create_chatroom_display = true;
	});



	$('#create-chatroom-button').click( function() { 
		$chatroom_name = $('#create-chatroom-name').val();
		if ($chatroom_name !== '') {
			create_chatroom($chatroom_name);
		} else {
			alert('please enter chatroom name');
		}
	});

    $('#chat-table').DataTable( {
        // "scrollY":        "50%",
        // "scrollCollapse": true,
        "paging":   true,
        "ordering": true,
        "info":     true
    });

});

function create_chatroom(chatroom_name) {

	// var chatroom_name = 'name';

	$.ajax({
		method: 'GET',
		url: 'includes/chat_ajax.php',
		data: {
			'data': {function : 'create_chatroom',
					 input : chatroom_name 
					},
			'ajax': true
		},
		success: function(data) {
			//function returns id, make json array with success/failure
			alert(data);
			window.location.href = 'chat.html?id=' + data;
		}
	});
}

function get_chatrooms() {
	$.ajax({
		method: 'GET',
		url: 'includes/chat_ajax.php',
		data: {
			'data': {function : 'get_chatrooms' 
					},
			'ajax': true
		},
		success: function(data) {

			var rooms = JSON.parse(data);

			// render_chatrooms(rooms);

		}
	});
}

function render_chatrooms(rooms) {
	for (i = 0; i < rooms.length; i++){
		var chatroom = rooms[i];

		var html = '<tr>' +
						'<td>' + chatroom['name'] + '</td></td>' +
		                '<td>' + chatroom['type'] + '</td>' +
		                '<td>:^)</td>' +
		                '<td>' + chatroom['dateadded'] + '</td>' +
		                '<td><input type="button" class="join-chat" value="Join" onclick="location.href = "chat.html""/></td>' +
		            '</tr>'

		$('#chat-table').append(html);

	}
}