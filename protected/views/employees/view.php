<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/pdf.js',CClientScript::POS_HEAD);

//load jScrollPane JS
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/jquery.jscrollpane.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/mwheelIntent.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.mousewheel.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.jscrollpane.min.js');
//load jEditable JS
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.jeditable.mini.js');
// search form
$this->renderPartial('_menu',array('action'=>'selected_profile'));
?>
<!-- PROFILE: START -->
<div class="profile-view">
	<div class="profile-actions">
		<span style="float: left">1/21</span>
		<span style="float: right"> &laquo; Previous | Next &raquo;</span>
		<span style="float: right">
			<?php echo CHtml::button('Save PDF', array('onclick' => 'openPdf("'.Yii::app()->createUrl('/employees/showPdf', array('id' => $model->id)).'","'.$model->id.'");')); ?>
		</span>
		<span style="float: right"><?php echo CHtml::button('Print'); ?></span>
		<span style="float: right"><?php echo CHtml::checkBox('Mark profile',false,array()).' Mark profile'?></span>
	</div>
	<div class="clear"></div>
	<div id="profile-<?php echo $model->id?>" class="profile-data"  style="height: 340px; ">
		<h3>Name</h3>
		<span><?php echo $model->name; ?></span>

		<h3>Geographical Area</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->geographical_area)); ?></span>

		<h3>Curent title</h3>
		<span><?php echo $model->title; ?></span>

		<h3>Present Employer</h3>
		<span><?php echo $model->present_employer->name; ?></span>

		<h3>Company info</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->contact_info)); ?></span>

		<h3>Profile/Biography/Past employers</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->profile)); ?></span>
	</div>
	<div class="profile-notes" >
		<h3>Notes</h3>
		<div class="edit_area" id="<?php echo $model->id ?>">
			<?php echo $this->widget('application.widgets.getUserNotes', array("iEmployeeId" => $model->id, "iUserId" => Yii::app()->user->id), true); ?>
		</div>
	</div>
</div>

<div id="pdf_content" class="ui-widget">
	<iframe id="pdf_frame" src="" width="800" height="600"></iframe>
</div>

<!-- PROFILE: END -->
<script type="text/javascript">
//<!--
$(document).ready(function(){
	$('.profile-data').jScrollPane();

    $('.edit_area').editable("<?php echo Yii::app()->createUrl('/notes/saveNotes'); ?>", {
        type      	: 'textarea',
        name	  	: 'note',
        placeholder	: 'Dubleclick to edit',
        loadurl  	: "<?php echo Yii::app()->createUrl('/notes/loadNotes'); ?>",
        loadtype   	: 'POST',
        loaddata 	: {id: "<?php echo $model->id ?>"},
        rows	  	: 5,
        cols	  	: 117,
        onblur    	: 'submit',
        event	  	: 'dblclick',
        tooltip   	: 'Dubleclick to edit...'
    });
});
//-->
</script>