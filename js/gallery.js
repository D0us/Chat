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

			var images = JSON.parse(data);

			render_images(images);
		}
	});
}

function render_images(images) {

	for (var i = 0; i < images.length; i++) {
		var image = images[i];

		var image_html = '<div class="col-lg-3 col-md-4 col-xs-6 thumb">' +
                    	'<a class="thumbnail" href="' + image.url +'" target="_blank" >' +
                        	'<img class="img-responsive" src="' + image.url + '" alt="">' +
                    	'</a>' +
                	'</div>';
		$('#image-gallery-top').after(image_html);                	


	}

}