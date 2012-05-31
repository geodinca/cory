<?php
$this->breadcrumbs=array(
	'Stats'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('stats-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<p>&nbsp;</p>
<h1>Manage Stats</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
<?php //var_dump($dataProvider)?>
</div><!-- search-form -->
<?php $sTemplate = (Yii::app()->user->credentials['type'] == 'admin') ? '{view}{delete}' : '{view}';?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'stats-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		//'id',
		array(
			'header' => 'User',
			'name' => 'user_id',
			'value' => array($model,'renderUser'),
		),
		array(
			'header' => 'Data',
			'name' =>'login_date'
		),
		'search',
		array(
			'class'=>'CButtonColumn',
			'template' => $sTemplate,
			'htmlOptions' => array('class' => 'column-8'),
			'headerHtmlOptions' => array('width' => '50px'),
		),
	),
)); ?>
