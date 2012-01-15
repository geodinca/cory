<div id="clients-screen">
<?php
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Clients', 'url'=>array('create')),
	array('label'=>'Manage Clients', 'url'=>array('admin')),
);
?>

<h1>Update client: <b><?php echo CHtml::encode($model->name); ?></b></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<h2>Client instances</h2>
<?php
// client instances
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'instances-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'id',
		'name',
		array(
			'name' => 'created',
			'type' => 'dateTime'
		),
		array(
			'name' => 'expire',
			'type' => 'dateTime'
		),
		array(
			'class' => 'CButtonColumn',
			'template' => '{edit}'
		),
	),
));
?>
</div>