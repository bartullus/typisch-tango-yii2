<?php
namespace app\models;

/**
 * Description of TtActiveRecord
 *
 * @author herbert
 */

use Yii;
use yii\db\ActiveRecord;

class TtActiveRecord 
	extends ActiveRecord
{
	
  /**
   * @inheritdoc
   */
	public function attributeLabels()
	{
		return [
				'create_time' => Yii::t('active_record', 'Create Time'),
				'create_user_id' => Yii::t('active_record', 'Create User ID'),
				'update_time' => Yii::t('active_record', 'Update Time'),
				'update_user_id' => Yii::t('active_record', 'Update User ID'),
		];
	}
		
	public function attributeValue($attr_name, $attr_params = array()) {
		
		switch($attr_name) {
			
			case 'create_time':
				if (isset($this->create_time)) {
					return strftime('%d.%m.%Y %H:%M:%S', strtotime($this->create_time));
				} 
				return null;
			
			case 'update_time':
				if (isset($this->update_time)) {
					return strftime('%d.%m.%Y %H:%M:%S', strtotime($this->update_time));
				} 
				return null;
			
			case 'create_user_id':
				$user = $this->Creator;
				if (isset($user)) {
					return $this->_getValueRoute($user->username, $attr_params, $user->id, null);
				}
				return $this->create_user_id;
				
			case 'update_user_id':
				$user = $this->Updater;
				if (isset($user)) {
					return $this->_getValueRoute($user->username, $attr_params, $user->id, null);
				}
				return $this->update_user_id;
				
			default:
				$value = $this->$attr_name;
				return $this->_getValueRoute($value, $attr_params);
		}
	}
		
	public function displayTableLine($attrParams) {
		
		return true; // display line by default
	}

	public function displayTableColumn($attrName) {
		
		return true; // display all columns by default (use this for colspan)
	}

}
