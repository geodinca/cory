
<?php if(Yii::app()->user->isGuest) {
	// login form
	$this->renderPartial('login',array('model'=>$model));
} else {
	// search form
	//$this->redirect(Yii::app()->getBaseUrl().'/employees/admin');
//}
?>

<?php
	$oUser = Users::model()->findAllByPk(Yii::app()->user->id);
	$iClientId = $oUser[0]->client_id;
?>
<div id="static-page">
	<h2>Select one of the following collections:</h2>
	<?php $aInstances = Instances::model()->findAll('client_id = :cID', array(':cID' => $iClientId));?>
	<ol id="db-list">
	<?php foreach($aInstances as $oInstance):?>
		<li>
			<?php //var_dump($oInstance)?>
			<span class="ui-icon ui-icon-folder-open"></span>
			<?php echo CHtml::link(" {$oInstance->name}",'/site/index/'.$oInstance->id)?>
		</li>
	<?php endforeach?>
	</ol>
</div>
<?php }?>

