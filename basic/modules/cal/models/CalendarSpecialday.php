<?php

namespace app\modules\cal\models;

use Yii;

/**
 * This is the model class for table "{{%cal_specialday}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $free
 * @property integer $type_id
 * @property integer $month
 * @property integer $day
 * @property integer $relative
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalSpecialdayType $type
 */
class CalendarSpecialday extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cal_specialday}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type_id'], 'required'],
            [['free', 'type_id', 'month', 'day', 'relative', 'create_user_id', 'update_user_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalSpecialdayType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('cal_specialday', 'ID'),
            'name' => Yii::t('cal_specialday', 'Name'),
            'free' => Yii::t('cal_specialday', 'Free'),
            'type_id' => Yii::t('cal_specialday', 'Type ID'),
            'month' => Yii::t('cal_specialday', 'Month'),
            'day' => Yii::t('cal_specialday', 'Day'),
            'relative' => Yii::t('cal_specialday', 'Relative'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(CalSpecialdayType::className(), ['id' => 'type_id']);
    }
}
