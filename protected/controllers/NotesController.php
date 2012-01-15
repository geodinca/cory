<?php
/**
 * User notes on employee profile management controller
 * @author georgiandinca
 *
 */
class NotesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column1', meaning
	 * using one-column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';

	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRuless()
	{
		// return external action classes, e.g.:
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('saveNotes','loadNotes'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('saveNotes','loadNotes'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * action for saving a note
	 * related with current user and for a given employee
	 */
	public function actionSaveNotes()
	{
		if(isset($_POST['note']) && isset($_POST['id'])) {
			$employee_id = $_POST['id'];
			$model = $this->loadModel($employee_id, Yii::app()->user->id);
			$model->note = $_POST['note'];
			//var_dump($model);die;
			$model->save();
			echo nl2br($model->note);
		}
	}

	/**
	 * action for loading a note
	 * related with current user and for a given employee
	 */
	public function actionLoadNotes()
	{
		if(isset($_POST['id'])) {
			$employee_id = $_POST['id'];
			$model = $this->loadModel($employee_id, Yii::app()->user->id);
			echo $model->note;
			Yii::app()->end();
		}
		echo 'no data';
	}

	/**
	 * Returns the data model based on the primary key given in the GET/POST
	 * variable. If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($employee_id,$user_id)
	{
		$model = Notes::model()->findByAttributes(array(
				'employee_id' => $employee_id,
				'user_id'     => $user_id,
		));

		if($model===null) {
			$model              = new Notes();
			//create a empty line if no one exists
			$model->user_id     = $user_id;
			$model->employee_id = $employee_id;
			$model->note        = '';
			$model->save();
		}
		return $model;
	}

}