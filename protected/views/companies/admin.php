<?php
$this->breadcrumbs=array(
	'Companies'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Companies', 'url'=>array('index')),
	array('label'=>'Create Companies', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('companies-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
// search form 
$this->renderPartial('../employees/_menu',array('action'=>'companies_data')); 
?>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'companies-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'street',
		'city',
		'country',
		'state',
		/*
		'zip',
		'phone',
		'web',
		'products',
		'sales',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
