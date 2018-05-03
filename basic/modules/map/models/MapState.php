<?php

namespace app\modules\map\models;

use Yii;

/**
 * This is the model class for table "tt2_map_state".
 *
 * @property integer $id
 * @property string $shortcut
 * @property string $name
 * @property string $url
 * @property string $description
 * @property double $latitude
 * @property double $longitude
 * @property integer $mapZoomLevel
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property MapRegion[] $mapRegions
 */
class MapState extends \app\modules\map\models\MapActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%map_state}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
				return array_merge(parent::attributeLabels(), [
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMapRegions()
    {
        return $this->hasMany(MapRegion::className(), ['state_id' => 'id']);
    }
}
