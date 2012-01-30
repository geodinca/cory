<!-- PROFILE: START -->
<div class="profile-view">
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
			<?php echo $this->widget('application.widgets.GetUserNotes', array("iEmployeeId" => $model->id, "iUserId" => Yii::app()->user->id), true); ?>
		</div>
	</div>
</div>