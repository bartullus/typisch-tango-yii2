<?php

namespace app\modules\cal\models;

use Yii;

/**
 * This is the model class for table "{{%cal_location}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $loc_name
 * @property string $url
 * @property string $description
 * @property integer $location_valid
 * @property integer $is_loc
 * @property integer $is_org
 * @property integer $show_address
 * @property string $person
 * @property string $email
 * @property string $website
 * @property string $telephone
 * @property integer $city_id
 * @property string $city
 * @property string $district
 * @property string $postcode
 * @property string $address
 * @property double $latitude
 * @property double $longitude
 * @property integer $mapZoomLevel
 * @property integer $album_id
 * @property string $colour
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property CalEvent[] $calEvents
 * @property CalEvent[] $calEvents0
 */
class CalendarLocation 
extends \app\modules\map\models\MapActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cal_location}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'loc_name', 'url', 'city'], 'required'],
            [['description'], 'string'],
            [['location_valid', 'is_loc', 'is_org', 'show_address', 'city_id', 'mapZoomLevel', 'album_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'loc_name', 'url', 'person', 'email', 'website', 'telephone', 'city', 'district', 'postcode', 'address', 'colour'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('cal_location', 'ID'),
            'name' => Yii::t('cal_location', 'Name'),
            'loc_name' => Yii::t('cal_location', 'Loc Name'),
            'url' => Yii::t('cal_location', 'Url'),
            'description' => Yii::t('cal_location', 'Description'),
            'location_valid' => Yii::t('cal_location', 'Location Valid'),
            'is_loc' => Yii::t('cal_location', 'Is Loc'),
            'is_org' => Yii::t('cal_location', 'Is Org'),
            'show_address' => Yii::t('cal_location', 'Show Address'),
            'person' => Yii::t('cal_location', 'Person'),
            'email' => Yii::t('cal_location', 'Email'),
            'website' => Yii::t('cal_location', 'Website'),
            'telephone' => Yii::t('cal_location', 'Telephone'),
            'city_id' => Yii::t('cal_location', 'City ID'),
            'city' => Yii::t('cal_location', 'City'),
            'district' => Yii::t('cal_location', 'District'),
            'postcode' => Yii::t('cal_location', 'Postcode'),
            'address' => Yii::t('cal_location', 'Address'),
            'latitude' => Yii::t('cal_location', 'Latitude'),
            'longitude' => Yii::t('cal_location', 'Longitude'),
            'mapZoomLevel' => Yii::t('cal_location', 'Map Zoom Level'),
            'album_id' => Yii::t('cal_location', 'Album ID'),
            'colour' => Yii::t('cal_location', 'Colour'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalEvents()
    {
        return $this->hasMany(CalEvent::className(), ['location_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalEvents0()
    {
        return $this->hasMany(CalEvent::className(), ['organisator_id' => 'id']);
    }
}
