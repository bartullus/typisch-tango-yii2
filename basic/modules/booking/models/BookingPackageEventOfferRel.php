<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "{{%booking_package_event_offer_rel}}".
 *
 * @property integer $package_id
 * @property integer $event_offer_id
 *
 * @property CalEventOffer $eventOffer
 * @property BookingPackage $package
 */
class BookingPackageEventOfferRel extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%booking_package_event_offer_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id', 'event_offer_id'], 'required'],
            [['package_id', 'event_offer_id'], 'integer'],
            [['event_offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEventOffer::className(), 'targetAttribute' => ['event_offer_id' => 'id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookingPackage::className(), 'targetAttribute' => ['package_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'package_id' => Yii::t('booking_package_event_offer_rel', 'Package'),
            'event_offer_id' => Yii::t('booking_package_event_offer_rel', 'Event Offer'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventOffer()
    {
        return $this->hasOne(CalEventOffer::className(), ['id' => 'event_offer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(BookingPackage::className(), ['id' => 'package_id']);
    }
}
