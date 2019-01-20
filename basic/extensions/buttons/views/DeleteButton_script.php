// Start Button for class="<?php echo $buttonId; ?>"
function init<?php echo $buttonId; ?>(e) {
	
	//console.log("+ init<?php echo $buttonId; ?>()");
	
	//console.log("- init<?php echo $buttonId; ?>()");
}
jQuery(document).ready(function() {
	init<?php echo $buttonId; ?>();
	jQuery(document).ajaxComplete(init<?php echo $buttonId; ?>);
});
// End Button for class="<?php echo $buttonId; ?>"