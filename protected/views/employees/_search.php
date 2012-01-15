<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('/employees/list'),
//	'method'=>'get',
	'method'=>'post',
)); ?>

	<div class="row">
		<?php echo Chtml::label('Boolean Search:', 'boolean_search'); ?>
		<?php echo CHtml::textField('Search[boolean_search]', isset($aPostedData['Search']['boolean_search']) ? $aPostedData['Search']['boolean_search'] : '', array(
				'size'=>50,
				'maxlength'=>256,
				'class' => 'search_form',
				)); ?>
		<p class="hint">
			Hint: Boolean Search.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('Present Employer:', 'present_employer'); ?>
		<?php echo CHtml::hiddenField('Search[present_employer]', isset($aPostedData['Search']['present_employer']) ? $aPostedData['Search']['present_employer'] : ''); ?>
		<?php
			$aCompanies = CHtml::ListData(Companies::model()->findAll(), 'id', 'name');
			$this->widget('application.extensions.multicomplete.MultiComplete', array(
					'updater' => 'Search_present_employer',
					'splitter'=>'::',
					'source'=>$aCompanies,
					'options'=>array(
						'minLength'=>'2',
					),
					'htmlOptions'=>array(
						'size'=>'60',
						'name' => 'present_employer',
						'id' => 'present_employer',
						'class' => 'search_form',
					),
					'value' => isset($aPostedData['present_employer']) ? $aPostedData['present_employer'] : ''
			));
		?>
		<p class="hint">
			Hint: Present Employer with autocomplete.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('Present or Past Employer:', 'present_or_past_employer'); ?>
		<?php
			$this->widget('application.extensions.multicomplete.MultiComplete', array(
					'splitter'=>'::',
					'source'=>$aCompanies,
					'options'=>array(
						'minLength'=>'2',
					),
					'htmlOptions'=>array(
						'size'=>'60',
						'name' => 'Search[present_or_past_employer]',
						'id' => 'Search_present_or_past_employer',
						'class' => 'search_form',
					),
					'value' => isset($aPostedData['Search']['present_or_past_employer']) ? $aPostedData['Search']['present_or_past_employer'] : ''
			));
		?>
		<p class="hint">
			Hint: Present or Past Employer with autocomplete.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('Code area:', 'contact_info'); ?>
		<?php echo CHtml::textField('Search[contact_info]', isset($aPostedData['Search']['contact_info']) ? $aPostedData['Search']['contact_info'] : ''); ?>
		<p class="hint">
			Hint: Use telephone prefixes.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('Countries AND/OR US States:', 'country_state'); ?>
		<?php
			$this->widget('application.extensions.multicomplete.MultiComplete', array(
					'splitter'=>'::',
					'source'=>CHtml::listData(Employees::model()->findAll(array('group' => 'geographical_area')), 'geographical_area', 'geographical_area'),
					'options'=>array(
						'minLength'=>'2',
					),
					'htmlOptions'=>array(
						'size'=>'60',
						'name' => 'Search[country_state]',
						'id' => 'Search_country_state',
						'class' => 'search_form',
					),
					'value' => isset($aPostedData['Search']['country_state']) ? $aPostedData['Search']['country_state'] : ''
			));
		?>
		<p class="hint">
			Hint: Countries AND/OR US States.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('ANY of this words:', 'any_word'); ?>
		<?php echo CHtml::textField('Search[any_word]', isset($aPostedData['Search']['any_word']) ? $aPostedData['Search']['any_word'] : '', array(
				'size'=>50,
				'maxlength'=>256,
				'class' => 'search_form',
				));
		?>
		<p class="hint">Hint: ANY of this words</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('ALL of this words:', 'all_word'); ?>
		<?php echo CHtml::textField('Search[all_word]', isset($aPostedData['Search']['any_word']) ? $aPostedData['Search']['all_word'] : '', array(
				'size'=>50,
				'maxlength'=>256,
				'class' => 'search_form',
				)); ?>
		<p class="hint">Hint: ALL of this words</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('NONE of this words:', 'none_word'); ?>
		<?php echo CHtml::textField('Search[none_word]', isset($aPostedData['Search']['any_word']) ? $aPostedData['Search']['none_word'] : '', array(
				'size'=>50,
				'maxlength'=>256,
				'class' => 'search_form',
				)); ?>
		<p class="hint">Hint: NONE of this words</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::resetButton('Reset');?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->