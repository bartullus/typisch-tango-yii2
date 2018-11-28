<?php

namespace app\modules\gallery\models;

use Yii;

/**
 * This is the model class for table "tt2_gallery_album_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property GalleryAlbum[] $galleryAlbums
 */
class GalleryAlbumCategory extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gallery_album_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['create_user_id', 'update_user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('gallery_album_category', 'ID'),
            'name' => Yii::t('gallery_album_category', 'Name'),
            'description' => Yii::t('gallery_album_category', 'Description'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleryAlbums()
    {
        return $this->hasMany(GalleryAlbum::className(), ['album_category_id' => 'id']);
    }
}
