<div id="clients-screen">
<?php
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	'Manage',
);

// $this->menu=array(
// 	array('label'=>'Create Client', 'url'=>array('create')),
// );
?>

<h1>Manage Clients</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clients-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
</div>