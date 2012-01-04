<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Employees', 'url'=>array('index')),
	array('label'=>'Manage Employees', 'url'=>array('admin')),
);
?>

<h1>Create Employees</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>