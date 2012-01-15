<div id="instances-screen">
<?php
$this->breadcrumbs=array(
	'Instances'=>array('index'),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage Instances', 'url'=>array('admin')),
);
?>

<h1>Update Instances <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>