<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_receiver_article_rel}}".
 *
 * @property integer $id
 * @property integer $receiver_id
 * @property integer $article_id
 * @property integer $result
 * @property string $create_time
 * @property integer $create_user_id
 *
 * @property BlogArticle $article
 * @property BlogReceiver $receiver
 */
class BlogReceiverArticle extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_receiver_article_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receiver_id', 'article_id'], 'required'],
            [['receiver_id', 'article_id', 'result', 'create_user_id'], 'integer'],
            [['create_time'], 'safe'],
            [['receiver_id', 'article_id'], 'unique', 'targetAttribute' => ['receiver_id', 'article_id'], 'message' => 'The combination of Receiver ID and Article ID has already been taken.'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogArticle::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogReceiver::className(), 'targetAttribute' => ['receiver_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog_receiver', 'ID'),
            'receiver_id' => Yii::t('blog_receiver', 'Receiver ID'),
            'article_id' => Yii::t('blog_receiver', 'Article ID'),
            'result' => Yii::t('blog_receiver', 'Result'),
            'create_time' => Yii::t('blog_receiver', 'Create Time'),
            'create_user_id' => Yii::t('blog_receiver', 'Create User ID'),
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
    public function getReceiver()
    {
        return $this->hasOne(BlogReceiver::className(), ['id' => 'receiver_id']);
    }
}
