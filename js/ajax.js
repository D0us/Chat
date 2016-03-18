$(document).ready( function() {

	window.global_msgcount = 0;

	get_messages();

	$('#message-body-input').focus();

	$('#send-button').click( function() { attempt_post(); });

	$(document).keypress(function(e) {
	    if(e.which == 13) {
	        attempt_post();
	    }
	});

	$('#chat-log').on('scroll', function() {

	    var scroll_pos = $('#chat-log').scrollTop();
        if (scroll_pos < 10) {

            get_messages(true);
        }
	});

	setInterval(function(){ 
	    get_messages();
	}, 1000);

});

function attempt_post() {

	if ($('#message-body-input').val()) {
		post_message();
		$('#message-body-input').val('');
	} else {
		alert('Please enter a message');
	}	
}

function post_message() {

	var message_body = $('#message-body-input').val();
	var message_from = $('#message-from-input').val();

	var message = [];
	message[0] = message_from;

	// alert(message[0]);
	message[1] = message_body;

	$.ajax({
		method: 'GET',
		url: 'includes/chat_ajax.php',
		data: {
			'data': {function : 'post_message',
					 input : message
					},
			'ajax': true
		},
		success: function(data) {
			get_messages();
		}
	});
}

function get_messages(load_old) {

	var offset = 0;
	if (load_old) {
		offset = window.global_msgcount;
	}

	$.ajax({
		method: 'GET',
		url: 'includes/chat_ajax.php',
		data: {
			'data': {function : 'get_messages',
					 input : offset
					},
			'ajax': true
		},
		success: function(data) {

			var messages = JSON.parse(data);

			for (var i = 0; i < messages.length; i++) {
				var message = messages[i];
				// console.log(message);
			}
			if (load_old) {
				render_messages(messages, load_old);		
			} else {
				render_messages(messages);
			}
		}
	});
}

function render_messages(messages, load_old) {

	var new_messages = false;

	for (var i = 0; i < messages.length; i++) {
		var message = messages[i];
		if (!document.getElementById(message.id)) {

			new_messages = true;

			var message_from = message.from;
			if (message.from === null) {
				message_from = 'Anon';
			}

			var message_html = '<div class="message-container" id="' + message.id + '">' + 	
			'<span id="message-from">' +  message_from + '</span>' +
			'<time id="message-date" class="timeago" datetime="' + message.dateadded + '">July 17, 2008</time>' +
			'<p id="message-body">' + message.body + '</p>';

			// $('p').html(function(i, text) {
			//     return text.replace(
			//         /\bhttp:\/\/([\w\.-]+\.)+[a-z]{2,}\/.+\b/gi,
			//         '<a href="$&">$&</a>'
			//     );
			// });
		
		    // $('<img>', {
		    //     src: message['body'],
		    //     error: function() { return; },
		    //     load: function() { 
		    //     	// alert(message['body']);
		    //     	message_html += '<div id="message-body-img">' + '<img src="' + message['body'] + '">' + '</div></div>';
		    //     	return message_html;
		    //     ;}
		    // });

		    // message_html += '</div>';

			// if (IsValidImageUrl(message['body'])) {
			// 	alert(message['body']);
			// 	message_html += '<div id="message-body-img">' + '<img src="' + message['body'] + '">' + '</div></div>';
			// }

			//If messages are new -> load after most recent displayed
			if (load_old) {
				$('#chat-log-top').after(message_html);
					window.global_msgcount++;
			} else {
				$('#chat-log-bottom').before(message_html);
				if (window.global_msgcount >= 100) {
					$('#chat-log-top').after().remove();
				} else {
					window.global_msgcount++;
				}				
			}
			console.log(message.id);

		}
	}

	if (new_messages && !load_old) {
		$('#chat-log').animate({
			scrollTop: $("#chat-log-bottom").offset().top
		}, 300);							
	// } else if (new_messages && load_old) {
	// 	$('#chat-log').animate({
	// 		scrollTop: $('#' + messages[messages.length-1].id).offset().top
	// 	}, 300);			
	}
	jQuery("time.timeago").timeago();

}

// function IsValidImageUrl(url) {

// 	valid = false;

//     $('<img>', {
//         src: url,
//         error: function(valid) { valid = false; return valid; },
//         load: function(valid) { valid  = true; return valid; }
//     });

//     return $('<img>').error;
// }


function loadImage(path, width, height, target) {
    $('<img src="'+ path +'">').load(function() {
      $(this).width(width).height(height).appendTo(target);
    });
}

