<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'instances-form',
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
		<?php echo $form->labelEx($model,'client_id'); ?>
		<?php echo $form->dropDownList($model, 'client_id' , CHtml::listData(Clients::model()->findAll(array('order' => 'name ASC')), 'id', 'name')); ?>
		<?php echo $form->error($model,'client_id'); ?>
	</div>

	<div class="row">
		<?php echo Chtml::label('Boolean Search Hint:', 'boolean_search'); ?>
		<?php echo CHtml::textField('Hint[boolean_search]',
				isset($aPostedData['boolean_search']) ? $aPostedData['boolean_search'] : '',
				array(
					'size'=>50,
					'maxlength'=>256,
					//'class' => 'search_form',
				)); ?>
	</div>

	<div class="row">
		<?php echo Chtml::label('Present Employeer Hint:', 'boolean_search'); ?>
		<?php echo CHtml::textField('Hint[present_employer]',
				isset($aPostedData['present_employer']) ? $aPostedData['present_employer'] : '',
				array(
					'size'=>50,
					'maxlength'=>256,
					//'class' => 'search_form',
				)); ?>
	</div>

	<div class="row">
		<?php echo Chtml::label('Present or Past Employer Hint:', 'present_or_past_employer'); ?>
		<?php echo CHtml::textField('Hint[present_or_past_employer]',
				isset($aPostedData['present_or_past_employer']) ? $aPostedData['present_or_past_employer'] : '',
				array(
					'size'=>50,
					'maxlength'=>256,
					//'class' => 'search_form',
				)); ?>
	</div>

	<div class="row">
		<?php echo Chtml::label('Area code Hint:', 'contact_info'); ?>
		<?php echo CHtml::textField('Hint[contact_info]',
				isset($aPostedData['contact_info']) ? $aPostedData['contact_info'] : '',
				array(
					'size'=>50,
					'maxlength'=>256,
					//'class' => 'search_form',
				)); ?>
	</div>

	<div class="row">
		<?php echo Chtml::label('Countries AND/OR US States:', 'country_state'); ?>
		<?php echo CHtml::textField('Hint[country_state]',
				isset($aPostedData['country_state']) ? $aPostedData['country_state'] : '',
				array(
					'size'=>50,
					'maxlength'=>256,
					//'class' => 'search_form',
				)); ?>
	</div>

	<div class="row">
		<?php echo Chtml::label('ANY of this words Hint:', 'any_word'); ?>
		<?php echo CHtml::textField('Hint[any_word]',
				isset($aPostedData['any_word']) ? $aPostedData['any_word'] : '',
				array(
					'size'=>50,
					'maxlength'=>256,
					//'class' => 'search_form',
				)); ?>
	</div>

	<div class="row">
		<?php echo Chtml::label('ALL of this words:', 'all_word'); ?>
		<?php echo CHtml::textField('Hint[all_word]',
				isset($aPostedData['all_word']) ? $aPostedData['all_word'] : '',
				array(
					'size'=>50,
					'maxlength'=>256,
					//'class' => 'search_form',
				)); ?>
	</div>

	<div class="row">
		<?php echo Chtml::label('NONE of this words Hint:', 'none_word'); ?>
		<?php echo CHtml::textField('Hint[none_word]',
				isset($aPostedData['none_word']) ? $aPostedData['none_word'] : '',
				array(
					'size'=>50,
					'maxlength'=>256,
					//'class' => 'search_form',
				)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expire'); ?>
		<?php echo $form->textField($model,'expire'); ?>
		<?php echo $form->error($model,'expire'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->