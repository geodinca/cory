<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
//	'method'=>'get',
	'method'=>'post',
)); ?>

	<div class="row">
		<?php echo Chtml::label('Boolean Search:', 'boolean_search'); ?>
		<?php echo CHtml::textField('Search[boolean_search]', 'enter text...', array(
				'size'=>50,
				'maxlength'=>256,
				'class' => 'search_form',
				)); ?>
		<p class="hint">
			Hint: Boolean Search</tt>.
		</p>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('Present Employer:', 'present_employer'); ?>
		<?php echo CHtml::hiddenField('Search[present_employer]', null); ?>
		<?php
			$aCompanies = CHtml::ListData(Companies::model()->findAll(), 'id', 'name');
			$this->widget('application.extensions.multicomplete.MultiComplete', array(
					'updater' => 'Search_present_employer',
					'splitter'=>',',
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
			  ));
		?>
		<p class="hint">
			Hint: Present Employer with autocomplete</tt>.
		</p>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('Present or Past Employer:', 'present_or_past_employer'); ?>
		<?php
			$this->widget('application.extensions.multicomplete.MultiComplete', array(
					'splitter'=>',',
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
			  ));
		?>
		<p class="hint">
			Hint: Present or Past Employer with autocomplete</tt>.
		</p>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'geographical_area'); ?>
		<?php
			$this->widget('application.extensions.multicomplete.MultiComplete', array(
					'splitter'=>',',
					'source'=>CHtml::listData(Employees::model()->findAll(array('group' => 'geographical_area')), 'geographical_area', 'geographical_area'),
					'options'=>array(
						'minLength'=>'2',
					),
					'htmlOptions'=>array(
						'size'=>'60',
			            'name' => 'Search[geographical_area]',
			          	'id' => 'Search_geographical_area',
						'class' => 'search_form',
					),
			  ));
		?>
		<p class="hint">
			Hint: geographical area</tt>.
		</p>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('Countries AND/OR US States:', 'country_state'); ?>
		<?php
			$this->widget('application.extensions.multicomplete.MultiComplete', array(
					'splitter'=>',',
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
			  ));
		?>
		<p class="hint">
			Hint: Countries AND/OR US States</tt>.
		</p>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('ANY of this words:', 'any_word'); ?>
		<?php echo CHtml::textField('any_word', 'enter text...', array(
				'size'=>50,
				'maxlength'=>256,
				'class' => 'search_form',
				)); ?>
		<p class="hint">
			Hint: ANY of this words</tt>.
		</p>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('ALL of this words:', 'all_word'); ?>
		<?php echo CHtml::textField('all_word', 'enter text...', array(
				'size'=>50,
				'maxlength'=>256,
				'class' => 'search_form',
				)); ?>
		<p class="hint">
			Hint: ALL of this words</tt>.
		</p>
	</div>
	
	<div class="row">
		<?php echo Chtml::label('NONE of this words:', 'none_word'); ?>
		<?php echo CHtml::textField('none_word', 'enter text...', array(
				'size'=>50,
				'maxlength'=>256,
				'class' => 'search_form',
				)); ?>
		<p class="hint">
			Hint: NONE of this words</tt>.
		</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->