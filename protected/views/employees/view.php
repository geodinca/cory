<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Employees', 'url'=>array('index')),
	array('label'=>'Create Employees', 'url'=>array('create')),
	array('label'=>'Update Employees', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Employees', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Employees', 'url'=>array('admin')),
);
?>

<h1>View Employees #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'companies_id',
		'instances_id',
		'name',
		'title',
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
		'profile',
		'date_entered',
		'date_update',
		'misc_info',
	),
)); ?>
