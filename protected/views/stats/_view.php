<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('login_date')); ?>:</b>
	<?php echo CHtml::encode($data->login_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('search')); ?>:</b>
	<?php echo CHtml::encode($data->search); ?>
	<br />


</div>