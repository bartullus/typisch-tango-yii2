<?php

namespace app\modules\gallery\models;

use Yii;

/**
 * This is the model class for table "{{%gallery_picture}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $album_id
 * @property string $format
 * @property string $url
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property GalleryAlbum $album
 * @property GalleryPictureViews[] $galleryPictureViews
 */
class GalleryPicture extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gallery_picture}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'album_id'], 'required'],
            [['description'], 'string'],
            [['album_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'format', 'url'], 'string', 'max' => 255],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => GalleryAlbum::className(), 'targetAttribute' => ['album_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('gallery_picture', 'ID'),
            'name' => Yii::t('gallery_picture', 'Name'),
            'description' => Yii::t('gallery_picture', 'Description'),
            'album_id' => Yii::t('gallery_picture', 'Album ID'),
            'format' => Yii::t('gallery_picture', 'Format'),
            'url' => Yii::t('gallery_picture', 'Url'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(GalleryAlbum::className(), ['id' => 'album_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleryPictureViews()
    {
        return $this->hasMany(GalleryPictureViews::className(), ['picture_id' => 'id']);
    }
}
