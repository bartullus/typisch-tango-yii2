<?php
/**
 * QueryDialogForDelete
 *
 * Display a simple Ok-Cancel-Dialog with redirection on Ok, 
 * when clicked on delete link
 *   
 * @author herbert
 */

Yii::import('app.extensions.Dialogs.QueryDialog');

class QueryDialogForDelete 
	extends QueryDialog 
{

	var $id = 'DeleteDialog';
	var $class = 'delete-dialog';
	var $callerClass;
	
	protected $scriptName = 'QueryDialogForDelete_script';
	
	function init() {
		
		parent::init();
		
		$this->title = "Objekt löschen?";	
	}

	function _doJavascript() {

		$scriptTxt = $this->render($this->scriptName, array(
				'callerClass' => $this->callerClass,
				'options' => CJavaScript::encode($this->_createOptions()),
		), true);
		
		$scriptId = $this->class.'_'.$this->callerClass;
		Yii::app()->clientScript->registerScript($scriptId, $scriptTxt, $this->scriptPos);
	}
}
