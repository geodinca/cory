<?php
$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->name,
);
//tab menu
$this->renderPartial('../employees/_menu',array('action'=>'companies_data'));
?>

<div class="profile-actions">
	<span style="float: left"> &laquo; <?php echo CHtml::link('Back','/companies/admin') ?></span>
</div>
<!-- PROFILE: START -->
<div class="profile-view">
	<h1>View Company: <?php echo $model->name; ?></h1>

	<div id="profile-<?php echo $model->id?>" class="profile-data">
		<?php if (!empty($model->employee[0]->contact_info)):?>
		<h3>Company info</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->employee[0]->contact_info)); ?></span>
		<?php endif;?>

		<?php if (!empty($model->street)):?>
		<h3>Street</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->street)); ?></span>
		<?php endif;?>

		<?php if (!empty($model->city)):?>
		<h3>City</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->city)); ?></span>
		<?php endif;?>

		<?php if (!empty($model->country)):?>
		<h3>Country</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->country)); ?></span>
		<?php endif;?>

		<?php if (!empty($model->state)):?>
		<h3>State</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->state)); ?></span>
		<?php endif;?>

		<?php if (!empty($model->zip)):?>
		<h3>zip</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->zip)); ?></span>
		<?php endif;?>

		<?php if (!empty($model->phone)):?>
		<h3>Phone</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->phone)); ?></span>
		<?php endif;?>

		<?php if (!empty($model->web)):?>
		<h3>Web</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->web)); ?></span>
		<?php endif;?>

		<?php if (!empty($model->products)):?>
		<h3>Company products</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->products)); ?></span>
		<?php endif;?>

		<?php if (!empty($model->sales)):?>
		<h3>Sales</h3>
		<span><?php echo Yii::app()->format->html(nl2br($model->sales)); ?></span>
		<?php endif;?>
	</div>
</div>
