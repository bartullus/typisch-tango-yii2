<?php

namespace app\modules\cal\models;

use Yii;

/**
 * This is the model class for table "{{%cal_event}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $description
 * @property string $event_website
 * @property integer $parent_id
 * @property integer $category_id
 * @property integer $event_valid
 * @property integer $visible
 * @property string $start_date
 * @property string $end_date
 * @property string $start_time
 * @property string $end_time
 * @property integer $terms
 * @property string $terms_details
 * @property string $price
 * @property integer $max_number
 * @property integer $location_id
 * @property string $location_city
 * @property string $location_address
 * @property string $location_name
 * @property integer $organisator_id
 * @property string $organisator_name
 * @property string $organisator_website
 * @property string $organisator_email
 * @property string $organisator_telephone
 * @property integer $album_id
 * @property string $submitter_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalEventCategory $category
 * @property CalLocation $location
 * @property CalLocation $organisator
 * @property CalendarEvent $parent
 * @property CalendarEvent[] $calendarEvents
 * @property CalEventOffer[] $calEventOffers
 * @property CalEventSingledate[] $calEventSingledates
 */
class CalendarEvent extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cal_event}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id', 'start_date', 'location_city'], 'required'],
            [['description'], 'string'],
            [['parent_id', 'category_id', 'event_valid', 'visible', 'terms', 'max_number', 'location_id', 'organisator_id', 'album_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['start_date', 'end_date', 'start_time', 'end_time', 'create_time', 'update_time'], 'safe'],
            [['title', 'url', 'event_website', 'terms_details', 'price', 'location_city', 'location_address', 'location_name', 'organisator_name', 'organisator_website', 'organisator_email', 'organisator_telephone', 'submitter_id'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalEventCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalLocation::className(), 'targetAttribute' => ['location_id' => 'id']],
            [['organisator_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalLocation::className(), 'targetAttribute' => ['organisator_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalendarEvent::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('cal_event', 'ID'),
            'title' => Yii::t('cal_event', 'Title'),
            'url' => Yii::t('cal_event', 'Url'),
            'description' => Yii::t('cal_event', 'Description'),
            'event_website' => Yii::t('cal_event', 'Event Website'),
            'parent_id' => Yii::t('cal_event', 'Parent'),
            'category_id' => Yii::t('cal_event', 'Category'),
            'event_valid' => Yii::t('cal_event', 'Event Valid'),
            'visible' => Yii::t('cal_event', 'Visible'),
            'start_date' => Yii::t('cal_event', 'Start Date'),
            'end_date' => Yii::t('cal_event', 'End Date'),
            'start_time' => Yii::t('cal_event', 'Start Time'),
            'end_time' => Yii::t('cal_event', 'End Time'),
            'terms' => Yii::t('cal_event', 'Terms'),
            'terms_details' => Yii::t('cal_event', 'Terms Details'),
            'price' => Yii::t('cal_event', 'Price'),
            'max_number' => Yii::t('cal_event', 'Max Number'),
            'location_id' => Yii::t('cal_event', 'Location'),
            'location_city' => Yii::t('cal_event', 'Location City'),
            'location_address' => Yii::t('cal_event', 'Location Address'),
            'location_name' => Yii::t('cal_event', 'Location Name'),
            'organisator_id' => Yii::t('cal_event', 'Organisator'),
            'organisator_name' => Yii::t('cal_event', 'Organisator Name'),
            'organisator_website' => Yii::t('cal_event', 'Organisator Website'),
            'organisator_email' => Yii::t('cal_event', 'Organisator Email'),
            'organisator_telephone' => Yii::t('cal_event', 'Organisator Telephone'),
            'album_id' => Yii::t('cal_event', 'Album'),
            'submitter_id' => Yii::t('cal_event', 'Submitter'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CalEventCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(CalLocation::className(), ['id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisator()
    {
        return $this->hasOne(CalLocation::className(), ['id' => 'organisator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(CalendarEvent::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarEvents()
    {
        return $this->hasMany(CalendarEvent::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalEventOffers()
    {
        return $this->hasMany(CalEventOffer::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalEventSingledates()
    {
        return $this->hasMany(CalEventSingledate::className(), ['event_id' => 'id']);
    }
}
