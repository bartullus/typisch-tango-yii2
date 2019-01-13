<?php
namespace app\extensions\searchform;

use Yii;
use yii\web\Cookie;

/**
 * Description of SearchForm
 *
 * @author herbert
 */

class SearchForm 
	extends \app\extensions\ttwidget\TtWidget
{
	public $searchRoute;
	public $layout;
	public $placeholder = 'Suchbegriff';
	private static $cookieName = 'searchList';
	private static $search;
	
	function init () {
		
		$init = parent::init();
		
		return $init;
	}
	
	function run () {
		
		parent::run();
		if (isset($this->layout)) {
			$templateName = 'SearchForm'.$this->layout;
		} else {
			$templateName = 'SearchForm';
		}
		
		if (isset($this->searchRoute)) {
			$searchUrl = $this->createUrl($this->searchRoute);
		} else {
			$searchUrl = '';
		}
		
		return $this->render($templateName, [
				'search' => self::getSearchParam(),
				'searchUrl' => $searchUrl,
				'placeholder' => $this->placeholder,
		]);
	}	
	
	static function getSearchCriteria ($attributeList, $whereList = null) {
				
		// ensures that there is a criteria
		if (!isset($whereList)) {
			$whereList = [];
		}

		// do not change the criteria if no search parameter is provided
		$search = self::getSearchParam();
		if (!isset($search)) {
			return $whereList;
		}
		
		// create a new search criteria with OR-concatenated searches
		$orList = [];
		foreach ($attributeList as $attrib) {
			$orList[$attrib] = $search;
		}
		$orList = array_merge('or', $orList);
		
		// AND-concatenate the search criteria with the existing criteria
		$whereList = array_merge($whereList, $orList);
		
		return $whereList;
	}
	
	
	static function getSearchParam() {
		
		if (isset(self::$search)) {
			return self::$search;
		}
			
		$request = Yii::$app->request;
		$cookies = Yii::$app->response->cookies;
		
		if ($request->isAjax) {
			// on ajax request get search string from cookie (if there is one)
			$search_cookie = $cookies[self::$cookieName];
			if (isset($search_cookie)) {
				$search = $search_cookie->value;
			} else {
				$search = null;
			}
			
		} else {
			
			// on page request get search string from 
			// get or post parameters and set cookie with this value
			$search = $request->get('search');
			
			if (isset($search) && (strlen($search) > 0)) {
				//Yii::log("set cookie name=[".self::$cookie_name."] value=[$search]");
				$cookie = new Cookie([
						'name' => self::$cookieName, 
						'value' => $search, 
						'path' => '/', 
						'expire' => 0 ]);
				$cookies->add($cookie);
			} else {
				//Yii::log("reset cookie name=[".self::$cookie_name."]");
				$cookies->remove(self::$cookieName);
			}
			
		}
		//Yii::log("search=[$search]");
		
		self::$search = $search;
		return self::$search;
	}
	
	static function getSearchTitle($text_with_param, $text) {
		
		$param = self::getSearchParam();
		if (!isset($param) || (strlen($param) == 0)) {
			return $text;
		} else {
			$text = sprintf($text_with_param, $param);
			return $text;
		}
	}	
}
