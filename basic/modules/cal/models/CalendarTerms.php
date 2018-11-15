<?php

namespace app\modules\cal\models;

use Yii;

/**
 * This is the model class for table "{{%cal_terms}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 */
class CalendarTerms extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cal_terms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['create_user_id', 'update_user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('cal_terms', 'ID'),
            'name' => Yii::t('cal_terms', 'Name'),
        ]);
    }
}
