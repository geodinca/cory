<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'client-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'demo_title'); ?>
		<?php echo $form->textField($model,'demo_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'demo_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'application_title'); ?>
		<?php echo $form->textField($model,'application_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'application_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expiration'); ?>
		<?php echo $form->textField($model,'expiration'); ?>
		<?php echo $form->error($model,'expiration'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->