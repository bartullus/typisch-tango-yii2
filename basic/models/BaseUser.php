<?php

namespace app\models;

use Yii;
use app\modules\admin\models\AdminAuthAssignment;

/**
 * This is the model class for table "{{%base_user}}".
 *
 * @property integer $id
 * @property integer $active
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $last_login_time
 * @property string $authKey
 * @property string $accessToken
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 */
class BaseUser 
	extends \app\models\TtActiveRecord
	implements \yii\web\IdentityInterface
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
			[['authKey', 'accessToken'], 'string', 'max' => 256],
			[['email', 'username'], 'unique'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'id' => Yii::t('user', 'ID'),
			'active' => Yii::t('user', 'Active'),
			'email' => Yii::t('user', 'Email'),
			'username' => Yii::t('user', 'Username'),
			'password' => Yii::t('user', 'Password'),
			'last_login_time' => Yii::t('user', 'Last Login Time'),
			'authKey' => Yii::t('user', 'Auth Key'),
			'accessToken' => Yii::t('user', 'Access Token'),            
		]);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRights()
	{
		return $this->hasMany(AdminAuthAssignment::className(), ['user_id' => 'id']);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		$user = self::findOne($id);
		return $user;
	}

  /**
   * Finds user by access token
   *
   * @param  string $token access token of the user
	 * @param  string $type not used
   * @return static|null
   */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		$user = self::find()->where(['accessToken' => $token])->one();
		return $user;
	}

  /**
   * Finds user by username or mail address
   *
   * @param  string      $username
   * @return static|null
   */
	public static function findByUsername($username)
	{
		//Yii::info('+ BaseUser::findByUsername() username: '.$username);
		// checks if $username fits saved username 
		$userByName = self::find()->where(['username' => $username])->one();
		if (isset($userByName)) {
			//Yii::info('- BaseUser::findByUsername() found user: '.$userByName->id.' name:'.$userByName->username);
			return $userByName;
		}
		
		// checks if $username fits saved mail address 
		$userByMail = self::find()->where(['email' => $username])->one();
		if (isset($userByMail)) {
			//Yii::info('- BaseUser::findByUsername() found user: '.$userByMail->id.' mail:'.$userByMail->email);
			return $userByMail;
		}
		
		//Yii::info('- BaseUser::findByUsername() NOT found!');
		return null;
	}

	public function getId()
	{
		return $this->getAttribute('id');
	}

	public function getUsername()
	{
		return $this->getAttribute('username');
	}

	public function getLastLoginTime()
	{
		return $this->getAttribute('last_login_time');
	}

	public function getAuthKey()
	{
		return $this->getAttribute('authKey');
	}

	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

  /**
   * Validates password
   *
   * @param  string  $password password to validate
   * @return boolean if password provided is valid for current user
   */
	public function validatePassword($password)
	{
		$encrypted_password = $this->encrypt($password);
		//Yii::info('validatePassword this->pw: '.$this->password);
		//Yii::info('given pw: '.$password. ' enc: '.$encrypted_password);
		return $this->password === $encrypted_password;
	}

	public function encrypt($value) {
		
		return md5($value);
	}

}

