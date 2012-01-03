<?php
$this->breadcrumbs=array(
	'Companys',
);

$this->menu=array(
	array('label'=>'Create Company', 'url'=>array('create')),
	array('label'=>'Manage Company', 'url'=>array('admin')),
);
?>

<h1>Companys</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
