<?php
/**
 * Management instances, controller
 * @author cmarin
 *
 */
class InstancesController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'searchtips'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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

		if(isset($_POST['Instances']))
		{
//			if (isset($_POST['Instances']['search_tips'])) {
//				$_POST['Instances']['search_tips'] = htmlentities($_POST['Instances']['search_tips']);
//			}
//			var_dump($_POST['Instances']);die;
			if (isset($_POST['Hint'])) {
				$aPostedData = $_POST['Hint'];
				$jsonData = CJSON::encode($aPostedData);
			}
			$_POST['Instances']['hints'] = serialize($jsonData);
			$model->attributes=$_POST['Instances'];
			if($model->save())
				$this->redirect(array('admin'));
		} else {
			$aPostedData = CJSON::decode(unserialize($model->hints));
		}

		$this->render('update',array(
			'model'=>$model,
			'aPostedData' => $aPostedData,
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
		$this->redirect(array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Instances('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Instances']))
			$model->attributes=$_GET['Instances'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionSearchtips() {
		$aCurrenSession = unserialize(Yii::app()->session->get('search_criteria'));
		$model = $this->loadModel($aCurrenSession['current_instance_id']);
		$this->render('searchtips',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Instances::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='instances-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
