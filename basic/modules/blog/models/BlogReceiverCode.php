<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "{{%blog_receiver_code}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $prename
 * @property string $email
 * @property integer $verified
 * @property string $ip_addr
 * @property string $create_time
 * @property integer $create_user_id
 */
class BlogReceiverCode 
	extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_receiver_code}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'email'], 'required'],
            [['verified', 'create_user_id'], 'integer'],
            [['create_time'], 'safe'],
            [['code'], 'string', 'max' => 32],
            [['name', 'prename', 'email'], 'string', 'max' => 255],
            [['ip_addr'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('blog_receiver', 'ID'),
            'code' => Yii::t('blog_receiver', 'Code'),
            'name' => Yii::t('blog_receiver', 'Name'),
            'prename' => Yii::t('blog_receiver', 'Prename'),
            'email' => Yii::t('blog_receiver', 'Email'),
            'verified' => Yii::t('blog_receiver', 'Verified'),
            'ip_addr' => Yii::t('blog_receiver', 'Ip Addr'),
        ]);
    }
}
