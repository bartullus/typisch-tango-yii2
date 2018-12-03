<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%admin_auth_rule}}".
 *
 * @property integer $id
 * @property string $name
 * @property resource $data
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property AdminAuthItem[] $adminAuthItems
 */
class AdminAuthRule 
	extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_auth_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['data'], 'string'],
            [['created_at', 'updated_at', 'create_user_id', 'update_user_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('admin_auth_rule', 'ID'),
            'name' => Yii::t('admin_auth_rule', 'Name'),
            'data' => Yii::t('admin_auth_rule', 'Data'),
            'created_at' => Yii::t('admin_auth_rule', 'Created At'),
            'updated_at' => Yii::t('admin_auth_rule', 'Updated At'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminAuthItems()
    {
        return $this->hasMany(AdminAuthItem::className(), ['rule_name' => 'name']);
    }
}
