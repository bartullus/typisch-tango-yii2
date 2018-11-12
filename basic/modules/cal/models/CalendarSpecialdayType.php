<?php

namespace app\modules\cal\models;

use Yii;

/**
 * This is the model class for table "{{%cal_specialday_type}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalSpecialday[] $calSpecialdays
 */
class CalendarSpecialdayType extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cal_specialday_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
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
            'id' => Yii::t('cal_specialday_type', 'ID'),
            'name' => Yii::t('cal_specialday_type', 'Name'),
            'description' => Yii::t('cal_specialday_type', 'Description'),
            'create_time' => Yii::t('cal_specialday_type', 'Create Time'),
            'create_user_id' => Yii::t('cal_specialday_type', 'Create User ID'),
            'update_time' => Yii::t('cal_specialday_type', 'Update Time'),
            'update_user_id' => Yii::t('cal_specialday_type', 'Update User ID'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalSpecialdays()
    {
        return $this->hasMany(CalSpecialday::className(), ['type_id' => 'id']);
    }
}
