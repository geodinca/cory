<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo Chtml::label('Boolean Search:', 'boolean_search'); ?>
		<?php echo CHtml::textField('boolean_search', 'enter text...', array('size'=>50,'maxlength'=>256)); ?>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('Present Employer:', 'present_employer'); ?>
		<?php echo CHtml::textField('present_employer', 'enter text...', array('size'=>50,'maxlength'=>256)); ?>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('Present or Past Employer:', 'present_or_past_employer'); ?>
		<?php echo CHtml::textField('present_or_past_employer', 'enter text...', array('size'=>50,'maxlength'=>256)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'geographical_area'); ?>
		<?php echo $form->textField($model,'geographical_area',array('size'=>60,'maxlength'=>255)); ?>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('Countries AND/OR US States:', 'country_state'); ?>
		<?php echo CHtml::textField('country_state', 'enter text...', array('size'=>50,'maxlength'=>256)); ?>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('ANY of this words:', 'any_word'); ?>
		<?php echo CHtml::textField('any_word', 'enter text...', array('size'=>50,'maxlength'=>256)); ?>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('ALL of this words:', 'all_word'); ?>
		<?php echo CHtml::textField('all_word', 'enter text...', array('size'=>50,'maxlength'=>256)); ?>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('NONE of this words:', 'none_word'); ?>
		<?php echo CHtml::textField('none_word', 'enter text...', array('size'=>50,'maxlength'=>256)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->