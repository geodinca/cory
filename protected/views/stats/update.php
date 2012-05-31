<?php
$this->breadcrumbs=array(
	'Stats'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Stats', 'url'=>array('index')),
	array('label'=>'Create Stats', 'url'=>array('create')),
	array('label'=>'View Stats', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Stats', 'url'=>array('admin')),
);
?>

<h1>Update Stats <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>