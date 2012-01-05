<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Employees', 'url'=>array('index')),
	array('label'=>'Create Employees', 'url'=>array('create')),
);

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

<?php
// search form 
$this->renderPartial('_search',array('model'=>$model)); 
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employees-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'title',
		array(
			'header' => 'Employer',
			'value' => '$data->present_employer->name'
		),
		'geographical_area',
		'contact_info',
		'email',
		'home_street',
		'home_city',
		'home_state_country',
		'home_zip',
		'home_phone',
		'actual_location_street',
		'actual_location_city',
		'actual_location_state',
		'misc_info',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
