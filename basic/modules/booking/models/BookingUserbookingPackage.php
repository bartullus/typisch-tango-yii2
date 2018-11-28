<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "{{%booking_userbooking_package}}".
 *
 * @property integer $id
 * @property integer $userbooking_id
 * @property integer $package_id
 * @property integer $discounted_id
 * @property string $booking_date
 * @property string $price
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalEventOfferDiscounted $discounted
 * @property BookingPackage $package
 * @property BookingUserbooking $userbooking
 */
class BookingUserbookingPackage extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%booking_userbooking_package}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userbooking_id', 'package_id', 'discounted_id', 'booking_date'], 'required'],
            [['userbooking_id', 'package_id', 'discounted_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['booking_date', 'create_time', 'update_time'], 'safe'],
            [['price'], 'number'],
            [['discounted_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEventOfferDiscounted::className(), 'targetAttribute' => ['discounted_id' => 'id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookingPackage::className(), 'targetAttribute' => ['package_id' => 'id']],
            [['userbooking_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookingUserbooking::className(), 'targetAttribute' => ['userbooking_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('booking_userbooking_package', 'ID'),
            'userbooking_id' => Yii::t('booking_userbooking_package', 'Userbooking ID'),
            'package_id' => Yii::t('booking_userbooking_package', 'Package ID'),
            'discounted_id' => Yii::t('booking_userbooking_package', 'Discounted ID'),
            'booking_date' => Yii::t('booking_userbooking_package', 'Booking Date'),
            'price' => Yii::t('booking_userbooking_package', 'Price'),
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
    public function getPackage()
    {
        return $this->hasOne(BookingPackage::className(), ['id' => 'package_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserbooking()
    {
        return $this->hasOne(BookingUserbooking::className(), ['id' => 'userbooking_id']);
    }
}
