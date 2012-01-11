<?php
// search form 
$this->renderPartial('_menu',array('action'=>'selected_profile')); 
?>
<!-- PROFILE: START -->
<div class="profile-view">
	<div class="profile-actions">
		<span>1/21</span>
		<span>Mark profile</span>
		<span>Save PDF</span>
		<span>Print</span>
		<span> &laquo; Previous</span> | <span>Next &raquo;</span>
	</div>
	<div id="profile-<?php echo $model->id?>" class="profile-data">
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
		
		<h3>Notes</h3>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route),
			'method'=>'post',
		)); ?>
		<?php echo $form->textArea($model,'misc_info',array('rows'=>6, 'cols'=>118)); ?>
		<?php $this->widget(
				'application.extensions.jeditable.DsJEditableWidget', 
				array(
						//'model'=>$model,
						'jeditable_type' => 'textarea',
						'name'=>'misc_info',
						'rows'=> 6,
						'cols'=> 118,
						//'tooltip' => 'Hint message - press to add your custom notes to this profile'
			)) ?>
		<?php echo $form->error($model,'misc_info'); ?>
		<?php $this->endWidget(); ?>
	</div>
</div>
<!-- PROFILE: START -->