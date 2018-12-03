<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%admin_auth_assignment}}".
 *
 * @property integer $id
 * @property string $item_name
 * @property integer $user_id
 * @property integer $created_at
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property AdminAuthItem $itemName
 * @property BaseUser $user
 */
class AdminAuthAssignment 
	extends \app\models\TtActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_auth_assignment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name'], 'required'],
            [['user_id', 'created_at', 'create_user_id', 'update_user_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['item_name'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id'], 'message' => 'The combination of Item Name and User ID has already been taken.'],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AdminAuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => BaseUser::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
				return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('admin_auth_assignment', 'ID'),
            'item_name' => Yii::t('admin_auth_assignment', 'Item Name'),
            'user_id' => Yii::t('admin_auth_assignment', 'User ID'),
            'created_at' => Yii::t('admin_auth_assignment', 'Created At'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AdminAuthItem::className(), ['name' => 'item_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(BaseUser::className(), ['id' => 'user_id']);
    }
}
