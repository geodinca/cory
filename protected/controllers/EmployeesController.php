<?php
/**
 * Search employees controller
 * @author cmarin
 */
class EmployeesController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','list','view','saveNotes','loadNotes','getTooltip'),
				'users'=>array('@'),
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
		$model=new Employees;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Employees']))
		{
			$model->attributes=$_POST['Employees'];
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

		if(isset($_POST['Employees']))
		{
			$model->attributes=$_POST['Employees'];
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
		$dataProvider=new CActiveDataProvider('Employees');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Search form for employees
	 */
	public function actionAdmin()
	{
		$model=new Employees('search');
		$model->unsetAttributes();  // clear any default values
		
		$aPostedData = array();
		$aSession = unserialize(Yii::app()->session->get('search_criteria'));
		
		if(!empty($aSession['data'])){
			$aPostedData = $aSession['data'];
		}
		
		$this->render('admin',array(
			'model'=>$model,
			'aPostedData' => $aPostedData
		));
	}

	/**
	 * Lists search results in separate screen.
	 */
	public function actionList()
	{
		$model=new Employees('search');
		$model->unsetAttributes();  // clear any default values
		
		// get allowed instances
		$aInstances = CHtml::listData(Instances::model()->findAll('client_id = :clId', array(':clId' => Yii::app()->user->credentials['client_id'])), 'id', 'id');

		if(Yii::app()->request->isAjaxRequest){
			$aSession = unserialize(Yii::app()->session->get('search_criteria'));

			if($aSession){
				$dataProvider = new CActiveDataProvider($model, array(
					'criteria'=>$aSession['criteria'],
				));
			} else {
				$model->instances_id = $aInstances;
				$dataProvider = $model->search();
			}
		}

		if(isset($_GET['Employees'])){
			$aSession = unserialize(Yii::app()->session->get('search_criteria'));

			if($aSession){
				$oCriteria = $aSession['criteria'];

				$oCriteria1 = new CDbCriteria;
				$model->attributes=$_GET['Employees'];
				foreach($model->attributes as $sAttribute => $sValue){
					if($sValue){
						$oCriteria1->addCondition($sAttribute.' LIKE :v_'.$sAttribute);
						if(stristr($sAttribute, 'id')){
							$oCriteria1->params[':v_'.$sAttribute] = $sValue;
						} else {
							$oCriteria1->params[':v_'.$sAttribute] = '%'.$sValue.'%';
						}
					}
				}
				$oCriteria->mergeWith($oCriteria1);
//				echo '<pre>'.print_r($oCriteria, true).'</pre>'; die();

				$dataProvider = new CActiveDataProvider($model, array(
					'criteria'=>$oCriteria,
				));
			} else {
				$model->attributes=$_GET['Employees'];
				$model->instances_id = $aInstances;
				$dataProvider = $model->search();
			}
		}

		if(isset($_POST['Search'])){
			$oCriteria = new CDbCriteria;
			$aSearchFields = array('geographical_area', 'contact_info', 'profile', 'name', 'title');
			$aPostedData = $_POST;
			
			if($_POST['Search']['boolean_search']){
				// prepare condition string
				$sConditionalString = str_replace(array("'", 'OR ', 'AND ', 'ANDNOT ', 'NOT '), array('"', '', '+', '-', '-'), trim($_POST['Search']['boolean_search']));
				if(substr($sConditionalString, 0, 1) != '-'){
					$sConditionalString = "'+".$sConditionalString."'";
				} else {
					$sConditionalString = "'".$sConditionalString."'";
				}
				$oCriteria->condition = 'MATCH ('.implode(',', $aSearchFields).') AGAINST ('.$sConditionalString.' IN BOOLEAN MODE)';
			} else {

				if($_POST['Search']['present_employer']){
					$oCriteria->addInCondition('t.companies_id', explode(',', $_POST['Search']['present_employer']));
				}
				if($_POST['Search']['present_or_past_employer']){
					$oCriteria->addInCondition('t.profile', explode(':: ', substr(trim($_POST['Search']['present_or_past_employer']), 0, -2)));
				}
				if($_POST['Search']['contact_info']){
					$oCriteria->addInCondition('t.contact_info', explode(',', trim($_POST['Search']['contact_info'])), 'AND');
				}
				if($_POST['Search']['country_state']){
					$oCriteria->addInCondition('t.geographical_area', explode(':: ', substr(trim($_POST['Search']['country_state']), 0, -2)), 'AND');
				}
	
				if($_POST['Search']['any_word']){
					$oCriteria1 = new CDbCriteria;
					$aWordsToBeSearched = explode(' ', trim($_POST['Search']['any_word']));
					foreach($aWordsToBeSearched as $sWord){
						$oCriteria1->addSearchCondition('t.geographical_area', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.contact_info', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.profile', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.name', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.title', $sWord, true, 'OR');
					}
					$oCriteria->mergeWith($oCriteria1);
				}
	
				if($_POST['Search']['all_word']){
					$oCriteria1 = new CDbCriteria;
					$aWordsToBeSearched = explode(' ', trim($_POST['Search']['all_word']));
					foreach($aWordsToBeSearched as $sWord){
						$oCriteria1->addSearchCondition('t.geographical_area', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.contact_info', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.profile', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.name', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.title', $sWord, true, 'OR');
					}
					$oCriteria->mergeWith($oCriteria1);
				}
	
				if($_POST['Search']['none_word']){
					$oCriteria1 = new CDbCriteria;
					$aWordsToBeSearched = explode(' ', trim($_POST['Search']['any_word']));
					foreach($aWordsToBeSearched as $sWord){
						$oCriteria1->addSearchCondition('t.geographical_area', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.contact_info', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.profile', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.name', $sWord, true, 'OR');
						$oCriteria1->addSearchCondition('t.title', $sWord, true, 'OR');
					}
					$oCriteria->mergeWith($oCriteria1);
				}
			}
			
			// instance
			$oCriteria->addInCondition('t.instances_id', $aInstances);
			
			Yii::app()->session->add('search_criteria', serialize(array('criteria' => $oCriteria, 'data' => $aPostedData)));

// 			echo '<pre>'.print_r($oCriteria, true).'</pre>';die;
//			echo '<pre>'.print_r($_POST, true).'</pre>'; die();

			$dataProvider = new CActiveDataProvider($model, array(
				'criteria'=>$oCriteria,
			));
		}

		if(empty($dataProvider)){
			$aSession = unserialize(Yii::app()->session->get('search_criteria'));
			if(!empty($aSession)){
				$dataProvider = new CActiveDataProvider($model, array(
					'criteria' => $aSession['criteria'],
				));
			} else {
				$model->instances_id = $aInstances;
		    	$dataProvider = $model->search();
			}
		}
		
		$this->render('list',array(
			'model'=>$model,
			'dataProvider' => $dataProvider,
		));
	}

	public function actionSaveNotes()
	{
		if(isset($_POST['misc_info']) && isset($_POST['id'])) {
			$model = $this->loadModel($_POST['id']);
			$model->misc_info = $_POST['misc_info'];
			$model->save();
			echo nl2br($model->misc_info);
		}
	}

	public function actionLoadNotes()
	{
		if(isset($_POST['id'])) {
			$model = $this->loadModel($_POST['id']);
			echo $model->misc_info;
			exit;
		}
		echo 'no data';
	}

	public function getTooltip($data,$row)
	{
		$model = Companies::model()->findByPk($data->companies_id);
		return $this->renderPartial('../companies/tooltip', array('model'=>$model),true);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Employees::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employees-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
