<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Manage',
);

// $this->menu=array(
// 	array('label'=>'List Employees', 'url'=>array('index')),
// 	array('label'=>'Create Employees', 'url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('employees-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id=search-screen">
<?php
// tab menu
$this->renderPartial('_menu',array('action'=>'search_screen'));
?>
<?php if (!$iActiveInstance) :?>
<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('/employees/admin'),
	'method'=>'post',
)); ?>
<?php
	$oUser = Users::model()->findAllByPk(Yii::app()->user->id);
	$iClientId = $oUser[0]->client_id;
?>
	<div class="row">
		<?php echo Chtml::label('Select instance:', 'Search_instances_id'); ?>
		<?php echo CHtml::dropDownList('Search[instances_id]',
				isset($aPostedData['Search']['instances_id']) ? $aPostedData['Search']['instances_id'] : '',
				CHtml::listData(Instances::model()->findAll('client_id = :cID', array(':cID' => $iClientId)), 'id', 'name'),
				array('class' => 'search_form')
			);
		?>
		<?php echo CHtml::submitButton('Go to search'); ?>
		<p class="hint">Hint: Select the profile collection you intend to search in.</p>

	</div>

<?php $this->endWidget(); ?>
</div>
<?php endif;?>

<?php
// search form displayed after a instance is seleted
if ($iActiveInstance) {
	$this->renderPartial('_search',array(
		'model'=>$model,
		'aPostedData' => $aPostedData,
		'iActiveInstance' => $iActiveInstance,
		'aHints' => $aHints,
	));
}
?>
</div>

