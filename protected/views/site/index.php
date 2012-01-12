
<?php if(Yii::app()->user->isGuest) {
	// search form 
	$this->renderPartial('login',array('model'=>$model));
} else {
	$this->redirect(Yii::app()->request->baseUrl.'/employees/admin');
} 
?>


