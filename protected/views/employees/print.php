<!-- PROFILE: START -->
<div class="profile-view">
	<div id="printable">

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

			<h3>Notes</h3>
			<div class="profile-notes-scroll" id="notes-area" style="height: 80px;">
				<?php echo nl2br($this->widget('application.widgets.GetUserNotes', array("iEmployeeId" => $model->id, "iUserId" => Yii::app()->user->id), true)); ?>
			</div>

	</div>
</div>
<!-- PROFILE: END -->

<script type="text/javascript">
//<!--
$(document).ready(function(){
	$('#top-menu').remove();
	$('#header').remove();
	$('.tabmenu').remove();
	window.print();
});
//-->
</script>

