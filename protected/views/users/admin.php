<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Users', 'url'=>array('create')),
);

?>

<h1>Manage Users</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'name' => 'client_id',
			'value' => '$data->client->name',
			'filter' => CHtml::listData(Clients::model()->findAll(array('order' => 'name ASC')), 'id', 'name')
		),
		'username',
		'email',
		'status',
		'type',
		array(
			'name' => 'created',
			'type' => 'date'
		),
		array(
			'name' => 'updated',
			'type' => 'date'
		),
		array(
			'name' => 'expire',
			'type' => 'date'
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
