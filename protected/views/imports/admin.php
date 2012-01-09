<h1><?php echo Yii::t('app','Import user from excel'); ?></h1>

<div class="form">
<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'import-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data')
));
?>

	<p class="note"><?php echo Yii::t('app','Fields with <span class="required">*</span> are required.'); ?></p>

	<!-- Import fields -->
	<div class="row even">
		<?php echo CHtml::activeLabelEx($model, 'importdata'); ?>
		<?php echo CHtml::activeFileField($model, 'importdata'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Import')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->