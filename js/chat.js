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
			check_for_images(message_body);
			get_messages();
		}
	});
}

function post_image(url) {

	$.ajax({
		method: 'GET',
		url: 'includes/chat_ajax.php',
		data: {
			'data': {function : 'post_image',
					 input : url
					},
			'ajax': true
		},
		success: function(data) {
			alert("posted img!");
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

			// for (var i = 0; i < messages.length; i++) {
			// 	var message = messages[i];
			// 	// console.log(message);
			// }
			
			if (load_old) {
				render_old_messages(messages);		
			} else {
				render_messages(messages);
			}
		}
	});
}

function render_old_messages(messages) {
	var new_messages = false;

	for (var i = messages.length-1; i > 0; i--) {
		var message = messages[i];
		if (!document.getElementById(message.id)) {

			new_messages = true;


			var message_from = message.from;
			if (message.from === null) {
				message_from = 'Anon';
			}

			//create message html
			var message_html = '<div class="message-container" id="' + message.id + '">' + 	
			'<span id="message-from">' +  message_from + '</span>' +
			'<time id="message-date" class="timeago" datetime="' + message.dateadded + '">July 17, 2008</time>' +
			'<p id="message-body">' + linkify(message.body) + '</p></div>';

			//insert html into top
			$('#chat-log-top').after(message_html);
			window.global_msgcount++;

			//  if (new_messages ) {
			// 	$('#chat-log').animate({
			// 		scrollTop: $('#' + messages[messages.length-1].id).offset().top
			// 	}, 300);			
			// }

			jQuery("time.timeago").timeago();
		}
	}

}

function render_messages(messages) {

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
			'<p id="message-body">' + linkify(message.body) + '</p></div>';

			$('#chat-log-bottom').before(message_html);
			if (window.global_msgcount >= 300) {
				$('#chat-log-top').after().remove();
			} else {
				window.global_msgcount++;
			}				

			console.log(message.id);

		}
	}

	if (new_messages) {
		$('#chat-log').animate({
			scrollTop: $("#chat-log-bottom").offset().top
		}, 100);							
	}
	jQuery("time.timeago").timeago();

}

function check_for_images(text) {
    var url, pattern1, pattern2;

	//URLs starting with http://, https://, or ftp:// with image formats
    pattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|].(jpg|png|gif))/gim;
    url = text.match(pattern1);
    // several urls in same text? for url in urls
    if (url) {
    	post_image(url);

    }

	// //URLs starting with "www." with image formats 
    pattern2 = /(^|[^\/])(www\.[\S]+(\b|$).(jpg|png|gif))/gim;
    url = text.match(pattern2);
    if (url) {
    	post_image(url);
    }

}

//http://stackoverflow.com/questions/37684/how-to-replace-plain-urls-with-links
function linkify(inputText) {
    var replacedText, replacePattern1, replacePattern2, replacePattern3;

    // //URLs starting with http://, https://, or ftp://
    // replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
    // replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank">$1</a>');

    // //URLs starting with "www."
    // replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    // replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank">$2</a>');

    // //Change email addresses to mailto:: links.
    // replacePattern3 = /(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
    // replacedText = replacedText.replace(replacePattern3, '<a href="mailto:$1">$1</a>');

	//URLs starting with http://, https://, or ftp:// with image formats
    replacePattern4 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|].(jpg|png|gif))/gim;
    replacedText = inputText.replace(replacePattern4, '<img class="posted-img img-responsive " src="$1" />');

	// //URLs starting with "www." with image formats 
    replacePattern5 = /(^|[^\/])(www\.[\S]+(\b|$).(jpg|png|gif))/gim;
    replacedText = replacedText.replace(replacePattern5, '<img class="posted-img img-responsive" src="$1" />');

    return replacedText;
}


function loadImage(path, width, height, target) {
    $('<img src="'+ path +'">').load(function() {
      $(this).width(width).height(height).appendTo(target);
    });
}

