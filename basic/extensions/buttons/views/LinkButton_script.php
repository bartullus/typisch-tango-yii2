// START button function for buttonId="<?php echo $buttonId; ?>"
function init<?php echo $buttonId; ?>(e) {
	
	//console.log("+ init<?php echo $buttonId; ?>()");
	var buttons = jQuery('.<?php echo $buttonId; ?>');
	
	jQuery.each(buttons, function (i, b) {
	
		$(b).click(function(event) {
			event.preventDefault();
			var href = $(this).attr('href');
			window.location.href = href;
		});
		
	});
	//console.log("- init<?php echo $buttonId; ?>()");
}
jQuery(document).ready(function() {
	init<?php echo $buttonId; ?>();
	jQuery(document).ajaxComplete(init<?php echo $buttonId; ?>);
});
// END button function for buttonId="<?php echo $buttonId; ?>"