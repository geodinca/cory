<?php
$this->breadcrumbs=array(
	'Stats',
);

$this->menu=array(
	array('label'=>'Create Stats', 'url'=>array('create')),
	array('label'=>'Manage Stats', 'url'=>array('admin')),
);
?>

<h1>Stats</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
