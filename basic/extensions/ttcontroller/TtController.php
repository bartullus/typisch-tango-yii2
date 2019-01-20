<?php
namespace app\extensions\ttcontroller;
/**
 * Description of TtController
 *
 * @author herbert
 */

use yii\web\Controller;

class TtController 
	extends Controller
{

	/**
	 * standard functionality for controllers without special buttons 
	 * subclass in derived controller classes
	 */
	function getModelTableButtons($model, $options) {
		
		$r = new \app\extensions\buttons\LinkButton([
				'name' => 'update_'.$model->id,
				'title' => "Bearbeiten",
				'target' => array('update', 'id' => $model->id),
				'icon' => 'icon-pencil',
		]);
		
		$r.= new \app\extensions\buttons\DeleteButton([
				'name' => 'delete_'.$model->id,
				'title' => "LÃ¶schen",
				'target' => array('delete', 'id' => $model->id),
				'message' => "Id=[$model->id] Name='".$model->getName()."' <br/>Diesen Eintrag wirklich lÃ¶schen?",
		]);
		
		return $r;
	}

	/**
	 * standard functionality is empty
	 * subclass in derived controller classes
	 */
	public function attributeParams($attrName, $model, $options) {
		
		return array();
	}
}
