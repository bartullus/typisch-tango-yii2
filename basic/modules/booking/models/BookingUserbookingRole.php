<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "{{%booking_userbooking_role}}".
 *
 * @property integer $id
 * @property string $short
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property BookingUserbooking[] $bookingUserbookings
 */
class BookingUserbookingRole extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%booking_userbooking_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['short', 'name'], 'required'],
            [['description'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['create_user_id', 'update_user_id'], 'integer'],
            [['short', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('booking_userbooking_role', 'ID'),
            'short' => Yii::t('booking_userbooking_role', 'Short'),
            'name' => Yii::t('booking_userbooking_role', 'Name'),
            'description' => Yii::t('booking_userbooking_role', 'Description'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingUserbookings()
    {
        return $this->hasMany(BookingUserbooking::className(), ['role_id' => 'id']);
    }
}
