<?php
//load tooltip js
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tools.min.js');
?>

<div class="wide form" id="serch-screen-form">

<?php
	$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('/employees/list'),
	'method'=>'post',
	));
?>

	<div class="row buttons-top">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::button('Reset', array('onclick' => 'resetSearch();'));?>
	</div>

	<?php
		echo CHtml::hiddenField(
			'Search[instances_id]',
			isset($iActiveInstance) ? $iActiveInstance : ''
		);
	?>
	<div class="row">
		<?php echo Chtml::label('Boolean Search:', 'boolean_search'); ?>
		<?php echo CHtml::textField('Search[boolean_search]',
				isset($aPostedData['Search']['boolean_search']) ? $aPostedData['Search']['boolean_search'] : '',
				array(
					'size'=>50,
					'maxlength'=>256,
					'class' => 'search_form',
				)); ?>
		<p class="hint">
			<?php echo $aHints['boolean_search']?>.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('Present Employer:', 'present_employer'); ?>
		<?php
			echo CHtml::textField('Search[present_employer]',
				isset($aPostedData['Search']['present_employer']) ? $aPostedData['Search']['present_employer'] : '',
				array(
					'size'=>50,
					'maxlength'=>256,
					'class' => 'search_form',
					'id'    => 'search-present-employer'
				)
			);
			echo '&nbsp;';
			$this->widget('application.extensions.multicomplete.MultiCompleteCompany', array(
					'updater' => 'search-present-employer',
					'splitter'=>'::',
					'sourceUrl'=> Yii::app()->createUrl('/companies/getCompany'),
					'options'=>array(
						'minLength'=>'2',
					),
					'htmlOptions'=>array(
						'size'=>'60',
						'name' => 'present_employer',
						'id' => 'search-present-employer-auto',
						'onclick' => '$(this).val("");'
					),
					'value' => 'Search company here...',
			));
		?>
		<p class="hint">
			<?php echo $aHints['present_employer']?>.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('Present or Past Employer:', 'present_or_past_employer'); ?>
		<?php
			echo CHtml::textField('Search[present_or_past_employer]',
				isset($aPostedData['Search']['present_or_past_employer']) ? $aPostedData['Search']['present_or_past_employer'] : '',
				array(
					'size'=>50,
					'maxlength'=>256,
					'class' => 'search_form',
					'id'    => 'search-past-employer'
				)
			);
			echo '&nbsp;';
			$this->widget('application.extensions.multicomplete.MultiCompleteCompany', array(
					'updater' => 'search-past-employer',
					'splitter'=>'::',
					'sourceUrl'=> Yii::app()->createUrl('/companies/getCompany'),
					'options'=>array(
						'minLength'=>'2',
					),
					'htmlOptions'=>array(
						'size'=>'60',
						'name' => 'present_or_past_employer',
						'id' => 'search-past-employer-auto',
						'onclick' => '$(this).val("");'
					),
					'value' => 'Search company here...'
			));
		?>
		<p class="hint">
			<?php echo $aHints['present_or_past_employer']?>.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('Area code:', 'contact_info'); ?>
		<?php echo CHtml::textField('Search[contact_info]',
				isset($aPostedData['Search']['contact_info']) ? $aPostedData['Search']['contact_info'] : ''
			); ?>
		<p class="hint">
			<?php echo $aHints['contact_info']?>.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('Countries AND/OR US States:', 'country_state'); ?>
		<?php
			$this->widget('application.extensions.multicomplete.MultiComplete', array(
					'splitter'=>'::',
					'sourceUrl'=>Yii::app()->createUrl('/employees/getCountryState'),
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
			<?php echo $aHints['country_state']?>.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('EXACT wording or phrase:', 'exact_word'); ?>
		<?php echo CHtml::textField('Search[exact_word]', isset($aPostedData['Search']['exact_word']) ? $aPostedData['Search']['exact_word'] : '', array(
				'size'=>50,
				'maxlength'=>256,
				'class' => 'search_form',
				));
		?>
		<p class="hint">
			<?php echo $aHints['exact_word']?>.
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
		<p class="hint">
			<?php echo $aHints['any_word']?>.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('ALL of this words:', 'all_word'); ?>
		<?php echo CHtml::textField('Search[all_word]', isset($aPostedData['Search']['any_word']) ? $aPostedData['Search']['all_word'] : '', array(
				'size'=>50,
				'maxlength'=>256,
				'class' => 'search_form',
				)); ?>
		<p class="hint">
			<?php echo $aHints['all_word']?>.
		</p>
	</div>

	<div class="row">
		<?php echo Chtml::label('NONE of this words:', 'none_word'); ?>
		<?php echo CHtml::textField('Search[none_word]', isset($aPostedData['Search']['any_word']) ? $aPostedData['Search']['none_word'] : '', array(
				'size'=>50,
				'maxlength'=>256,
				'class' => 'search_form',
				)); ?>
		<p class="hint">
			<?php echo $aHints['none_word']?>.
		</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::button('Reset', array('onclick' => 'resetSearch();'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->

<script type="text/javascript">
function resetSearch(){
	$.post("<?php echo Yii::app()->createUrl('/employees/reset'); ?>", null, function(data){
		$('input:text').each(function(index) {
			$(this).val('');
		});
	});
}

$(function(){

	// hightlight autocomplete search
	$.ui.autocomplete.prototype._renderItem = function( ul, item){
		var term = this.term.split(" ").join("|");
		var re = new RegExp("(" + term + ")", "gi") ;
		var t = item.label.replace(re,"<span class=\"ui-state-highlight\">$1</span>");
		return $( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( '<a class=\"ttip\" title="' + item.title + '">' + t + '</a>' )
			.appendTo( ul );
	};
});

$(document).ready(function(){
	$(".ttip").live("mouseover", function(){
		$(this).tooltip({
			position:"center left",
			// tweak the position
			offset: [10, -1],
			// use the "slide" effect
			//effect: 'slide'
		// add dynamic plugin with optional configuration for bottom edge
		})
	});
});
</script>