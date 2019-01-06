<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$user = Yii::$app->user;
				
$this->title = 'Interner Bereich';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="intern-index">
<h1><?= Html::encode($this->title) ?></h1>

<?=	app\extensions\ttwidget\FlashDisplay::widget(); ?>

<p id="user">
Angemeldet: <b><?php echo $user->getUsername(); ?></b>
&nbsp;(<?php echo $user->getId(); ?>)
&nbsp;Letzter Login: <?php echo $user->getLastLoginTimeFormat(); ?>
&nbsp;Rechte: <?php echo $rights; ?>
</p>

<p id="logout">
	<?= Html::a('Logout', Url::toRoute('/intern/logout')); ?>
</p>

<code><?= __FILE__ ?></code>
</div>
