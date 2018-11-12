<?php

namespace app\modules\cal\models;

use Yii;

/**
 * This is the model class for table "{{%cal_event_offer_discounted}}".
 *
 * @property integer $id
 * @property string $short
 * @property string $name
 * @property string $description
 * @property integer $foruser
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalEventOffer[] $calEventOffers
 */
class CalendarEventOfferDiscounted extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cal_event_offer_discounted}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['short', 'name', 'foruser'], 'required'],
            [['description'], 'string'],
            [['foruser', 'create_user_id', 'update_user_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['short'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 255],
            [['short'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('cal_event_offer_discounted', 'ID'),
            'short' => Yii::t('cal_event_offer_discounted', 'Short'),
            'name' => Yii::t('cal_event_offer_discounted', 'Name'),
            'description' => Yii::t('cal_event_offer_discounted', 'Description'),
            'foruser' => Yii::t('cal_event_offer_discounted', 'Foruser'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalEventOffers()
    {
        return $this->hasMany(CalEventOffer::className(), ['discounted_id' => 'id']);
    }
}
