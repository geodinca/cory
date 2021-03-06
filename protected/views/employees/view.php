<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/pdf.js',CClientScript::POS_HEAD);

//load jScrollPane JS
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery.jscrollpane.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/mwheelIntent.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.mousewheel.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.jscrollpane.min.js');
//load jEditable JS
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.jeditable.mini.js');
//load tooltip js
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tools.min.js');
// search form
$this->renderPartial('_menu',array('action'=>'selected_profile'));
?>
<!-- PROFILE: START -->
<div class="profile-view">
	<div class="profile-actions">
	<?php $aToolbar = unserialize(Yii::app()->session->get('toolbar'));?>
		<span style="float: left"><?php echo ($aToolbar['currentIndex']+1).'/'.($aToolbar['total_count']) ?></span>
		<span style="float: right"> &laquo;
			<?php
			if ($aToolbar['currentIndex'] > 0) {
				echo CHtml::link(
					'Previous',
					'/employees/prev/'.($aToolbar['employees'][$aToolbar['currentIndex']-1]['id']),
					array('title' => $aToolbar['employees'][$aToolbar['currentIndex']-1]['name'])
				);
			}
			else echo 'Previous';
			?>
			|
			<?php
			if ($aToolbar['currentIndex'] < ($aToolbar['total_count']-1)) {
				echo CHtml::link(
					'Next',
					'/employees/next/'.($aToolbar['employees'][$aToolbar['currentIndex']+1]['id']),
					array('title' => $aToolbar['employees'][$aToolbar['currentIndex']+1]['name'])
				);
			}
			else echo 'Next';
			?>
		&raquo;</span>
		<span style="float: right">
			<?php echo CHtml::button('Save PDF', array(
				'onclick' => 'openPdf("'.Yii::app()->createUrl('/employees/showPdf', array('id' => $model->id)).'","'.$model->id.'");'
			)); ?>
		</span>
		<span style="float: right">
			<?php
				echo CHtml::button('Print', array(
					'id' => 'printBtn',
				));
			?>
		</span>
		<span style="float: right">
			<?php //read ckeck state
				if ($isMarked !== false ) $isMarked = true;
			?>
			<?php echo CHtml::checkBox('mark_profile',$isMarked,array()).' Mark profile'?>
		</span>
	</div>
	<div class="clear"></div>

		<div id="profile-area" class="profile-data" style="height: 340px; ">
			<?php
				$aSession = unserialize(Yii::app()->session->get('search_criteria'));
				$aTextReplace = Yii::app()->format->explode($aSession['data']['Search']);
			?>
			<?php if (!empty($model->name)): ?>
			<h3>Name</h3>
			<span><?php echo Yii::app()->format->search($model->name,$aTextReplace); ?></span>
			<?php endif; ?>

			<?php if (!empty($model->geographical_area)): ?>
			<h3>Geographical Area</h3>
			<span><?php echo Yii::app()->format->html(nl2br(Yii::app()->format->search($model->geographical_area,$aTextReplace))); ?></span>
			<?php endif; ?>

			<?php if (!empty($model->title)): ?>
			<h3>Curent title</h3>
			<span><?php echo Yii::app()->format->search($model->title,$aTextReplace); ?></span>
			<?php endif; ?>

			<?php if (!empty($model->present_employer->name)): ?>
			<h3>Present Employer</h3>
			<?php $this->renderPartial('../companies/tooltip',array(
				'model' => $model->present_employer,
				'aTextReplace' => $aTextReplace,
			));?>
			<?php endif; ?>

			<?php if (!empty($model->contact_info)): ?>
			<h3>Company info</h3>
			<span><?php echo nl2br(Yii::app()->format->search($model->contact_info,$aTextReplace)); ?></span>
			<?php endif; ?>

			<?php if (!empty($model->profile)): ?>
			<h3>Profile/Biography/Past employers</h3>
			<span><?php echo nl2br(Yii::app()->format->search($model->profile,$aTextReplace)); ?></span>
			<?php endif; ?>
		</div>
		<div class="profile-notes" >
			<h3>Notes</h3>
			<div class="profile-notes-scroll" id="notes-area" style="height: 80px;">
				<div class="edit_area" id="<?php echo $model->id ?>">
					<?php echo nl2br($this->widget('application.widgets.GetUserNotes', array("iEmployeeId" => $model->id, "iUserId" => Yii::app()->user->id), true)); ?>
				</div>
			</div>
		</div>

</div>

<div id="pdf_content" class="ui-widget">
	<iframe id="pdf_frame" src="" width="800" height="600"></iframe>
</div>

<!-- PROFILE: END -->
<script type="text/javascript">
//<!--
$(function(){
	$('input[id^="mark_profile"]').live('click', function(){
		var action = '';
		if($(this).is(':checked')){
			action = 'add';
		} else {
			action = 'remove';
		}

		$.post(
			"<?php echo Yii::app()->createUrl('/employees/selection'); ?>",
			{id: <?php echo $aToolbar['currentIndex']+1 ?>, action: action}
		);
	});
});

$(document).ready(function(){
	active_area = $(window).height() -160;
	profile_area = parseInt(2*(active_area/3));
	notes_area = active_area - profile_area;
	$('#profile-area').height(profile_area);
	$('.profile-notes').height(notes_area);

	$('.profile-data').jScrollPane({
			showArrows : true
	});
	//$('.profile-notes-scroll').jScrollPane();

	$('.edit_area').editable("<?php echo Yii::app()->createUrl('/notes/saveNotes'); ?>", {
		type        : 'textarea',
		name	    : 'note',
		placeholder : 'Dubleclick to edit',
		loadurl     : "<?php echo Yii::app()->createUrl('/notes/loadNotes'); ?>",
		loadtype    : 'POST',
		loaddata    : {id: "<?php echo $model->id ?>"},
		//rows	    : 5,
		//cols	    : 122,
		width       : 870,
		height      : notes_area - 100,
		onblur      : 'ignore',
		event	    : 'dblclick',
		tooltip     : 'Dubleclick to edit...',
		cancel      : 'Cancel',
		submit      : 'OK',
		select      : true
	});

	// initialize tooltip
	$(".ttip").live("mouseover", function(){
		$(this).tooltip({
			// tweak the position
			offset: [1, 1],
			// use the "slide" effect
			effect: 'slide'
		// add dynamic plugin with optional configuration for bottom edge
		}).dynamic({
			bottom: {
				direction: 'down',
				bounce: true
			}
		});
	});

	$('#printBtn').bind('click',function() {
		var url = '<?php echo Yii::app()->createUrl('/employees/print', array('id' => $model->id)) ?>';
		var thePopup = window.open( url, "Profile Print Window", "menubar=0,location=0,height=700,width=700,scrollbars=1" );
		//$('#popup-content').clone().appendTo( thePopup.document.body );
	});
});
//-->
</script>