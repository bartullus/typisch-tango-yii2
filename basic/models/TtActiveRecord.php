<?php
namespace app\models;

/**
 * Description of TtActiveRecord
 *
 * @author herbert
 */

use yii\db\ActiveRecord;

class TtActiveRecord extends ActiveRecord
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
}
