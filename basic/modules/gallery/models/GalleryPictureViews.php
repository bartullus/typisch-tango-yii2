<?php

namespace app\modules\gallery\models;

use Yii;

/**
 * This is the model class for table "{{%gallery_picture_views}}".
 *
 * @property integer $picture_id
 * @property integer $views
 *
 * @property GalleryPicture $picture
 */
class GalleryPictureViews extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gallery_picture_views}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['picture_id'], 'required'],
            [['picture_id', 'views'], 'integer'],
            [['picture_id'], 'exist', 'skipOnError' => true, 'targetClass' => GalleryPicture::className(), 'targetAttribute' => ['picture_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'picture_id' => Yii::t('gallery_picture_views', 'Picture ID'),
            'views' => Yii::t('gallery_picture_views', 'Views'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPicture()
    {
        return $this->hasOne(GalleryPicture::className(), ['id' => 'picture_id']);
    }
}
