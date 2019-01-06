<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm 
	extends Model
{
	public $username;
	public $password;
	public $rememberMe = true;

	private $_user = false;


	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			// username and password are both required
			[['username', 'password'], 'required'],
			// rememberMe must be a boolean value
			['rememberMe', 'boolean'],
			// password is validated by validatePassword()
			['password', 'validatePassword'],
		];
	}

	/**
   * Validates the password.
   * This method serves as the inline validation for password.
   *
   * @param string $attribute the attribute currently being validated
   * @param array $params the additional name-value pairs given in the rule
   */
	public function validatePassword($attribute, $params)
	{
		//Yii::info('+ LoginForm::validatePassword()');
		if ($this->hasErrors()) {
			return;
		}
		
		$user = $this->getUser();
		if (!$user) {
			$this->addError($attribute, 'Incorrect username.');
			//Yii::info('- LoginForm::validatePassword() invalid username');
			return;
		}
			
		if (!$user->validatePassword($this->password)) {
			$this->addError($attribute, 'Incorrect password.');
			//Yii::info('+- LoginForm::validatePassword() invalid password');
			return;
		}
		//Yii::info('- LoginForm::validatePassword() ok');
	}

	/**
	 * Logs in a user using the provided username and password.
	 * @return bool whether the user is logged in successfully
	 */
	public function login()
	{
		//Yii::info('+ LoginForm::login()');
							
		if (!$this->validate()) {
			//Yii::info('- LoginForm::login() not valid');
			return false;
		}	
		
		$user = $this->getUser();
		$rememberMe = $this->rememberMe ? 3600*24*30 : 0;
		$result = Yii::$app->user->login($user, $rememberMe);
		
		//Yii::info('- LoginForm::login() result: '.$result);
		return $result;
	}

	/**
	 * Finds user by [[username]]
	 *
	 * @return User|null
	 */
	public function getUser()
	{
		//Yii::info('+ LoginForm::getUser()');
		if ($this->_user === false) {
			$this->_user = BaseUser::findByUsername($this->username);
    }

		//Yii::info('- LoginForm::getUser() user: '.$this->_user->id);
    return $this->_user;
	}
}
