<?php
namespace app\extensions\footer;
/**
 * Description of Footer
 *
 * @author herbert
 */

use Yii;
use yii\helpers\Html;

class Footer
	extends \app\extensions\ttwidget\TtWidget
{
	
	var $separator = "&nbsp;::&nbsp;";
	
	var $links = array(
			array(
					'label' => "Impressum",
					'path' => array("/page/view", 'name' => "impressum"),
					'class' => '',
			),
			array(
					'label' => "Kontakt",
					'path' => array("/contactRequest/create"),
					'class' => 'hidden-xs',
			),
			array(
					'label' => "Angebot",
					'path' => array("/page/view", 'name' => "angebot"),
					'class' => 'hidden-xs hidden-sm',
			),
			array(
					'label' => "DSVGO",
					'path' => array("/page/view", 'name' => "datenschutz"),
					'class' => '',
			),
	);
	
	public function init(){
		
		parent::init();
	}
	
	public function run() {
		
		return $this->render('Footer', array(
				'footerText' => $this->footerText(),
		));
	}
	
	public function footerText() {
		
		$year = date('Y');
		$t = "&copy;&nbsp;$year&nbsp;";
		
		$htmlOptions = array(
			'class'	=> 'hidden-xs',
		);
		$t.= Html::a(Yii::$app->name, Yii::$app->homeUrl, $htmlOptions);
		
		$t.= $this->_showLinks();
		
		return $t;
	}
	
	
	protected function _showLinks() {
		
		$linkList = array();
		foreach($this->links as $linkData) {
			$htmlOptions = array(
					'class' => $linkData['class'],
			);
			$link = Html::a($linkData['label'], $linkData['path'], []);
			$content = $this->separator.$link;
			$linkList[] = Html::tag('span', $content, $htmlOptions);
		}
		return implode('', $linkList);
	}
					
}
