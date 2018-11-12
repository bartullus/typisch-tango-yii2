<?php

namespace app\modules\cal\models;

use Yii;

/**
 * This is the model class for table "{{%cal_event_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $plural
 * @property string $shortname
 * @property string $schema_type
 * @property string $description
 * @property integer $importance
 * @property integer $is_class
 * @property integer $can_be_parent
 * @property integer $user_group_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalEvent[] $calEvents
 */
class CalendarEventCategory extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cal_event_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'importance', 'user_group_id'], 'required'],
            [['description'], 'string'],
            [['importance', 'is_class', 'can_be_parent', 'user_group_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'plural', 'schema_type'], 'string', 'max' => 255],
            [['shortname'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('cal_event_category', 'ID'),
            'name' => Yii::t('cal_event_category', 'Name'),
            'plural' => Yii::t('cal_event_category', 'Plural'),
            'shortname' => Yii::t('cal_event_category', 'Shortname'),
            'schema_type' => Yii::t('cal_event_category', 'Schema Type'),
            'description' => Yii::t('cal_event_category', 'Description'),
            'importance' => Yii::t('cal_event_category', 'Importance'),
            'is_class' => Yii::t('cal_event_category', 'Is Class'),
            'can_be_parent' => Yii::t('cal_event_category', 'Can Be Parent'),
            'user_group_id' => Yii::t('cal_event_category', 'User Group ID'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalEvents()
    {
        return $this->hasMany(CalEvent::className(), ['category_id' => 'id']);
    }
}
