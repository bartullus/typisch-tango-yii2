<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="intern-login">
<h1><?= Html::encode($this->title) ?></h1>

<p>Bitte gib deine Zugangsdaten ein:</p>

<?php $form = ActiveForm::begin([
	'id' => 'login-form',
	'layout' => 'horizontal',
	'fieldConfig' => [
		'template' => "{label}\n<div class=\"col-md-3\">{input}</div>\n<div class=\"col-md-6\">{error}</div>",
		'labelOptions' => ['class' => 'col-md-3 control-label'],
	],
]); ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'rememberMe')->checkbox([
	'template' => "<div class=\"col-md-offset-3 col-md-3\">{input} {label}</div>\n<div class=\"col-md-6\">{error}</div>",
]) ?>

<div class="form-group">
<div class="col-md-offset-3 col-md-9">
<?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
</div>
</div>

<?php ActiveForm::end(); ?>

</div>
