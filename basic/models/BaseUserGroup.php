<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%base_user_group}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 */
class BaseUserGroup extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%base_user_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'create_time'], 'required'],
            [['description'], 'string'],
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
        return [
            'id' => Yii::t('menu', 'ID'),
            'name' => Yii::t('menu', 'Name'),
            'description' => Yii::t('menu', 'Description'),
            'create_time' => Yii::t('menu', 'Create Time'),
            'create_user_id' => Yii::t('menu', 'Create User ID'),
            'update_time' => Yii::t('menu', 'Update Time'),
            'update_user_id' => Yii::t('menu', 'Update User ID'),
        ];
    }
}
