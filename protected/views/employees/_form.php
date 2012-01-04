<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employees-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'companies_id'); ?>
		<?php echo $form->textField($model,'companies_id'); ?>
		<?php echo $form->error($model,'companies_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instances_id'); ?>
		<?php echo $form->textField($model,'instances_id'); ?>
		<?php echo $form->error($model,'instances_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'geographical_area'); ?>
		<?php echo $form->textField($model,'geographical_area',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'geographical_area'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_info'); ?>
		<?php echo $form->textArea($model,'contact_info',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'contact_info'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'home_street'); ?>
		<?php echo $form->textField($model,'home_street',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'home_street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'home_city'); ?>
		<?php echo $form->textField($model,'home_city',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'home_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'home_state_country'); ?>
		<?php echo $form->textField($model,'home_state_country',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'home_state_country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'home_zip'); ?>
		<?php echo $form->textField($model,'home_zip',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'home_zip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'home_phone'); ?>
		<?php echo $form->textField($model,'home_phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'home_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'actual_location_street'); ?>
		<?php echo $form->textField($model,'actual_location_street',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'actual_location_street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'actual_location_city'); ?>
		<?php echo $form->textField($model,'actual_location_city',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'actual_location_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'actual_location_state'); ?>
		<?php echo $form->textField($model,'actual_location_state',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'actual_location_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profile'); ?>
		<?php echo $form->textArea($model,'profile',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'profile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_entered'); ?>
		<?php echo $form->textField($model,'date_entered'); ?>
		<?php echo $form->error($model,'date_entered'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_update'); ?>
		<?php echo $form->textField($model,'date_update'); ?>
		<?php echo $form->error($model,'date_update'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'misc_info'); ?>
		<?php echo $form->textArea($model,'misc_info',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'misc_info'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->