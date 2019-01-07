<?php

namespace app\migrations;

use yii\db\Migration;
use app\models\BaseUser;

class m181229_193454_userauth 
	extends Migration
{
	public function safeUp()
	{
		echo "migrate m181229_193454_userauth.\n";

		$this->addColumn('{{%base_user}}', 'authKey', $this->string(256));
		$this->addColumn('{{%base_user}}', 'accessToken', $this->string(256));

		$this->createIndex('idx-user-accessToken', '{{%base_user}}', 'accessToken');
		
		$this->_fillColumns();
		
		echo "migrated m181229_193454_userauth.\n";
		return true;
	}

	public function safeDown()
	{
		echo "revert m181229_193454_userauth.\n";

		$this->dropColumn('{{%base_user}}', 'authKey');
		$this->dropColumn('{{%base_user}}', 'accessToken');
		
		echo "reverted m181229_193454_userauth.\n";

		return true;
	}
	
	protected function _fillColumns() {
		
		$records = BaseUser::find()->all();
		echo "setting values for ".count($records)." objects.\n";
		
		$cnt = 0;
		foreach($records as $record) {
			
			$record->updateAttributes([
				'authKey' => 'key-'.$record->id,
				'accessToken' => 'token-'.$record->id,
			]);
			echo " set id: ".$record->id
					." name: ".$record->username
					." authKey: ".$record->authKey
					." accessToken: ".$record->accessToken
					."\n";
			$cnt++;
		}
		echo "values for ".$cnt." objects are set.\n";
		
	}
}
