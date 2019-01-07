<?php
namespace app\extensions\buttons;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Description of LinkButton
 * 
 * displays a Bootstrap Button representing a link to a different page
 *
 * @author herbert
 */

class LinkButton
	extends \app\extensions\ttwidget\TtWidget
{
	// HTML options of this button
	var $id = null; // html-option 'id'
	var $name = null; // html-option 'name'
	var $title = null; // html-option 'title'
	var $class = 'LinkButton'; // html-option 'class'
	var $addClass = 'btn btn-default'; // additionals for html-option 'class'
	var $icon = null; // icon of the button
	var $iconSpan = null; // span-tag for displaying icon

	var $target = null; 
	var $url = null;
	
	var $buttonType = 'link';
	var $caption = null;

	private $htmlOptions;
	protected $scriptName = 'LinkButton_script';
	var $scriptPos = View::POS_END;
	
	function init () {

		//$this->theme = Yii::app()->params['jquery-ui-theme'];
		parent::init();		
	}
	
	function run () {

		$this->url = $this->_createTargetUrl();
		$this->htmlOptions = $this->_createHtmlOptions();
		$this->iconSpan = $this->_createIconSpan();
		
		$this->_doHtml();
		$this->_doJavascript();		
	}	
	
	protected function _doHtml() {
		
		if (isset($this->iconSpan)) {
			
			$caption = $this->iconSpan." ".$this->caption;
		} else {
			$caption = $this->caption;
		}

		switch($this->buttonType) {

			case 'submit':
				echo Html::submitButton($caption, $this->htmlOptions)."\n";
				return;
				
			case 'button':
				echo Html::button($caption, $this->htmlOptions)."\n";
				return;
				
			case 'link':
				echo Html::a($caption, $this->url, $this->htmlOptions)."\n";
				return;
				
			default:
				echo "[Unknown button type: ".$this->buttonType."]\n";
		}		
	}
	
	protected function _doJavascript() {
		
		//$cs = Yii::app()->getClientScript();
		$buttonId = $this->buttonId();
		
		$scriptTxt = $this->render($this->scriptName, array(
				'class' => $this->buttonClass(),
				'buttonId' => $buttonId,
		), true);
		
		//$cs->registerScript($buttonId, $scriptTxt, $this->scriptPos);
		
		$this->view->registerJs($scriptTxt, $this->scriptPos, $buttonId);
	}
	
	protected function _createIconSpan() {

		if (!isset($this->icon)) {
			return null;
		}
		
		switch($this->icon) {
			case 'ui-icon-plus': $class = "glyphicon glyphicon-plus"; break;
			case 'ui-icon-minus': $class = "glyphicon glyphicon-minus"; break;
			case 'ui-icon-close': $class = "glyphicon glyphicon-remove"; break;
			case 'icon-pencil': 
			case 'ui-icon-pencil': $class = "glyphicon glyphicon-pencil"; break;
			case 'icon-retweet':
			case 'ui-icon-newwin': $class = "glyphicon glyphicon-retweet"; break;
			case 'ui-icon-mail-closed': $class = "glyphicon glyphicon-envelope"; break;
			case 'icon-file':
			case 'ui-icon-document': $class = "glyphicon glyphicon-file"; break;
			case 'ui-icon-document-b': $class = "glyphicon glyphicon-book"; break;
			case 'ui-icon-calculator': $class = "glyphicon glyphicon-barcode"; break;
			case 'ui-icon-print': $class = "glyphicon glyphicon-print"; break;
			case 'ui-icon-check': $class = "glyphicon glyphicon-ok"; break;
			case 'ui-icon-flag': $class = "glyphicon glyphicon-flag"; break;
			case 'ui-icon-locked': $class = "glyphicon glyphicon-lock"; break;
			case 'icon-arrowreturn-1-w': 
			case 'ui-icon-arrowreturn-1-w': $class = "glyphicon glyphicon-share"; break;
			case 'ui-icon-list': $class = "glyphicon glyphicon-list"; break;
			case 'ui-icon-calendar': $class = "glyphicon glyphicon-calendar"; break;
			default: $class = $this->icon;
		}
		
		return Html::tag('span', null, ['class' => $class]);
	}
	
	
	protected function _createHtmlOptions () {

		$htmlOptions = array();
		
		if(isset($this->id)) {
			$htmlOptions['id'] = $this->id;
		}
				
		if(isset($this->name)) {
			$htmlOptions['name'] = $this->name;
		}
		
		if (isset($this->title)) {
			$htmlOptions['title'] = $this->title;
		}

		$htmlOptions['class'] = $this->buttonClass();
		
		$this->url = $this->_createTargetUrl();
		if (isset($this->url)) {
			$htmlOptions['href'] = $this->url;
		}

		return $htmlOptions;
	}
	
	protected function _createTargetUrl () {
		
		if(!isset($this->target)) {
			return $this->url;
		}
		
		return Url::toRoute($this->target);
		
		/*
		if (isset($this->target[0])) {
			$route = $this->target[0];
			$params = array_slice($this->target,1);
		} else {
			return $this->url;
		}
		
		if(($c = Yii::app()->getController()) !== null) {
			
			//Yii::log("route = ".$route);
			return $c->createUrl($route, $params);
		} else {
			
			return Yii::app()->createUrl($route, $params);
		}
		 */
	}
	
	private function buttonId() {
		
		$search  = array(' ', '-');
		$replace = array('_', '_');
		
		$buttonId = str_replace($search, $replace, $this->class);
		return $buttonId;
	}

	public function buttonClass() {
		
		$class = $this->class;
		if (isset($this->addClass)) {
			$class.= ' '.$this->addClass;
		}
		return $class;
	}	
}
