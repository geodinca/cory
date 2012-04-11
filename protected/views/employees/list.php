<?php
//load tooltip js
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tools.min.js');
?>

<?php
// tab menu
$this->renderPartial('_menu',array('action'=>'search_result'));
?>

<div class="profile-actions">
<?php
	if(!isset($_GET['showSelected'])) {
		echo CHtml::link(
			"Show Selected",
			Yii::app()->createUrl('/employees/list',array('showSelected'=>1))
		);
	} else {
		echo CHtml::link(
			"Show All",
			Yii::app()->createUrl('/employees/list')
		);
	}
	?>
</div>

<?php

$sTemplate = (Yii::app()->user->credentials['type'] == 'admin') ? '{view}{update}{delete}' : '{view}';
$aSessionUser = unserialize(Yii::app()->session->get('app_setts'));
$aCurrentInstanceId = $aSessionUser['current_instance_id'];
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employees-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'selectableRows'=>2,
	'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('view').'/id/"+$.fn.yiiGridView.getSelection(id);}',
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumn',
			'selectableRows' => 2,
			'id' => 'chk_grid',
			'htmlOptions' => array('class' => 'column-1'),
			'checked' => 'in_array($data->id, $this->grid->controller->selectedEmployees)'
		),
		array(
			'header' => '#',
			'headerHtmlOptions' => array('width' => '15px'),
			'htmlOptions' => array('class' => 'column-2'),
			'value'	 => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row + 1)'
		),
		array('name'=>'name','headerHtmlOptions' => array('width' => '150px'), 'htmlOptions' => array('class' => 'column-3'),),
		array('name'=>'title','headerHtmlOptions' => array('width' => '150px'), 'htmlOptions' => array('class' => 'column-4'),),
		array(
			'header'      => 'Employer',
			'name'        => 'companies_id',
			'htmlOptions' => array('class' => 'company_title column-5'),
			'headerHtmlOptions' => array('width' => '150px'),
			'type'        => 'html',
			'value'       => array($this, 'getTooltip'),
			'filter'	=> CHtml::listData(Companies::model()->findAll(array('condition'=>'instances_id = '.$aCurrentInstanceId,'order' => 'name ASC')), 'id', 'name')
		),
		array('name'=>'geographical_area','headerHtmlOptions' => array('width' => '150px'), 'htmlOptions' => array('class' => 'column-6'),),
		array(
			'header' => 'Notes',
			'type'   => 'raw',
			'headerHtmlOptions' => array('width' => '500px'),
			'htmlOptions' => array('class' => 'column-7'),
			'value'  => '$this->grid->controller->widget(\'application.widgets.GetUserNotes\', array("iEmployeeId" => $data->id, "iUserId" => Yii::app()->user->id), true);'
		),
		array(
			'class'=>'CButtonColumn',
			'template' => $sTemplate,
			'htmlOptions' => array('class' => 'column-8'),
			'headerHtmlOptions' => array('width' => '50px'),
		),
	),
));
?>

<script type="text/javascript">
$(function(){
	$('input[id^="chk_grid"]').live('click', function(){
		var action = '';
		if($(this).is(':checked')){
			action = 'add';
		} else {
			action = 'remove';
		}

		$.post(
			"<?php echo Yii::app()->createUrl('/employees/selection'); ?>",
			{id: $(this).val(), action: action}
		);
	});
});


// initialize tooltip
$(function(){
	$(".ttip").live("mouseover", function(){
		$(this).tooltip({
			// tweak the position
			offset: [1, 1],
			// use the "slide" effect
			effect: 'slide'
		}); //.dynamic({ bottom: { direction: 'down', bounce: true } });
	});
});



</script>