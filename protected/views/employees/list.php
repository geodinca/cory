<?php
// search form 
$this->renderPartial('_menu',array('action'=>'search_screen')); 
?>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employees-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumn',
		),
		'id',
		'name',
		'title',
		array(
			'header' => 'Employer',
			'value' => '$data->present_employer->name'
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
