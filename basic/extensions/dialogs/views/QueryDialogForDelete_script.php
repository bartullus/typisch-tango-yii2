// Start QueryDialogForDelete for callerClass="<?php echo $callerClass; ?>"
function initQueryDialogForDelete_<?php echo $callerClass; ?>() {

	//console.log ("+initQueryDialogForDelete_<?php echo $callerClass; ?>()");
	var buttons = $('.<?php echo $callerClass; ?>');
	
	jQuery.each(buttons, function (i, b) {

		// the url to open when clicked
		var url = $(b).attr('href');
		var dialog_id = $(this).attr('data-dialogId');
		var dlg = $('#'+dialog_id)
	
		$(b).click(function (event) {
			event.preventDefault();
			$(dlg).modal(<?php echo $options; ?>);
		});

	}); // each
		
	// event handler for all "ok" buttons
	$('.<?php echo $this->buttonClass('ok'); ?>').click(function (event) {
		//console.log("Ok clicked");
		event.preventDefault();
		dlg = $(this).parents('[role="dialog"]'); // the dialog of this button
		//console.log('Dlg id='+$(dlg).attr('id'));
		btn = $(dlg).prev('.btn'); // the delete button before this dialog
		//console.log('Btn name='+$(btn).attr('name'));
		btn_url = $(btn).attr('href');
		//console.log('Ok url='+btn_url);
		params = {};
		returnUrl = $(btn).attr('data-returnUrl');
		if (returnUrl != undefined) {
			params = {returnUrl: returnUrl};
			//console.log('returnUrl='+params.returnUrl);
		}
		jQuery.yii.submitForm(this, btn_url, params); 
	});
		
	// event handler for all "cancel" buttons (nothing to do)
	$('.<?php echo $this->buttonClass('cancel'); ?>').click(function (event) {
		//console.log('Cancel clicked');
		//event.preventDefault();
		//dlg = $(this).parents('[role="dialog"]'); // the dialog of this button
		//$(dlg).modal('close');
	});
	
	//console.log ("-initQueryDialogForDelete_<?php echo $callerClass; ?>()");
}
jQuery(document).ready(function () {
	initQueryDialogForDelete_<?php echo $callerClass; ?>();
	jQuery(document).ajaxComplete(initQueryDialogForDelete_<?php echo $callerClass; ?>);
});
// END QueryDialogForDelete for callerClass="<?php echo $callerClass; ?>"