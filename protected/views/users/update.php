<div id="users-screen">
<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Update user: <b><?php echo CHtml::encode($model->username); ?></b></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>