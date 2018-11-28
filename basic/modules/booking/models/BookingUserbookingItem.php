<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "{{%booking_userbooking_item}}".
 *
 * @property integer $id
 * @property integer $userbooking_id
 * @property integer $event_id
 * @property integer $offer_id
 * @property integer $type_id
 * @property integer $discounted_id
 * @property string $booking_date
 * @property string $price
 * @property integer $acknowledged
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalEventOfferDiscounted $discounted
 * @property CalEvent $event
 * @property CalEventOffer $offer
 * @property BookingUserbookingItemType $type
 * @property BookingUserbooking $userbooking
 */
class BookingUserbookingItem extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%booking_userbooking_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userbooking_id', 'discounted_id', 'booking_date'], 'required'],
            [['userbooking_id', 'event_id', 'offer_id', 'type_id', 'discounted_id', 'acknowledged', 'create_user_id', 'update_user_id'], 'integer'],
            [['booking_date', 'create_time', 'update_time'], 'safe'],
            [['price'], 'number'],
            [['discounted_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEventOfferDiscounted::className(), 'targetAttribute' => ['discounted_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEvent::className(), 'targetAttribute' => ['event_id' => 'id']],
            [['offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEventOffer::className(), 'targetAttribute' => ['offer_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookingUserbookingItemType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['userbooking_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookingUserbooking::className(), 'targetAttribute' => ['userbooking_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('booking_userbooking_item', 'ID'),
            'userbooking_id' => Yii::t('booking_userbooking_item', 'Userbooking'),
            'event_id' => Yii::t('booking_userbooking_item', 'Event'),
            'offer_id' => Yii::t('booking_userbooking_item', 'Offer'),
            'type_id' => Yii::t('booking_userbooking_item', 'Type'),
            'discounted_id' => Yii::t('booking_userbooking_item', 'Discounted'),
            'booking_date' => Yii::t('booking_userbooking_item', 'Booking Date'),
            'price' => Yii::t('booking_userbooking_item', 'Price'),
            'acknowledged' => Yii::t('booking_userbooking_item', 'Acknowledged'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscounted()
    {
        return $this->hasOne(CalEventOfferDiscounted::className(), ['id' => 'discounted_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(CalEvent::className(), ['id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffer()
    {
        return $this->hasOne(CalEventOffer::className(), ['id' => 'offer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(BookingUserbookingItemType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserbooking()
    {
        return $this->hasOne(BookingUserbooking::className(), ['id' => 'userbooking_id']);
    }
}
