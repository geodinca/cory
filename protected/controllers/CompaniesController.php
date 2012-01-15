<?php

class CompaniesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform actions
				'actions'=>array('create','update','getTooltip', 'doChecked'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Companies;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Companies']))
		{
			$model->attributes=$_POST['Companies'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Companies']))
		{
			$model->attributes=$_POST['Companies'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Companies');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Companies('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Companies']))
			$model->attributes=$_GET['Companies'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function getTooltip($data,$row)
	{
		$model = Companies::model()->findByPk($data->id);
		return $this->renderPartial('../companies/tooltip', array('model'=>$model),true);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Companies::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='companies-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDoChecked()
	{
		//@TODO: to interpret to what field to send data present/past
		$aSession = unserialize(Yii::app()->session->get('search_criteria'));
		if(!empty($aSession['data'])){
			$aPostedData = $aSession['data'];
		}
		if(isset($_POST['companies-grid_c0'])) {
			$aSearchNames = $aSearchIds = array();
			foreach($_POST['companies-grid_c0'] as $compani_id) {
				//do staff
				$company = $this->loadModel($compani_id);
				$aSearchNames[] = $company->name;
				$aSearchIds[] = $compani_id;
			}
			//@TODO: make uniq value in array of companies
			$aPostedData['Search']['present_employer'] = $aPostedData['Search']['present_employer'].','.implode(',',$aSearchIds);
			$aPostedData['present_employer'] = $aPostedData['present_employer'].'::'.implode(':: ',$aSearchNames);
			Yii::app()->session->add('search_criteria',serialize(array('criteria' => $aSession['criteria'], 'data' => $aPostedData)));
			$this->redirect(array('../employees/admin'));
		} else {
			$this->redirect(array('/'));
		}
	}
}
