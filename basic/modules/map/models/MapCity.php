<?php

namespace app\modules\map\models;

use Yii;

/**
 * This is the model class for table "{{%map_city}}".
 *
 * @property integer $id
 * @property integer $region_id
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
 * @property MapRegion $region
 */
class MapCity extends \app\modules\map\models\MapActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%map_city}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id'], 'required'],
            [['region_id'], 'integer'],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => MapRegion::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'region_id' => Yii::t('map_city', 'Region ID'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(MapRegion::className(), ['id' => 'region_id']);
    }
}
