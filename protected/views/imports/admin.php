<div id="import-screen">
	<h1><?php echo Yii::t('app','Import from excel'); ?></h1>
	
	<div class="form">
	<?php
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'import-form',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype'=>'multipart/form-data')
	));
	?>
	
		<!-- Instance details	-->
		<h2>Instance details</h2>
		<?php echo $form->errorSummary($oInstanceModel); ?>
	
		<div class="row">
			<?php echo $form->labelEx($oInstanceModel,'name'); ?>
			<?php echo $form->textField($oInstanceModel,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($oInstanceModel,'name'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($oInstanceModel,'client_id'); ?>
			<?php echo $form->dropDownList($oInstanceModel, 'client_id', CHtml::listData(Clients::model()->findAll(array('order' => 'name ASC')), 'id', 'name')); ?>
			<?php echo $form->error($oInstanceModel,'client_id'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($oInstanceModel,'expire'); ?>
			<?php echo $form->textField($oInstanceModel,'expire'); ?>
			<?php echo $form->error($oInstanceModel,'expire'); ?>
		</div>
	
	
		<!-- Import fields -->
		<h2>Import details</h2>
		<div class="row even">
			<?php echo CHtml::activeLabelEx($model, 'importdata'); ?>
			<?php echo CHtml::activeFileField($model, 'importdata'); ?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton(Yii::t('app', 'Import')); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>