/*
 * A scrollTo function that gets passed a selector (ID, class, element) & an optional offset
 *
 * @param {string}  location ('#resultsTop')
 * @param {integer} offset   (-100)
 */
function scrollTo(location, offset) {
    $("html, body").animate({scrollTop: ($(location).offset().top + (offset || 0) )}, "slow");
    return false;
};


$( document ).ready(function() {
	// scrollTo('#history-bottom', 500);
	$(function() {
  // scroll all the way down
  $('html, body').scrollTop($('#history').height() - $('#history').height());
});

});