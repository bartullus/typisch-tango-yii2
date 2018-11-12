<?php

namespace app\modules\cal\models;

use Yii;

/**
 * This is the model class for table "{{%cal_event_offer}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $amount
 * @property integer $event_id
 * @property integer $category_id
 * @property integer $discounted_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalEventOfferCategory $category
 * @property CalEventOfferDiscounted $discounted
 * @property CalEvent $event
 */
class CalendarEventOffer extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cal_event_offer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'amount', 'event_id', 'category_id', 'discounted_id'], 'required'],
            [['amount'], 'number'],
            [['event_id', 'category_id', 'discounted_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEventOfferCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['discounted_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEventOfferDiscounted::className(), 'targetAttribute' => ['discounted_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEvent::className(), 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('cal_event_offer', 'ID'),
            'name' => Yii::t('cal_event_offer', 'Name'),
            'amount' => Yii::t('cal_event_offer', 'Amount'),
            'event_id' => Yii::t('cal_event_offer', 'Event ID'),
            'category_id' => Yii::t('cal_event_offer', 'Category ID'),
            'discounted_id' => Yii::t('cal_event_offer', 'Discounted ID'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CalEventOfferCategory::className(), ['id' => 'category_id']);
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
}
