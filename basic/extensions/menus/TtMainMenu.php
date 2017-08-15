<?php
namespace app\extensions\menus;

/**
 * Description of TtMenu
 * base menu
 *
 * @author Admin
 */

use Yii;
use yii\helpers\Html;

class TtMainMenu 
	extends \app\extensions\menus\TtMenu
{
	// parameter for the script
	var $menuname = 'main_menu';
	//var $cssFile = 'mainmenu.css';	
	
	public function init () {
	
		parent::init();
	}
	
	public function getMenuId () {
	
		return 1;
	}

	public function getTemplateName() {
	
		return 'TtMainMenu';
	}

	protected function getCacheId() {
		
		return 'TtMainMenu';
	}
	
	public function getBrandLabel () {

		$appname = Yii::$app->name;
		
		$logo = Html::img("@web/pics/logo.png", [
				'title' => "Startseite",
				'alt' => $appname,
		]);
		
		
		return $logo."&nbsp;".$appname;
	}
	
	protected function _additionalItems($menuItems) {
		
		//Yii::log(print_r($user, true));
		//Yii::log("MainMenu::_additionalItems() guest=[".$user->isGuest."]");
		
		if($this->user->isGuest) {
			
			$menuItems[] = [
					'label' => 'Login',
					'url' => $this->createAbsoluteUrl('intern/login'),
					'class' => 'login',
			];
			
		} else {

			$menuItems[] = [
					'label' => 'Intern',
					'url' => $this->createAbsoluteUrl('intern/index'),
					'class' => 'intern',
			];
		}
		//Yii::log(print_r($menuItems, true));
		
		return $menuItems;
	}
	
	protected function runAdditional() {

		$user = Yii::$app->user;
		if($user->isGuest) {
			return;
		}
		/*
		$this->widget('ext.Dialogs.QueryDialog',array(
				'callerIdent' => 'li.logout a', // identification of original link
				'id' => 'LogoutDialog', // id of the dialog div element
				'class' => 'logout-dialog', // css class of the dialog
				'target' => array('intern/logout'), // target route if Ok button is clicked
				'title' =>  "Sitzung beenden?",
				'content' => "Möchtest du deine aktuelle Sitzung wirklich beenden?",
		));
		 */
	}
}

