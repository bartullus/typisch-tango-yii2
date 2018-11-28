<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "{{%booking_package}}".
 *
 * @property integer $id
 * @property integer $bookable_id
 * @property string $name
 * @property double $amount
 * @property integer $discounted_id
 * @property integer $default_booked
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property BookingBookable $bookable
 * @property CalEventOfferDiscounted $discounted
 * @property BookingPackageEventOfferRel[] $bookingPackageEventOfferRels
 * @property BookingUserbookingPackage[] $bookingUserbookingPackages
 */
class BookingPackage extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%booking_package}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bookable_id', 'name', 'amount', 'discounted_id'], 'required'],
            [['bookable_id', 'discounted_id', 'default_booked', 'create_user_id', 'update_user_id'], 'integer'],
            [['amount'], 'number'],
            [['description'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['bookable_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookingBookable::className(), 'targetAttribute' => ['bookable_id' => 'id']],
            [['discounted_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEventOfferDiscounted::className(), 'targetAttribute' => ['discounted_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('booking_package', 'ID'),
            'bookable_id' => Yii::t('booking_package', 'Bookable'),
            'name' => Yii::t('booking_package', 'Name'),
            'amount' => Yii::t('booking_package', 'Amount'),
            'discounted_id' => Yii::t('booking_package', 'Discounted ID'),
            'default_booked' => Yii::t('booking_package', 'Default Booked'),
            'description' => Yii::t('booking_package', 'Description'),
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
    public function getBookingPackageEventOfferRels()
    {
        return $this->hasMany(BookingPackageEventOfferRel::className(), ['package_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingUserbookingPackages()
    {
        return $this->hasMany(BookingUserbookingPackage::className(), ['package_id' => 'id']);
    }
}
