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
		<span><?php echo $model->geographical_area; ?></span>
		
		<h3>Curent title</h3>
		<span><?php echo $model->title; ?></span>
		
		<h3>Present Employer</h3>
		<span><?php echo $model->present_employer->name; ?></span>
		
		<h3>Company info</h3>
		<span><?php echo $model->contact_info; ?></span>
		
		<h3>Profile/Biography/Past employers</h3>
		<span><?php echo $model->profile; ?></span>
		
		<h3>Notes</h3>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route),
			'method'=>'post',
		)); ?>
		<?php echo $form->textArea($model,'misc_info',array('rows'=>6, 'cols'=>118)); ?>
		<?php echo $form->error($model,'misc_info'); ?>
		<?php $this->endWidget(); ?>
	</div>
</div>
<!-- PROFILE: START -->
<?php 
// $this->menu=array(
// 		array('label'=>'List Employees', 'url'=>array('index')),
// 		array('label'=>'Create Employees', 'url'=>array('create')),
// 		array('label'=>'Update Employees', 'url'=>array('update', 'id'=>$model->id)),
// 		array('label'=>'Delete Employees', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 		array('label'=>'Manage Employees', 'url'=>array('admin')),
// );
?>