<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "{{%booking_userbooking}}".
 *
 * @property integer $id
 * @property integer $bookable_id
 * @property integer $user_id
 * @property integer $role_id
 * @property integer $discounted_id
 * @property string $code
 * @property string $name
 * @property string $email
 * @property string $sum_price
 * @property string $discount_price
 * @property string $booking_date
 * @property string $booking_due_date
 * @property string $earlybird_price
 * @property string $special_rebate
 * @property string $sum_final
 * @property string $sum_payment
 * @property string $difference
 * @property string $remark
 * @property integer $confirmed
 * @property integer $acknowledged
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property BookingBookable $bookable
 * @property CalEventOfferDiscounted $discounted
 * @property BookingUserbookingRole $role
 * @property BookingUserbookingItem[] $bookingUserbookingItems
 * @property BookingUserbookingPackage[] $bookingUserbookingPackages
 * @property BookingUserbookingPayment[] $bookingUserbookingPayments
 */
class BookingUserbooking extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%booking_userbooking}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bookable_id', 'discounted_id', 'code', 'name', 'email', 'booking_date', 'booking_due_date'], 'required'],
            [['bookable_id', 'user_id', 'role_id', 'discounted_id', 'confirmed', 'acknowledged', 'create_user_id', 'update_user_id'], 'integer'],
            [['sum_price', 'discount_price', 'earlybird_price', 'special_rebate', 'sum_final', 'sum_payment', 'difference'], 'number'],
            [['booking_date', 'booking_due_date', 'create_time', 'update_time'], 'safe'],
            [['remark'], 'string'],
            [['code', 'name', 'email'], 'string', 'max' => 255],
            [['bookable_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookingBookable::className(), 'targetAttribute' => ['bookable_id' => 'id']],
            [['discounted_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEventOfferDiscounted::className(), 'targetAttribute' => ['discounted_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookingUserbookingRole::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('booking_userbooking', 'ID'),
            'bookable_id' => Yii::t('booking_userbooking', 'Bookable ID'),
            'user_id' => Yii::t('booking_userbooking', 'User ID'),
            'role_id' => Yii::t('booking_userbooking', 'Role ID'),
            'discounted_id' => Yii::t('booking_userbooking', 'Discounted ID'),
            'code' => Yii::t('booking_userbooking', 'Code'),
            'name' => Yii::t('booking_userbooking', 'Name'),
            'email' => Yii::t('booking_userbooking', 'Email'),
            'sum_price' => Yii::t('booking_userbooking', 'Sum Price'),
            'discount_price' => Yii::t('booking_userbooking', 'Discount Price'),
            'booking_date' => Yii::t('booking_userbooking', 'Booking Date'),
            'booking_due_date' => Yii::t('booking_userbooking', 'Booking Due Date'),
            'earlybird_price' => Yii::t('booking_userbooking', 'Earlybird Price'),
            'special_rebate' => Yii::t('booking_userbooking', 'Special Rebate'),
            'sum_final' => Yii::t('booking_userbooking', 'Sum Final'),
            'sum_payment' => Yii::t('booking_userbooking', 'Sum Payment'),
            'difference' => Yii::t('booking_userbooking', 'Difference'),
            'remark' => Yii::t('booking_userbooking', 'Remark'),
            'confirmed' => Yii::t('booking_userbooking', 'Confirmed'),
            'acknowledged' => Yii::t('booking_userbooking', 'Acknowledged'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookable()
    {
        return $this->hasOne(BookingBookable::className(), ['id' => 'bookable_id']);
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
    public function getRole()
    {
        return $this->hasOne(BookingUserbookingRole::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingUserbookingItems()
    {
        return $this->hasMany(BookingUserbookingItem::className(), ['userbooking_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingUserbookingPackages()
    {
        return $this->hasMany(BookingUserbookingPackage::className(), ['userbooking_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingUserbookingPayments()
    {
        return $this->hasMany(BookingUserbookingPayment::className(), ['userbooking_id' => 'id']);
    }
}
