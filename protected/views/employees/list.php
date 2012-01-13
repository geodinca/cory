<?php 
//load tooltip js 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tools.min.js');
?>

<?php
// search form 
$this->renderPartial('_menu',array('action'=>'search_screen')); 
?>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employees-grid',
	'dataProvider'=>$dataProvider, //$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumn',
			'selectableRows' => 2
		),
		'id',
		'name',
		'title',
		array(
			'header' => 'Employer',
			'htmlOptions'=>array('class' => 'company_title', ),
			'type' => 'html',
			'value' => array($this, 'getTooltip')
		),
		'geographical_area',
		//'contact_info',
		//'email',
		//'home_street',
		//'home_city',
		//'home_state_country',
		//'home_zip',
		//'home_phone',
		//'actual_location_street',
		//'actual_location_city',
		//'actual_location_state',
		'misc_info',
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