<?php

namespace app\modules\booking\models;

use Yii;

/**
 * This is the model class for table "{{%booking_userbooking_item_type}}".
 *
 * @property integer $id
 * @property string $short
 * @property string $name
 * @property string $description
 * @property integer $offer_category_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property BookingUserbookingItem[] $bookingUserbookingItems
 * @property CalEventOfferCategory $offerCategory
 */
class BookingUserbookingItemType extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%booking_userbooking_item_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'short', 'name', 'offer_category_id'], 'required'],
            [['id', 'offer_category_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['description'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['short', 'name'], 'string', 'max' => 255],
            [['offer_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEventOfferCategory::className(), 'targetAttribute' => ['offer_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('booking_userbooking_item_type', 'ID'),
            'short' => Yii::t('booking_userbooking_item_type', 'Short'),
            'name' => Yii::t('booking_userbooking_item_type', 'Name'),
            'description' => Yii::t('booking_userbooking_item_type', 'Description'),
            'offer_category_id' => Yii::t('booking_userbooking_item_type', 'Offer Category ID'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingUserbookingItems()
    {
        return $this->hasMany(BookingUserbookingItem::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfferCategory()
    {
        return $this->hasOne(CalEventOfferCategory::className(), ['id' => 'offer_category_id']);
    }
}
