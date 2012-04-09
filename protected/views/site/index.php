
<?php if(Yii::app()->user->isGuest) {
	// login form
	$this->renderPartial('login',array('model'=>$model));
} else {
	// search form
	//$this->redirect(Yii::app()->getBaseUrl().'/employees/admin');
//}
?>

<div id="static-page">
	<h2>Select one of the following collections:</h2>
	<?php
		if(Yii::app()->user->credentials['type'] == 'admin'){
			$aInstances = Instances::model()->findAll();
		} else {
			$aInstances = InstancesUsers::model()->findAll('user_id = :uID', array(':uID' => Yii::app()->user->id));
			$accessInstances = array();
			foreach ($aInstances as $oInstance) {
				$accessInstances[] = Instances::model()->find('id = :id', array(':id' => $oInstance->instance_id));
			}
		}

	?>
	<ol id="db-list">
		<?php foreach($accessInstances as $oInstance):?>
			<li>
				<span class="ui-icon ui-icon-folder-open"></span>
				<?php echo CHtml::link(" {$oInstance->name}", array('index', 'id' => $oInstance->id)); ?>
			</li>
		<?php endforeach?>
	</ol>
</div>
<?php }?>

