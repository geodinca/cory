<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('demo_title')); ?>:</b>
	<?php echo CHtml::encode($data->demo_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('application_title')); ?>:</b>
	<?php echo CHtml::encode($data->application_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expiration')); ?>:</b>
	<?php echo CHtml::encode($data->expiration); ?>
	<br />


</div>