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
		return array_merge(parent::attributeLabels(), [
			'id' => Yii::t('user_group', 'ID'),
			'name' => Yii::t('user_group', 'Name'),
			'description' => Yii::t('user_group', 'Description'),
		]);
	}
}
