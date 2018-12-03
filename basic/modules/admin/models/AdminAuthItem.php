<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%admin_auth_item}}".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property AdminAuthAssignment[] $adminAuthAssignments
 * @property AdminAuthRule $ruleName
 * @property AdminAuthItemChild[] $adminAuthItemChildren
 * @property AdminAuthItemChild[] $adminAuthItemChildren0
 * @property AdminAuthItem[] $children
 * @property AdminAuthItem[] $parents
 */
class AdminAuthItem 
	extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_auth_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at', 'create_user_id', 'update_user_id'], 'integer'],
            [['description', 'data'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AdminAuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'name' => Yii::t('admin_auth_item', 'Name'),
            'type' => Yii::t('admin_auth_item', 'Type'),
            'description' => Yii::t('admin_auth_item', 'Description'),
            'rule_name' => Yii::t('admin_auth_item', 'Rule Name'),
            'data' => Yii::t('admin_auth_item', 'Data'),
            'created_at' => Yii::t('admin_auth_item', 'Created At'),
            'updated_at' => Yii::t('admin_auth_item', 'Updated At'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminAuthAssignments()
    {
        return $this->hasMany(AdminAuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AdminAuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminAuthItemChildren()
    {
        return $this->hasMany(AdminAuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminAuthItemChildren0()
    {
        return $this->hasMany(AdminAuthItemChild::className(), ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AdminAuthItem::className(), ['name' => 'child'])->viaTable('{{%admin_auth_item_child}}', ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(AdminAuthItem::className(), ['name' => 'parent'])->viaTable('{{%admin_auth_item_child}}', ['child' => 'name']);
    }
}
