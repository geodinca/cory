<?php
$this->breadcrumbs=array(
	'Stats'=>array('index'),
	$model->id,
);
?>
<p>&nbsp;</p>

<h1>View Stats #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'user_id',
		'login_date',
		'search',
	),
)); ?>
