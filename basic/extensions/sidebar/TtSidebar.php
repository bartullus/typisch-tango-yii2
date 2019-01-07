<?php
namespace app\extensions\sidebar;

use Yii;
use yii\helpers\Html;

/**
 * Description of TtSidebar
 * admin menu
 *
 * @author herbert
 */

class TtSidebar
	extends \app\extensions\ttwidget\TtWidget
{
	var $menuItems;

	private $ulParams = array(
		0 => array('class' => 'nav', 'id' => 'side-menu'),
		1 => array('class' => 'nav nav-second-level collapse'),
	);

	public function init () 
	{
		//Yii::info('TtSidebar::init()');
		parent::init();		
	}
	
	public function run() {
	
		//Yii::info('TtSidebar::run()');
		AssetSidebar::register($this->getView());

		return $this->render('TtSidebar', array(
			'navList' => $this->navList($this->menuItems)
		));
	}	
	
	function navList($menuItems) {

		return $this->_navList($menuItems, 0);
	}
	
	function _navList($menuItems, $level) {
		
		$list = "";
		foreach($menuItems as $menuItem) {
			
			$liParams = array();
			$linkParams = array();
			
			if (array_key_exists('class', $menuItem)) {
				$liParams['class'] = $menuItem['class'];
			} else {
				$liParams['class'] = '';				
			}
				
			if (isset($menuItem['active']) && ($menuItem['active'] === true)) {
				$liParams['class'].= (strlen($liParams['class']) > 0)?' ':'';
				$liParams['class'] = 'active';
				$linkParams['class'] = 'active';
			}
			
			//Yii::log("menu label=".$menuItem['label']." icon=".$menuItem['icon']);
			$label = "";
			if (isset($menuItem['icon'])) {
				$label.= Html::tag('i', "", array('class' => $menuItem['icon']));
				$label.= " ";
			}
			$label.= $menuItem['label'];
			
			
			if (isset($menuItem['items']) && (count($menuItem['items']) > 0)) {
				
				$label.= Html::tag('span', "", array('class' => 'fa arrow'));
				$content = Html::a($label, '#', $linkParams);
				$content.= $this->_navList($menuItem['items'], $level+1);
			} else {
				
				$content = Html::a($label, $menuItem['url'], $linkParams);				
			}

			$list.= Html::tag('li', $content, $liParams);			
		}
		
		if (isset($this->ulParams[$level])) {
			$ulParams = $this->ulParams[$level];
		} else {
			$ulParams = array();
		}
		
		return Html::tag('ul', $list, $ulParams);
	}

}
