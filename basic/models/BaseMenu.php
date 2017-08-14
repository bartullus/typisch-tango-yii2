<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%base_menu}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $restricted
 * @property string $description
 * @property string $create_time
 * @property string $create_user_id
 * @property string $update_time
 * @property string $update_user_id
 *
 * @property BaseMenuItem[] $baseMenuItems
 */
class BaseMenu extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%base_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'create_time'], 'required'],
            [['restricted'], 'integer'],
            [['description'], 'string'],
            [['create_time', 'create_user_id', 'update_time', 'update_user_id'], 'safe'],
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
            'restricted' => Yii::t('menu', 'Restricted'),
            'description' => Yii::t('menu', 'Description'),
            'create_time' => Yii::t('menu', 'Create Time'),
            'create_user_id' => Yii::t('menu', 'Create User ID'),
            'update_time' => Yii::t('menu', 'Update Time'),
            'update_user_id' => Yii::t('menu', 'Update User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseMenuItems()
    {
        return $this->hasMany(BaseMenuItem::className(), ['menu_id' => 'id']);
    }
}
