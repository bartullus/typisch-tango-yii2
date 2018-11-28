<?php

namespace app\modules\gallery\models;

use Yii;

/**
 * This is the model class for table "tt2_gallery_album".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $description
 * @property integer $album_category_id
 * @property integer $public
 * @property integer $in_gallery
 * @property integer $thumbnail_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property GalleryAlbumCategory $albumCategory
 * @property GalleryPicture[] $galleryPictures
 */
class GalleryAlbum extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gallery_album}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['album_category_id', 'public', 'in_gallery', 'thumbnail_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'url'], 'string', 'max' => 255],
            [['album_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => GalleryAlbumCategory::className(), 'targetAttribute' => ['album_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('gallery_album', 'ID'),
            'name' => Yii::t('gallery_album', 'Name'),
            'url' => Yii::t('gallery_album', 'Url'),
            'description' => Yii::t('gallery_album', 'Description'),
            'album_category_id' => Yii::t('gallery_album', 'Album Category ID'),
            'public' => Yii::t('gallery_album', 'Public'),
            'in_gallery' => Yii::t('gallery_album', 'In Gallery'),
            'thumbnail_id' => Yii::t('gallery_album', 'Thumbnail ID'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumCategory()
    {
        return $this->hasOne(GalleryAlbumCategory::className(), ['id' => 'album_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleryPictures()
    {
        return $this->hasMany(GalleryPicture::className(), ['album_id' => 'id']);
    }
}
