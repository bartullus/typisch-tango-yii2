<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "{{%booking_userbooking_payment}}".
 *
 * @property integer $id
 * @property integer $userbooking_id
 * @property string $booking_date
 * @property string $amount
 * @property string $remark
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property BookingUserbooking $userbooking
 */
class BookingUserbookingPayment extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%booking_userbooking_payment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userbooking_id', 'booking_date'], 'required'],
            [['userbooking_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['booking_date', 'create_time', 'update_time'], 'safe'],
            [['amount'], 'number'],
            [['remark'], 'string'],
            [['userbooking_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookingUserbooking::className(), 'targetAttribute' => ['userbooking_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('booking_userbooking_payment', 'ID'),
            'userbooking_id' => Yii::t('booking_userbooking_payment', 'Userbooking ID'),
            'booking_date' => Yii::t('booking_userbooking_payment', 'Booking Date'),
            'amount' => Yii::t('booking_userbooking_payment', 'Amount'),
            'remark' => Yii::t('booking_userbooking_payment', 'Remark'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserbooking()
    {
        return $this->hasOne(BookingUserbooking::className(), ['id' => 'userbooking_id']);
    }
}
