<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'client_id'); ?>
		<?php
			if(isset($model->id)){
				echo isset($model->client->name) ? $model->client->name : 'admin';
			} else {
				echo $form->dropDownList($model, 
					'client_id', 
					CHtml::listData(Clients::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
					array(
						'ajax' => array(
							'type' => 'POST', 
							'url' => Yii::app()->createUrl('/users/getInstanceByClient'),
							'update' => '#user_instances',
						)
					)
				);
			} 
		?>
		<?php echo $form->error($model,'client_id'); ?>
	</div>
	
	<div id="instances" class="row">
		<?php echo CHtml::label('Instance(s)', 'instances'); ?>
		<?php echo Chtml::dropDownList('Users[instances][]', CHtml::listData(InstancesUsers::model()->findAll(array('condition' => 'user_id = :uID', 'params' => array(':uID' => $model->id))), 'instance_id', 'instance_id'), CHtml::listData(Instances::model()->findAll(array('condition' => 'client_id = :clID', 'params' => array(':clID' => $model->client_id), 'order' => 'name ASC')), 'id', 'name'), array('id' => 'user_instances', 'multiple' => 'true', 'size' => 3)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', Yii::app()->format->enumToArray($model->getTableSchema()->columns['status']->dbType)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type', Yii::app()->format->enumToArray($model->getTableSchema()->columns['type']->dbType)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expire'); ?>
		<?php echo $form->textField($model,'expire',array('class' => 'datepicker')); ?>
		<?php echo $form->error($model,'expire'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->