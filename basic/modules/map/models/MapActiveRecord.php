<?php
namespace app\modules\map\models;

/**
 * Description of MapActiveRecord
 *
 * @author herbert
 */

class MapActiveRecord extends	\app\models\TtActiveRecord
{
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
      [['shortcut', 'name', 'url'], 'required'],
			[['description'], 'string'],
			[['latitude', 'longitude'], 'number'],
			[['mapZoomLevel', 'create_user_id', 'update_user_id'], 'integer'],
			[['create_time', 'update_time'], 'safe'],
			[['shortcut'], 'string', 'max' => 50],
			[['name', 'url'], 'string', 'max' => 255],
			[['shortcut'], 'unique'],
			[['name'], 'unique'],
			[['url'], 'unique'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'id' => Yii::t('map_region', 'ID'),
			'shortcut' => Yii::t('map_region', 'Shortcut'),
			'name' => Yii::t('map_region', 'Name'),
			'url' => Yii::t('map_region', 'Url'),
			'description' => Yii::t('map_region', 'Description'),
			'latitude' => Yii::t('map_region', 'Latitude'),
			'longitude' => Yii::t('map_region', 'Longitude'),
			'mapZoomLevel' => Yii::t('map_region', 'Map Zoom Level'),
		]);
	}
}
