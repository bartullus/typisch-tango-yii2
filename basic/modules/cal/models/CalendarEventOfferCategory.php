<?php

namespace app\modules\cal\models;

use Yii;

/**
 * This is the model class for table "{{%cal_event_offer_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalEventOffer[] $calEventOffers
 */
class CalendarEventOfferCategory extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cal_event_offer_category}}';
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
            'id' => Yii::t('cal_event_offer_category', 'ID'),
            'name' => Yii::t('cal_event_offer_category', 'Name'),
            'description' => Yii::t('cal_event_offer_category', 'Description'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalEventOffers()
    {
        return $this->hasMany(CalEventOffer::className(), ['category_id' => 'id']);
    }
}
