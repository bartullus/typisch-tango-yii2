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

class TtAdminMenu 
	extends \app\extensions\menus\TtMainMenu
{
	var $menuname = 'admin_menu';
	var $userMenuId = 2;
	
	public function init () {
	
		parent::init();
	}
	
	public function getTemplateName() {
	
		return 'TtAdminMenu';
	}

	protected function getCacheId() {
		
		return 'TtAdminMenu';
	}

	function createAdminMenu() {

		$items = \app\models\BaseMenuItem::find()
						->where('menu_id='.$this->userMenuId.' AND visible=1')
						->orderBy('order ASC')
						->with('menu')
						->all();
		
		$menuItems = $this->_createMenu($items, null, 0);
		return $menuItems;
	}

}

