$(document).ready( function() {

	get_images();

});

function get_images() {

	var offset = 0;

	$.ajax({
		method: 'GET',
		url: 'includes/chat_ajax.php',
		data: {
			'data': {function : 'get_images',
					 input : offset
					},
			'ajax': true
		},
		success: function(data) {

			alert(data);

			var images = JSON.parse(data);

			render_images(images);
		}
	});
}

function render_images(images) {

	for (var i = 0; i < images.length; i++) {
		var image = images[i];
		alert(image.url);
	}

}