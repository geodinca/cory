<?php
//load tooltip js
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tools.min.js');
?>

<?php
// search form
$this->renderPartial('_menu',array('action'=>'search_screen'));
?>
<?php

$sTemplate = (Yii::app()->user->credentials['type'] == 'admin') ? '{view}{update}{delete}' : '{view}';

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employees-grid',
	'dataProvider'=>$dataProvider, //$model->search(),
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
		'misc_info',
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