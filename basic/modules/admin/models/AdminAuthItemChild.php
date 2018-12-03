<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%admin_auth_item_child}}".
 *
 * @property integer $id
 * @property string $parent
 * @property string $child
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property AdminAuthItem $child0
 * @property AdminAuthItem $parent0
 */
class AdminAuthItemChild 
	extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_auth_item_child}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['create_user_id', 'update_user_id'], 'integer'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => AdminAuthItem::className(), 'targetAttribute' => ['child' => 'name']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => AdminAuthItem::className(), 'targetAttribute' => ['parent' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('admin_auth_item_child', 'ID'),
            'parent' => Yii::t('admin_auth_item_child', 'Parent'),
            'child' => Yii::t('admin_auth_item_child', 'Child'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(AdminAuthItem::className(), ['name' => 'child']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(AdminAuthItem::className(), ['name' => 'parent']);
    }
}
