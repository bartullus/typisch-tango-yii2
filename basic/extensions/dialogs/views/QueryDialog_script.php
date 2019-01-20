// Start QueryDialog [<?php echo $id; ?>]
function initQueryDialog_<?php echo $id; ?>() {

	$('<?php echo $callerIdent; ?>').click(function (event) {
		event.preventDefault();
		$('#<?php echo $id; ?>').modal(<?php echo $options; ?>);
	});
	
	$('.<?php echo $this->buttonClass('ok'); ?>').click(function (event) {
		event.preventDefault();
		//alert('Ok clicked');
		window.location.href = '<?php echo $targetUrl; ?>';
	});
	
	$('.<?php echo $this->buttonClass('cancel'); ?>').click(function (event) {
		event.preventDefault();
		//alert('Cancel clicked');
		$('#<?php echo $id; ?>').modal('close');
	});
}
jQuery(document).ready(function () {
	initQueryDialog_<?php echo $id; ?>();
});
// END QueryDialog [<?php echo $id; ?>]
