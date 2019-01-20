<?php
namespace app\extensions\dialogs;

/**
 * QueryDialog
 *
 * display a simple modal Ok-Cancel-Dialog with redirection on Ok to an other page
 *
 * @author herbert
 */

class QueryDialog 
	extends \app\extensions\ttwidget\TtWidget
{

	var $callerIdent = null;
	var $id = 'QueryDialog';
	var $title = 'Query Dialog';
	var $target = array('/');
	var $class = 'query-dialog';
	var $content = null;
	
	protected $scriptName = 'QueryDialog_script';
	protected $scriptPos = CClientScript::POS_END;
	
	function init () {
	
		parent::init();
	}
	
	function run () {
		
/* what is the class for a modal dialog
		$this->widget('yiistrap.widgets.TbModal', array(
				'id' => $this->id,
				'header' => $this->title,
				'content' => $this->content,
				'footer' => array(
					TbHtml::button(Yii::t('Dialog', 'Ok'), array(
							'class' => $this->buttonClass('ok'),
							'data-dismiss' => 'modal', 
							'color' => TbHtml::BUTTON_COLOR_PRIMARY,
					)),
					TbHtml::button(Yii::t('Dialog', 'Cancel'), array(
							'class' => $this->buttonClass('cancel'),
							'data-dismiss' => 'modal',
					)),
				),		
		));
*/		
		$this->_doJavascript();
	}
	
	function _doJavascript() {

		$scriptTxt = $this->render($this->scriptName, array(
				'id' => $this->id,
				'callerIdent' => $this->callerIdent,
				'options' => CJavaScript::encode($this->_createOptions()),
				'targetUrl' => $this->_createTargetUrl(),
		), true);
		
		$scriptId = $this->id.'_'.$this->callerIdent;
		Yii::app()->clientScript->registerScript($scriptId, $scriptTxt, $this->scriptPos);
	}
	
	public function buttonClass($name) {
		
		return $this->class.'_button-'.$name;
	}
	
	protected function _createOptions() {

		$options = array(
				'keyboard' => 'true',
				'show' => true,
		);
		return $options;
	}
	
	protected function _createTargetUrl () {
		
		if(!isset($this->target)) {
			return null;
		}
		return Yii::$app->createAbsoluteUrl($this->target[0], array_splice($this->target,1));
	}

}
