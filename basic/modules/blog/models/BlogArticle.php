<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_article}}".
 *
 * @property integer $id
 * @property integer $status_id
 * @property integer $category_id
 * @property string $pub_date
 * @property string $title
 * @property string $url
 * @property string $content
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property BlogArticleCategory $category
 * @property BlogArticleStatus $status
 * @property BlogArticleKeywordRel[] $blogArticleKeywordRels
 */
class BlogArticle 
	extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id', 'category_id', 'pub_date', 'title', 'url'], 'required'],
            [['status_id', 'category_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['pub_date', 'create_time', 'update_time'], 'safe'],
            [['content', 'description'], 'string'],
            [['title', 'url'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogArticleCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogArticleStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('blog_article', 'ID'),
            'status_id' => Yii::t('blog_article', 'Status ID'),
            'category_id' => Yii::t('blog_article', 'Category ID'),
            'pub_date' => Yii::t('blog_article', 'Pub Date'),
            'title' => Yii::t('blog_article', 'Title'),
            'url' => Yii::t('blog_article', 'Url'),
            'content' => Yii::t('blog_article', 'Content'),
            'description' => Yii::t('blog_article', 'Description'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(BlogArticleCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(BlogArticleStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticleKeywordRels()
    {
        return $this->hasMany(BlogArticleKeywordRel::className(), ['article_id' => 'id']);
    }
}
