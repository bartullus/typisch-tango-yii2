<?php
namespace app\extensions\menus;

use Yii;
use yii\helpers\Html;

/**
 * Description of TtMenu
 * base menu
 *
 * @author Admin
 */

class TtMenu 
	extends \app\extensions\ttwidget\TtWidget
{
	var $cs;
	var $user;
	//var $cssFile = null; 
	
	// parameter for the script
	var $use_script = true;
	var $menuname = 'ttmenu';

	protected $requestUri;
	
	public function init () {
	
		$this->user = Yii::$app->user;
		//$this->accessId = $this->getController()->getAccessId();
		
		if (array_key_exists('SCRIPT_URI', $_SERVER)) {
			$this->requestUri = $_SERVER['SCRIPT_URI'];
		} else {
			$this->requestUri = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		}
		//Yii::log("requestUri [".$this->requestUri."]");

	}
	
	public function run() {
	
		//$edit = !Yii::$app->user->isGuest;
		// caching of menus only for guests
		//$params = array('edit' => $edit);

		/*
		echo TtCache::cache($this->getCacheId(), 
						$this, 'doRun', 
						$params, Yii::$app->params['cacheDuration']);
		*/
		
		AssetMenu::register($this->getView());

		return $this->doRun().$this->runAdditional();
	}
	
	public function doRun() {
		
		$items = \app\models\BaseMenuItem::find()
						->where('menu_id='.$this->getMenuId().' AND visible=1')
						->orderBy('order ASC')
						->with('menu')
						->all();
		
		$menuitems = $this->createMenu($items);
		
		$menu = $this->render($this->getTemplateName(), array(
				'menuitems'  => $menuitems,
				'brandLabel' => $this->getBrandLabel(),
		));
		return $menu;
	}
		
	protected function runAdditional() {
		
		return null;
	}
		
	public function createUrl ($path, $params = array()) {
		
		return Yii::$app->createUrl($path, $params);
	}

	public function createMenu($items) {

		$menuItems = $this->_createMenu($items, null, 0);
						
		$menuItemsA = $this->_additionalItems($menuItems);						

		return $menuItemsA;
	}
	
	protected function _createMenu($items, $parentId, $depth) {
		
		if ($depth >= 4) {
			return;
		}
	
		//Yii::log("+createMenu ".$parent_id." ".$depth);
		// select all items of this menu
			
		$resultList = array();
		foreach($items as $item) {
			
			if (!isset($item)) {
				continue;
			}

			if (!is_object($item)) {
				continue;
			}
			//Yii::log(" class=".get_class($item));
			
			if ($item->parent_id != $parentId) {
				continue;
			}

			if ($item->restricted == 1 ||	$item->menu->restricted == 1) {
				if (!$this->user->checkAccess($item->website)) {
					//Yii::log('no access to ['.$item->website.']');
					continue;
				}
			}

			$subItems = $this->_createMenu($items, $item->id, $depth + 1); 
			
			// get text from subitems
			if (isset($item->subitems_controller) && strlen($item->subitems_controller) > 0) {
				
				$subCItems = $this->_subItemsFromController($item, $depth + 1);
				$subItems = array_merge($subItems, $subCItems);
			}
						
			$resultList[] = $this->createItem($item, $subItems, $depth);
		}
				
		//Yii::log("-createMenu ".$parent_id);
		return $resultList;
	}
	
	public function createList($items) {
		
		$menuItems = $this->_createMenu($items, null, 0);
		//Yii::log("createList:".print_r($menuItems,true));
		return $this->_createList($menuItems);
	}
	
	protected function _createList($menuItems) {
		
		$content = "";
		foreach($menuItems as $item) {
			
			$contentItem = Html::link($item['label'], $item['url'])."\r\n";
			if (isset($item['items'])) {
				$contentItem.= $this->_createList($item['items'])."\r\n";
			}
			$content.= Html::tag('li', array(), $contentItem);
		}

		return Html::tag('ul', array(), $content);
	}
	
	protected function _additionalItems($menuItems) {

		//Yii::log('TtMeno::_additionalItems()');
		return $menuItems;
	}
	
	protected function getCacheId() {
		
		return 'TtMenu';
	}
		
	protected function _subItemsFromController($item, $depth = 0) {
		
		$controllerClassname = $item->subitems_controller;
		if (!isset($controllerClassname)) {
			//Yii::log("alias [$controllerAlias]");
			return [];
		}
		
		$items = [];
		try {
			$controllerClass = new \ReflectionClass($controllerClassname);
			$items = $controllerClass->getMethod('subItems')->invoke(null);
		} catch (\ReflectionException $e) {
			return [];
		}	
				
		$resultList = array();
		foreach ($items as $item) {
			
			$url = $item['url'];
			//Yii::log("url [$url] [$this->requestUri]");
			
			$resultList[] = array(
				'label' => $item['text'],
				'url' => $url,
				'active' => ($this->requestUri === $url)? true: false,
				'priority' => sprintf('%.1f', $priority = 1.0 - 0.2 * $depth),
				'changefreq' => 'never',
			);
		}
		return $resultList;		
	}
	
	protected function createItem($item, $subItems = null, $depth = 0) {
		
		$url = $this->_createUrlFromItem($item);
		//Yii::log("createUrl url [$url]");
		
		$menuItem = array(
				'label' => Html::encode($item->name),
				'url' => $url,
				'icon' => $item->icon,
				'active' => ($this->requestUri === $url)? true: false,
				'priority' => sprintf('%.1f', $priority = 1.0 - 0.2 * $depth),
				'changefreq' => $item->change_freq,
		);
				
		if (isset($item->css_class) && (strlen($item->css_class) > 0)) {
			$menuItem['class'] = $item->css_class;
		}
		
		if (isset($subItems)) {
			$menuItem['items'] = $subItems;
			
			// propagate active state to parent menu
			foreach($subItems as $item){
			
				if ($item['active'] === true)
				{
					$menuItem['active'] = true;
				}
			}
		}
		
		return $menuItem;
	}
	
	protected function _createUrlFromItem($item) {
		
		$website = $item->website;
		
		// separate parameters to indexed list
		$param_list = array();
		$params = $item->params;
		if (isset($params) && (strlen($params) > 0)) {
			$param_parts = explode('&', $params);
			foreach ($param_parts as $part) {
				$key_value = explode('=', $part);
				$param_list[$key_value[0]] = $key_value[1];
			}
		}
		
		return $this->createAbsoluteUrl($website, $param_list);
	}

	public function getBrandLabel () {
		
		return false; // Yii::app()->name
	}
	
}

