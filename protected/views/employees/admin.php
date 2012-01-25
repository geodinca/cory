<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Manage',
);

// $this->menu=array(
// 	array('label'=>'List Employees', 'url'=>array('index')),
// 	array('label'=>'Create Employees', 'url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('employees-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id=search-screen">
<?php
// tab menu
$this->renderPartial('_menu',array('action'=>'search_screen'));
?>

<?php
// search form displayed after a instance is seleted
if ($iActiveInstance) {
	$this->renderPartial('_search',array(
		'model'=>$model,
		'aPostedData' => $aPostedData,
		'iActiveInstance' => $iActiveInstance,
		'aHints' => $aHints,
	));
}
?>
</div>

