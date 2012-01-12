<?php
//load jScrollPane JS
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery.jscrollpane.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/mwheelIntent.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.mousewheel.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.jscrollpane.min.js');
//load jEditable JS
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.jeditable.mini.js');
// search form 
$this->renderPartial('_menu',array('action'=>'selected_profile')); 
?>
<!-- PROFILE: START -->
<div class="profile-view">
	<div class="profile-actions">
		<span style="float: left">1/21</span>
		<span style="float: right"> &laquo; Previous | Next &raquo;</span>
		<span style="float: right"><?php echo CHtml::button('Save PDF'); ?></span>
		<span style="float: right"><?php echo CHtml::button('Print'); ?></span>
		<span style="float: right"><?php echo CHtml::checkBox('Mark profile',false,array()).' Mark profile'?></span>
	</div>
	<div class="clear"></div>
	<div id="profile-<?php echo $model->id?>" class="profile-data"  style="height: 260px; ">
		<h3>Name</h3>
		<span><?php echo $model->name; ?></span>
		
		<h3>Geographical Area</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->geographical_area)); ?></span>
		
		<h3>Curent title</h3>
		<span><?php echo $model->title; ?></span>
		
		<h3>Present Employer</h3>
		<span><?php echo $model->present_employer->name; ?></span>
		
		<h3>Company info</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->contact_info)); ?></span>
		
		<h3>Profile/Biography/Past employers</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->profile)); ?></span>
		
		
		<?php 
// 		$form=$this->beginWidget('CActiveForm', array(
// 			'action'=>Yii::app()->createUrl($this->route),
// 			'method'=>'post',
// 		)); 
		?>
		<?php //echo $form->textArea($model,'misc_info',array('rows'=>6, 'cols'=>118)); ?>
		
		<?php //echo $form->error($model,'misc_info'); ?>
		<?php //$this->endWidget(); ?>
	</div>
	<div class="profile-notes">
		<h3>Notes</h3>
		<?php 
// 		$this->widget(
// 				'application.extensions.jeditable.DsJEditableWidget', 
// 				array(
// 						'model'				=>$model,
// 						'jeditable_type' 	=> 'textarea',
// 						'name'				=>'misc_info',
// 						'rows'				=> 6,
// 						'cols'				=> 118,
// 						'saveurl'			=>'/employees/update/'.$model->id,
// 						'data'	 			=> $model->misc_info,
// 			)) 
		?>
		<div class="edit_area" id="<?php echo $model->id ?>">
			<?php echo  Yii::app()->format->html(nl2br($model->misc_info))?>
		</div>
		
	</div>
	
</div>
<!-- PROFILE: END -->
<script type="text/javascript">
//<!--
$(document).ready(function(){
	$('.profile-data').jScrollPane();

    $('.edit_area').editable('/employees/saveNotes', { 
        type      	: 'textarea',
        name	  	: 'misc_info',
        placeholder	: 'Dubleclick to edit',
        loadurl  	: '/employees/loadNotes',
        loadtype   	: 'POST',
        loaddata 	: {id: "<?php echo $model->id ?>"},
        rows	  	: 6,
        cols	  	: 118,
        cancel    	: 'Cancel',
        submit    	: 'OK',
        event	  	: 'dblclick',
        //indicator 	: '<img src="img/indicator.gif">',
        tooltip   	: 'Dubleclick to edit...'
    });
});
//-->
</script>