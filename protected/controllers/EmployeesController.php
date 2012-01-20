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
	public $selectedEmployees = array();

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
			array('allow', // allow authenticated user to perform actions
				'actions'=>array(
					'admin',
					'list',
					'view',
					'next',
					'prev',
					'getTooltip',
					'showPdf',
					'showSelected',
					'selection'
				),
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
		$model = $this->loadModel($id);

		//calculate current position of employee in 'toolbar' session array by ID
		$aToolbar = unserialize(Yii::app()->session->get('toolbar'));
		foreach($aToolbar['employees'] as $idx => $aEmployee) {
			if ($id == $aEmployee['id']) {
				$aToolbar['currentIndex'] = $idx;
				break;
			}
		}
		Yii::app()->session->add('toolbar',serialize($aToolbar));

		$this->render('view',array(
			'model' => $model,
		));
	}

	/**
	 * Set toolbarsession data for next employee in array
	 */
	public function actionNext($id)
	{
		//rebuild toolbar session according with current id
		$aToolbar = unserialize(Yii::app()->session->get('toolbar'));
		if($aToolbar['currentIndex'] < $aToolbar['total_count']) {
			$aEmployees = $aToolbar['employees'];
			$aToolbar['currentIndex'] = $aToolbar['currentIndex']+1;
			$aToolbar['currentId'] = $id;
			Yii::app()->session->add('toolbar',serialize($aToolbar));
		}
		$this->actionView($id);
	}


	/**
	 * Set toolbarsession data for previous employee in array
	 */
	public function actionPrev($id)
	{
		//rebuild toolbar session according with current id
		$aToolbar = unserialize(Yii::app()->session->get('toolbar'));
		if($aToolbar['currentIndex'] > 0) {
			$aEmployees = $aToolbar['employees'];
			$aToolbar['currentIndex'] = $aToolbar['currentIndex']-1;
			$aToolbar['currentId'] = $id;
			Yii::app()->session->add('toolbar',serialize($aToolbar));
		}
		$this->actionView($id);
	}

	/**
	 * Add/remove employee from selection
	 */
	public function actionSelection(){
		$aSelectedEmployees = array();

		$aSession = unserialize(Yii::app()->session->get('search_criteria'));
		if(isset($aSession['employees'])){
			$aSelectedEmployees = $aSession['employees'];
		}

		// add employee
		if($_POST['action'] == 'add'){
			$aSelectedEmployees[] = $_POST['id'];
		}

		// add employee
		if($_POST['action'] == 'remove'){
			$aSelectedEmployees = array_flip($aSelectedEmployees);
			unset($aSelectedEmployees[$_POST['id']]);
			$aSelectedEmployees = array_flip($aSelectedEmployees);
		}

		$aSession['employees'] = $aSelectedEmployees;
		echo '<pre>'.print_r($aSession, true).'</pre>';
		Yii::app()->session->add('search_criteria', serialize($aSession));
		Yii::app()->end();
	}

	public function searchIndex($aEmployees, $id)
	{
		foreach ($aEmployees as $key => $oEmployee) {
			if ($id == $oEmployee->id) {
				return $key+1;
			}
		}
		return null;
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
		$iActiveInstance = '';
		$aPostedData = array();
		$aSession = unserialize(Yii::app()->session->get('search_criteria'));

		if(!empty($aSession['data'])){
			$aPostedData = $aSession['data'];
		}

		if (isset($_POST['Search']['instances_id'])) {
			$iActiveInstance = $_POST['Search']['instances_id'];
		}

		$this->render('admin',array(
			'model'=>$model,
			'aPostedData' => $aPostedData,
			'iActiveInstance' => $iActiveInstance
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

		// get stored session data
		$aSession = unserialize(Yii::app()->session->get('search_criteria'));

		// get selected employees to use in cgridview
		$this->selectedEmployees = isset($aSession['employees']) ? $aSession['employees'] : array();

		if(Yii::app()->request->isAjaxRequest){
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
					$oCriteria->with = array('present_employer');
					$oCriteria->addInCondition('present_employer.name', explode(':: ', substr(trim($_POST['Search']['present_employer']), 0, -2)));
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

//				echo '<pre>'.print_r($oCriteria, true).'</pre>'; die();
			}

			// instance condition
			if(Yii::app()->user->credentials['type'] != 'admin'){
				//$oCriteria->addInCondition('t.instances_id', $aInstances);
				$oCriteria->addSearchCondition('t.instances_id', $_POST['Search']['instances_id']);
			}

			Yii::app()->session->add('search_criteria', serialize(array('criteria' => $oCriteria, 'data' => $aPostedData)));

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

		//build toolbar session
		$aEmployees = CHtml::listData(Employees::model()->findAll($dataProvider->criteria),'id','name');

		$aToolbar = array();
		foreach($aEmployees as $id=>$sEmployeeName) {
			$aToolbar['employees'][] = array(
				'id' =>$id,
				'name' => $sEmployeeName
			);
		}
		$aToolbar['total_count'] = count($aEmployees);
		$aToolbar['currentIndex'] = 0;
		$aToolbar['currentId'] = $aToolbar['employees'][0];
		Yii::app()->session->add('toolbar',serialize($aToolbar));

		$this->render('list',array(
			'model'=>$model,
			'dataProvider' => $dataProvider
		));
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

	/**
	 * Alter draft pdf with user details
	 * @param CActiveRecord $oUserDraftArchive
	 * @param CActiverecord $oDraftTemplate
	 */
	public function actionShowPdf($id = null){
		$model = $this->loadModel($id);
		$sContent = $this->renderPartial('pdf', array('model' => $model), true);

//		echo '<pre>'.print_r($sContent, true).'</pre>'; die();

		// initialize PDF object
		$pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'mm', 'A4', true, 'UTF-8');
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Cory Coman');
		$pdf->SetTitle($model->name.' - '.date('Y-m-d'));
		$pdf->SetFont('dejavusans', '', 10);
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
		$pdf->AliasNbPages();
		$pdf->AddPage();

		$pdf->writeHTML($sContent, true, false, true, false, '');
		$pdf->Output($model->name.'.pdf', 'I');
		Yii::app()->end();
	}

	public function actionShowSelected() {
		$aChecked = array();
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_POST['ids'])) {
				foreach($_POST['ids'] as $val) {
						$aChecked[] = $val;
				}
			}
		}
		if (!empty($aChecked)) return serialize($aChecked);
		else return '';
	}
}
