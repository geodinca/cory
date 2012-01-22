<div class="wide form" id="serch-screen-form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('/employees/list'),
	'method'=>'post',
)); ?>
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
			$aCompanies = CHtml::ListData(Companies::model()->findAll(), 'name', 'name');
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
					'source'=>$aCompanies,
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
					'source'=>$aCompanies,
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
			<?php echo $aHints['country_state']?>.
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
		location.reload();
	});
}

$(function(){
	// hightlight autocomplete search
	$.ui.autocomplete.prototype._renderItem = function( ul, item){
		var term = this.term.split(" ").join("|");
		var re = new RegExp("(" + term + ")", "gi") ;
		var t = item.label.replace(re,"<b>$1</b>");
		return $( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( "<a>" + t + "</a>" )
			.appendTo( ul );
	};

	String.prototype.score=function(m,s){
		if(this==m){
			return 1
		}
		if(m==""){
			return 0
		}
		var f=0,q=m.length,g=this,p=g.length,o,k,e=1,j;
		for(var d=0,r,n,h,a,b,l;d<q;++d){
			h=m.charAt(d);
			a=g.indexOf(h.toLowerCase());
			b=g.indexOf(h.toUpperCase());
			l=Math.min(a,b);n=(l>-1)?l:Math.max(a,b);
			if(n===-1){
				if(s){
					e+=1-s;continue
				}else{
					return 0
				}
			}else{r=0.1}
			if(g[n]===h){r+=0.1}
			if(n===0){
				r+=0.6;
				if(d===0){o=1}
			}else{
				if(g.charAt(n-1)===" "){r+=0.8}
			}
			g=g.substring(n+1,p);
			f+=r
		}
		k=f/q;
		j=((k*(q/p))+k)/2;j=j/e;
		if(o&&(j+0.15<1)){j+=0.15}
		return j;
	};

	// sort by scoring
	$.ui.autocomplete.filter = function(source, term){
		var filtered_and_sorted_list =
		$.map(source, function(item){
			var curItemValue = item.value.toLowerCase();
			term = term.toLowerCase();
			var score = curItemValue.score(term);

			// relevance change this to upper value for bigger accuracy
			if(score > 0.4)
			return { label: item.value, value: score }
		}).sort(function(a, b){ return b.value - a.value });

		return filtered_and_sorted_list;
	};
});
</script>