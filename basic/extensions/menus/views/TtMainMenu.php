<!-- START: TtMainMenu -->
<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
	'brandLabel' => $brandLabel,
	'brandUrl' => Yii::$app->homeUrl,
  'options' => [
		'id' => 'mainmenu',
		'class' => 'navbar navbar-inverse navbar-fixed-top',
  ],
]);
echo Nav::widget([
	'options' => ['class' => 'navbar-nav navbar-right'],
	'items' => $menuitems,
]);
NavBar::end();
?>
<!-- END: TtMainMenu -->
