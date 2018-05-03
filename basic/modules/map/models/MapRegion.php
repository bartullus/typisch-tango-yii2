<?php

namespace app\modules\map\models;

use Yii;

/**
 * This is the model class for table "{{%map_region}}".
 *
 * @property integer $id
 * @property integer $state_id
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
 * @property MapCity[] $mapCities
 * @property MapState $state
 */
class MapRegion extends \app\modules\map\models\MapActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%map_region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
				return array_merge(parent::attributeLabels(), [
            [['state_id'], 'required'],
            [['state_id'], 'integer'],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => MapState::className(), 'targetAttribute' => ['state_id' => 'id']],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'state_id' => Yii::t('map_region', 'State ID'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMapCities()
    {
        return $this->hasMany(MapCity::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(MapState::className(), ['id' => 'state_id']);
    }
}
