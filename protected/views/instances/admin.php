<?php
$this->breadcrumbs=array(
	'Instances'=>array('index'),
	'Manage',
);
?>

<h1>Manage Instances</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'instances-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array(
			'name' => 'client_id',
			'value' => '$data->client->name',
			'filter' => CHtml::listData(Clients::model()->findAll(array('order' => 'name ASC')), 'id', 'name')
		),
		'created',
		'expire',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
