<?php
namespace app\extensions\ttwidget;

/**
 * general widget
 *
 * @author herbert
 */

use yii\base\Widget;
use yii\helpers\Url;

class TtWidget 
	extends Widget
{
	var $oneday = 86400; // seconds of a day
	var $publishedDir;
	
	public function createUrl ($path, $params = array()) {
		
		//return Yii::$app->createUrl($path, $params);
		$toparams = array_merge([$path], $params);
		return Url::to($toparams);
	}

	public function createAbsoluteUrl ($path, $params = array()) {
		
		//return Yii::$app->createAbsoluteUrl($path, $params);
		$toparams = array_merge([$path], $params);
		return Url::to($toparams, true);
	}

	static function cutText ($text, $length) {
		
		if (mb_strlen($text, Yii::app()->charset) > $length) {
			return mb_substr($text, 0, $length, Yii::app()->charset)."...";
		} else {
			return $text;
		}	
	}
		
}

