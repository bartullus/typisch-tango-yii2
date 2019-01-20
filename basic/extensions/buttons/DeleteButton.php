<?php
namespace app\extensions\buttons;

/**
 * DeleteButton
 *
 * displays a button with 'DeleteDialog' before really call delete-URL
 * 
 * @author herbert
 */

Yii::import('app.extensions.buttons.LinkButton');

class DeleteButton 
	extends LinkButton 
{

	var $icon = 'ui-icon-close';
	var $message;
	var $class = 'DeleteButton';
	var $addClass = 'btn btn-danger';
	var $dialogId;
	var $returnUrl;

	protected $scriptName = 'DeleteButton_script';
	
	function init () {

		$init = parent::init ();
		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('yii');	
		
		$this->dialogId = 'DeleteDialog_'.$this->name;

		return $init;
	}
	
	function run () {
		
		$r = parent::run();
		
		//Yii::log("DeleteButton.returnUrl=".$this->returnUrl);

		$r.= new \app\extensions\dialogs\QueryDialogForDelete ([
				'id' => $this->dialogId, // id of the dialog div element
				'callerClass' => $this->class, // identification of the link by class
				'content' => $this->message,
		]);

		return $r;
	}
	
	protected function _createHtmlOptions () {

		$htmlOptions = parent::_createHtmlOptions();
		
		$htmlOptions['data-dialogId'] = $this->dialogId;
		if (isset($this->returnUrl)) {
			$htmlOptions['data-returnUrl'] = $this->returnUrl;
		}
		
		return $htmlOptions;
	}
}
