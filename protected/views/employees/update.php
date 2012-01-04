<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Employees', 'url'=>array('index')),
	array('label'=>'Create Employees', 'url'=>array('create')),
	array('label'=>'View Employees', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Employees', 'url'=>array('admin')),
);
?>

<h1>Update Employees <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>