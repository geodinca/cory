<?php
//load tooltip js
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tools.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.cookie.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/main.js');
?>

<?php
$this->breadcrumbs=array(
	'Companies'=>array('index'),
	'Manage',
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

$('.addsearch-present-button').click(function(){
	var atLeastOneIsChecked = $('input[name=\"companies-grid_c0[]\"]:checked').length > 0;

	if (!atLeastOneIsChecked)
	{
		alert('Please select atleast one Company');
	}
	else
	{
		document.getElementById('companies-form').action='doCheckedPresent';
		document.getElementById('companies-form').submit();
	}

});

$('.addsearch-past-button').click(function(){
	var atLeastOneIsChecked = $('input[name=\"companies-grid_c0[]\"]:checked').length > 0;

	if (!atLeastOneIsChecked)
	{
		alert('Please select atleast one Company');
	}
	else
	{
		document.getElementById('companies-form').action='doCheckedPast';
		document.getElementById('companies-form').submit();
	}

});

");
?>

<?php
// search form
$this->renderPartial('../employees/_menu',array('action'=>'companies_data'));
?>
<div class="profile-actions">
	<span>
	<?php echo CHtml::button('Advanced Search',array('class'=>'search-button')); ?>
	</span>
	<span>
	<?php echo CHtml::button('Add sellection to Present Employers Search',
		array(
			'name'=>'btnaddsearchpresent',
			'class'=>'addsearch-present-button'
		)); ?>
	</span>
	<span>
	<?php echo CHtml::button('Add sellection to Present or Past Employers Search',
		array(
			'name'=>'btnaddsearchpast',
			'class'=>'addsearch-past-button'
		)); ?>
	</span>

	<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div>
</div><!-- search-form -->

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'companies-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array('enctype' => 'multipart/form-data')
));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'companies-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'enablePagination'=>false,
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumn',
			'selectableRows'  => 2,
		),
		array(
			'header' => '#',
			'value'	 => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row + 1)'
		),
		array(
			'name'=> 'name',
			'htmlOptions'=>array('class' => 'company_title', ),
			'type' => 'html',
			'value'=> array($this,'getTooltip'),
		),
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

<?php $this->endWidget(); ?>

<script>
/*<![CDATA[*/
$(document).ready(function(){
	//set cookie for checkboxes
//	console.log('doc ready');
//	cookieArray = $.cookie('company_check');
//	if (isArray(cookieArray)) {
//		$.cookie('company_check','test',{
//			expires: 1,
//			//path: '/',
//			//domain: 'example.com',
//			//secure: true,
//			raw: true
//		});
//	} else if (!cookieArray) {
//		var aEmpty = [0,1,2];
//		$.cookie('company_check',aEmpty,{
//			expires: 1,
//			//path: '/',
//			//domain: 'example.com',
//			//secure: true,
//			raw: true
//		});
//	}

	// initialize tooltip
	$(".ttip").live("mouseover", function(){
		$(this).tooltip({
			// tweak the position
			offset: [1, 1],
			// use the "slide" effect
			effect: 'slide'
		// add dynamic plugin with optional configuration for bottom edge
		}).dynamic({
			bottom: {
				direction: 'down',
				bounce: true
			}
		});
	});
});


//jQuery(function($) {
//
//	$("input[name='companies-grid_c0\[\]']").live('click', function() {
//		$.pushCookie('company_check',$(this).val());
//		console.log($(this).val());
//
//		//$('#companies-grid_c0_all').attr('checked', $("input[name='companies-grid_c0\[\]']").length==$("input[name='companies-grid_c0\[\]']:checked").length);
//	});
//});
/*]]>*/

</script>

