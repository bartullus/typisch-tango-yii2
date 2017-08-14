<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%base_user}}".
 *
 * @property integer $id
 * @property integer $active
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $last_login_time
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 */
class BaseUser extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%base_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'create_user_id', 'update_user_id'], 'integer'],
            [['email', 'username', 'create_time'], 'required'],
            [['last_login_time', 'create_time', 'update_time'], 'safe'],
            [['email', 'username', 'password'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('menu', 'ID'),
            'active' => Yii::t('menu', 'Active'),
            'email' => Yii::t('menu', 'Email'),
            'username' => Yii::t('menu', 'Username'),
            'password' => Yii::t('menu', 'Password'),
            'last_login_time' => Yii::t('menu', 'Last Login Time'),
            'create_time' => Yii::t('menu', 'Create Time'),
            'create_user_id' => Yii::t('menu', 'Create User ID'),
            'update_time' => Yii::t('menu', 'Update Time'),
            'update_user_id' => Yii::t('menu', 'Update User ID'),
        ];
    }
}
