<?php
//load tooltip js
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tools.min.js');
?>

<?php
// tab menu
$this->renderPartial('_menu',array('action'=>'search_result'));
?>

<div class="profile-actions">
	<?php echo CHtml::button('Show only selected',array('class'=>'show-selected')); ?>
</div>

<?php

$sTemplate = (Yii::app()->user->credentials['type'] == 'admin') ? '{view}{update}{delete}' : '{view}';

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employees-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumn',
			'selectableRows' => 2
		),
		array(
			'header' => '#',
			'value'	 => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row + 1)'
		),
		'name',
		'title',
		array(
			'header'      => 'Employer',
			'name'        => 'companies_id',
			'htmlOptions' => array('class' => 'company_title', ),
			'type'        => 'html',
			'value'       => array($this, 'getTooltip'),
			'filter'	=> CHtml::listData(Companies::model()->findAll(array('order' => 'name ASC')), 'id', 'name')
		),
		'geographical_area',
		array(
			'header' => 'Note',
			'type'   => 'raw',
			'value'  => '$this->grid->controller->widget(\'application.widgets.GetUserNotes\', array("iEmployeeId" => $data->id, "iUserId" => Yii::app()->user->id), true);'
		),
		array(
			'class'=>'CButtonColumn',
			'template' => $sTemplate
		),
	),
));
?>
<script>

// initialize tooltip
$(".ttip").tooltip({

	// tweak the position
	offset: [1, 1],

	// use the "slide" effect
	effect: 'slide'

// add dynamic plugin with optional configuration for bottom edge
}).dynamic({ bottom: { direction: 'down', bounce: true } });
</script>