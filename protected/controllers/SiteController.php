<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$model=new LoginForm;
		$aPostedData = array();
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input
			if($model->validate() && $model->login()) {
				//Log in stats model the login of the user
				$stats = array(
					'user_id' => Yii::app()->user->id, 
					'login_date' => date( 'Y-m-d H:i:s', time() ),
					'search' => 'Login'
				);
				$model=new Stats;
				$model->attributes=$stats;
				$model->save();
			}
		}

		if (!Yii::app()->user->isGuest) {
			$aSession = unserialize(Yii::app()->session->get('search_criteria'));
			$aSessionUser = array();
			$aPostedData = $aSession['data'];
			
			//reset an possible previuous Search
			Yii::app()->session->remove('search_criteria');
			
			if(isset($_GET['id'])) {
				//add instance to session
				$aSessionUser['current_instance_id'] = $aSession['current_instance_id'] = $_GET['id'];
				$aSession['data']['Search']['instances_id'] = $_GET['id'];
				$i = Instances::model()->findByPk($aSession['current_instance_id']);
				$aSessionUser['current_appTitle'] = $i->name;
				Yii::app()->session->add('search_criteria', serialize($aSession));
				Yii::app()->session->add('app_setts', serialize($aSessionUser));
				$this->redirect(array('/employees/admin'));
			}
		}

		// display the login form
		$this->render('index',array('model'=>$model, 'aPostedData'=>$aPostedData));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				$this->redirect(Yii::app()->getBaseUrl().'/employees/admin');
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}