<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Interner Bereich';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="intern-index">
<h1><?= Html::encode($this->title) ?></h1>

<?=	app\extensions\ttwidget\FlashDisplay::widget(); ?>

<p id="user">
Angemeldet: <b><?php echo Yii::$app->user->getUsername(); ?></b>
&nbsp;(<?php echo Yii::$app->user->getId(); ?>)
&nbsp;Letzter Login: <?php echo strftime('%d.%m.%Y %H:%M:%S', Yii::$app->user->getLastLoginTime()); ?>
&nbsp;Rechte: <?php echo $this->context->getRights(); ?>
</p>

<code><?= __FILE__ ?></code>
</div>
