<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_article_keyword_rel}}".
 *
 * @property integer $article_id
 * @property integer $keyword_id
 *
 * @property BlogArticle $article
 * @property BlogArticleKeyword $keyword
 */
class BlogArticleKeywordRel extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_article_keyword_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'keyword_id'], 'required'],
            [['article_id', 'keyword_id'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogArticle::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['keyword_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogArticleKeyword::className(), 'targetAttribute' => ['keyword_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => Yii::t('blog_article_keyword', 'Article ID'),
            'keyword_id' => Yii::t('blog_article_keyword', 'Keyword ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(BlogArticle::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKeyword()
    {
        return $this->hasOne(BlogArticleKeyword::className(), ['id' => 'keyword_id']);
    }
}
