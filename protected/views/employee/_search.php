<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clients_id'); ?>
		<?php echo $form->textField($model,'clients_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'companies_id'); ?>
		<?php echo $form->textField($model,'companies_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'geographical_area'); ?>
		<?php echo $form->textField($model,'geographical_area',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_info'); ?>
		<?php echo $form->textArea($model,'contact_info',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'home_street'); ?>
		<?php echo $form->textField($model,'home_street',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'home_city'); ?>
		<?php echo $form->textField($model,'home_city',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'home_state_country'); ?>
		<?php echo $form->textField($model,'home_state_country',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'home_zip'); ?>
		<?php echo $form->textField($model,'home_zip',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'home_phone'); ?>
		<?php echo $form->textField($model,'home_phone',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'actual_location_street'); ?>
		<?php echo $form->textField($model,'actual_location_street',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'actual_location_city'); ?>
		<?php echo $form->textField($model,'actual_location_city',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'actual_location_state'); ?>
		<?php echo $form->textField($model,'actual_location_state',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'profile'); ?>
		<?php echo $form->textArea($model,'profile',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_entered'); ?>
		<?php echo $form->textField($model,'date_entered'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_update'); ?>
		<?php echo $form->textField($model,'date_update'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'misc_info'); ?>
		<?php echo $form->textArea($model,'misc_info',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->