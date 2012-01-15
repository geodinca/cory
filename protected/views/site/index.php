
<?php if(Yii::app()->user->isGuest) {
	// login form
	$this->renderPartial('login',array('model'=>$model));
} else {
	// search form
	$this->redirect(Yii::app()->getBaseUrl().'/employees/admin');
}
?>


