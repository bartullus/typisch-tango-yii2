<!-- START: TtAdminMenu -->
<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\extensions\sidebar\TtSidebar;

Navbar::begin([
	'brandLabel' => $brandLabel,
	'brandUrl' => Yii::$app->homeUrl,
	'innerContainerOptions' => ['class' => 'container-fluid'],
  'options' => [
		'id' => 'adminmenu',
		'class' => 'navbar navbar-inverse navbar-static-top',
	],
]);
echo Nav::widget([
	'options' => ['class' => 'navbar-nav navbar-right'],
	'items' => $menuitems,
]);
echo TtSidebar::widget([
	'menuItems' => $this->context->createAdminMenu(),
]);
NavBar::end();
?>
<!-- END: TtAdminMenu -->
