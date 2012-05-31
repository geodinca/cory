<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stats-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'login_date'); ?>
		<?php echo $form->textField($model,'login_date'); ?>
		<?php echo $form->error($model,'login_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'search'); ?>
		<?php echo $form->textArea($model,'search',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'search'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->