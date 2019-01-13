<div id="SidebarSearch" class="panel panel-default">
	<div class="panel-body">
<?php

use yii\helpers\Html;

$icon = Html::tag('span', "", [
		'class' => 'glyphicon glyphicon-search', 
		'title' => 'Suche' 
]);

$button = Html::submitButton($icon, [
	'class' => 'btn btn-default',
]);

$buttonGroup = Html::tag('span', $button, [
	'class' => 'input-group-btn',
]);

$input = Html::textInput('search', $search, [
	'id' => 'search',
	'placeholder' => $placeholder,
	'class' => 'form-control',
]);
				
echo Html::beginForm($searchUrl, 'get',	[ 
	'name' => 'searchform',
	'class' => 'form-inline'
]);

echo Html::tag('div', $input.$buttonGroup, [
	'class' => 'input-group col-md-12',	
]);

echo Html::endForm();
?>
	</div>
</div>