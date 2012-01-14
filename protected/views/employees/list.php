<?php
//load tooltip js
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tools.min.js');
?>

<?php
// tab menu
$this->renderPartial('_menu',array('action'=>'search_screen'));
?>

<div class="profile-actions">
<?php echo CHtml::button('Show only selected',array('class'=>'show-selected')); ?>
</div>

<?php
//$i = 1;
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
		//'id',
		'name',
		'title',
// 		array(
// 		    'name' => 'company_name',
// 		    'value' => '$data->present_employer->name'
// 		),
		array(
			'header'      => 'Employer',
		    'name'        => 'company_name',
			'htmlOptions' => array('class' => 'company_title', ),
			'type'        => 'html',
			'value'       => array($this, 'getTooltip')
		),
		'geographical_area',
		array(
		    'name'       => 'note',
		    'type'        => 'html',
		    'value'      => '$data->notes->note'
		),
		array(
			'class'=>'CButtonColumn',
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