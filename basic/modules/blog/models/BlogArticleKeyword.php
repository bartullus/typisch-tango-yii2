<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_article_keyword}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property BlogArticleKeywordRel[] $blogArticleKeywordRels
 */
class BlogArticleKeyword 
	extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_article_keyword}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['create_user_id', 'update_user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('blog_article_keyword', 'ID'),
            'name' => Yii::t('blog_article_keyword', 'Name'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticleKeywordRels()
    {
        return $this->hasMany(BlogArticleKeywordRel::className(), ['keyword_id' => 'id']);
    }
}
