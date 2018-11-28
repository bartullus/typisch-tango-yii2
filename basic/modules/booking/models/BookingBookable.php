<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "{{%booking_bookable}}".
 *
 * @property integer $id
 * @property integer $event_id
 * @property string $booking_start
 * @property string $booking_end
 * @property integer $ask_role_always
 * @property integer $payment_due_days
 * @property double $pricelevel_discount
 * @property string $percent_pricelevel_discount
 * @property string $date_earlybird
 * @property string $percent_earlybird_discount
 * @property string $remark
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalEvent $event
 * @property BookingPackage[] $bookingPackages
 * @property BookingUserbooking[] $bookingUserbookings
 */
class BookingBookable extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%booking_bookable}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'booking_start', 'booking_end', 'ask_role_always', 'payment_due_days'], 'required'],
            [['event_id', 'ask_role_always', 'payment_due_days', 'create_user_id', 'update_user_id'], 'integer'],
            [['booking_start', 'booking_end', 'date_earlybird', 'create_time', 'update_time'], 'safe'],
            [['pricelevel_discount', 'percent_pricelevel_discount', 'percent_earlybird_discount'], 'number'],
            [['remark'], 'string'],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEvent::className(), 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('booking_bookable', 'ID'),
            'event_id' => Yii::t('booking_bookable', 'Event'),
            'booking_start' => Yii::t('booking_bookable', 'Booking Start'),
            'booking_end' => Yii::t('booking_bookable', 'Booking End'),
            'ask_role_always' => Yii::t('booking_bookable', 'Ask Role Always'),
            'payment_due_days' => Yii::t('booking_bookable', 'Payment Due Days'),
            'pricelevel_discount' => Yii::t('booking_bookable', 'Pricelevel Discount'),
            'percent_pricelevel_discount' => Yii::t('booking_bookable', 'Percent Pricelevel Discount'),
            'date_earlybird' => Yii::t('booking_bookable', 'Date Earlybird'),
            'percent_earlybird_discount' => Yii::t('booking_bookable', 'Percent Earlybird Discount'),
            'remark' => Yii::t('booking_bookable', 'Remark'),
        ]);
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
    public function getBookingPackages()
    {
        return $this->hasMany(BookingPackage::className(), ['bookable_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingUserbookings()
    {
        return $this->hasMany(BookingUserbooking::className(), ['bookable_id' => 'id']);
    }
}
