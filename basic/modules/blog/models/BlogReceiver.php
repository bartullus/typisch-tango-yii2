<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_receiver}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $prename
 * @property string $email
 * @property string $info
 * @property integer $member
 * @property integer $valid
 * @property string $birthdate
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property BlogReceiverArticleRel[] $blogReceiverArticleRels
 * @property BlogArticle[] $articles
 */
class BlogReceiver extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_receiver}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['member', 'valid', 'create_user_id', 'update_user_id'], 'integer'],
            [['birthdate', 'create_time', 'update_time'], 'safe'],
            [['name', 'prename', 'email', 'info'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog_receiver', 'ID'),
            'name' => Yii::t('blog_receiver', 'Name'),
            'prename' => Yii::t('blog_receiver', 'Prename'),
            'email' => Yii::t('blog_receiver', 'Email'),
            'info' => Yii::t('blog_receiver', 'Info'),
            'member' => Yii::t('blog_receiver', 'Member'),
            'valid' => Yii::t('blog_receiver', 'Valid'),
            'birthdate' => Yii::t('blog_receiver', 'Birthdate'),
            'create_time' => Yii::t('blog_receiver', 'Create Time'),
            'create_user_id' => Yii::t('blog_receiver', 'Create User ID'),
            'update_time' => Yii::t('blog_receiver', 'Update Time'),
            'update_user_id' => Yii::t('blog_receiver', 'Update User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogReceiverArticleRels()
    {
        return $this->hasMany(BlogReceiverArticleRel::className(), ['receiver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(BlogArticle::className(), ['id' => 'article_id'])->viaTable('{{%blog_receiver_article_rel}}', ['receiver_id' => 'id']);
    }
}
