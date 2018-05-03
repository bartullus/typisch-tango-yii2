<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_receiver_blacklist}}".
 *
 * @property integer $id
 * @property string $email
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 */
class BlogReceiverBlacklist extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_receiver_blacklist}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['create_user_id', 'update_user_id'], 'integer'],
            [['email', 'description'], 'string', 'max' => 255],
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
            'email' => Yii::t('blog_receiver', 'Email'),
            'description' => Yii::t('blog_receiver', 'Description'),
            'create_time' => Yii::t('blog_receiver', 'Create Time'),
            'create_user_id' => Yii::t('blog_receiver', 'Create User ID'),
            'update_time' => Yii::t('blog_receiver', 'Update Time'),
            'update_user_id' => Yii::t('blog_receiver', 'Update User ID'),
        ];
    }
}
