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
//echo CHtml::button('Show only selected',array(
//	'class'=>'show-selected',
//	'onclick' => '$.updateGridView("employees-grid","chk_grid")'
//));
//
//Yii::app()->clientScript->registerScript('search', "
//$.updateGridView = function(gridID, name) {
//	var postData = \"{ids:$.fn.yiiGridView.getChecked('employees-grid','chk_grid')}\";
//	$.fn.yiiGridView.update(gridID, {
//		type:'POST',
//		data:JSON.stringify(postData),
//		url:'showSelected',
//		success:function(data) {
//			console.log('aaa '+data);
//			$.fn.yiiGridView.update('employees-grid');
//			//afterDelete(th,true,data);
//		},
//		error:function(XHR) {
//			//return afterDelete(th,false,XHR);
//		}
//	});
//}
//", CClientScript::POS_READY);

//	echo CHtml::ajaxLink("Show Selected",
//			$this->createUrl('showSelected'),
//			array(
//				"type" => "post",
//				"data" => "js:{ids:$.fn.yiiGridView.getChecked('employees-grid','chk_grid')}",
//				'success' => "function( data )
//					{
//						$.fn.yiiGridView.update('employees-grid',{data:});
//					}"
//			)
//		);
	?>
</div>

<?php

$sTemplate = (Yii::app()->user->credentials['type'] == 'admin') ? '{view}{update}{delete}' : '{view}';

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
			'checked' => 'in_array($data->id, $this->grid->controller->selectedEmployees)'
		),
		array(
			'header' => '#',
			'headerHtmlOptions' => array('width' => '2%'),
			'value'	 => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row + 1)'
		),
		array('name'=>'name','headerHtmlOptions' => array('width' => '12%')),
		array('name'=>'title','headerHtmlOptions' => array('width' => '14%')),
		array(
			'header'      => 'Employer',
			'name'        => 'companies_id',
			'htmlOptions' => array('class' => 'company_title'),
			'headerHtmlOptions' => array('width' => '14%'),
			'type'        => 'html',
			'value'       => array($this, 'getTooltip'),
			'filter'	=> CHtml::listData(Companies::model()->findAll(array('order' => 'name ASC')), 'id', 'name')
		),
		array('name'=>'geographical_area','headerHtmlOptions' => array('width' => '12%')),
		array(
			'header' => 'Note',
			'type'   => 'raw',
			'headerHtmlOptions' => array('width' => '40%'),
			'value'  => '$this->grid->controller->widget(\'application.widgets.GetUserNotes\', array("iEmployeeId" => $data->id, "iUserId" => Yii::app()->user->id), true);'
		),
		array(
			'class'=>'CButtonColumn',
			'template' => $sTemplate,
			'headerHtmlOptions' => array('width' => '5%'),
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