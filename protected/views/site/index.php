
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
			$aInstances = Instances::model()->findAll('client_id = :cID', array(':cID' => Yii::app()->user->credentials['client_id']));
		}
	?>
	<ol id="db-list">
		<?php foreach($aInstances as $oInstance):?>
			<li>
				<?php //var_dump($oInstance)?>
				<span class="ui-icon ui-icon-folder-open"></span>
				<?php echo CHtml::link(" {$oInstance->name}", array('index', 'id' => $oInstance->id)); ?>
			</li>
		<?php endforeach?>
	</ol>
</div>
<?php }?>

