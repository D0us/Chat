$(document).ready( function() {
	
	var $create_chatroom_display = false;

	$('#display-chatroom-creation').click( function() {
		  // $('#create-chatroom-form').show('fast', function() {
		  //   // Animation complete.
		  // });
		  $('#create-chatroom-form').css('display', 'block');
		  var $create_chatroom_display = true;
	});



	$('#create-chatroom-button').click( function() { 
		$chatroom_name = $('#create-chatroom-username').val();
		if ($chatroom_name !== '') {
			create_chatroom($chatroom_name);
		} else {
			alert('please enter chatroom name');
		}
	});

    $('#chat-table').DataTable( {
        // "scrollY":        "50%",
        "scrollCollapse": true,
        "paging":         false
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
			alert(data);
		}
	});
}

function get_chatrooms() {
	return;
}