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
					'print',
					'next',
					'prev',
					'getTooltip',
					'showPdf',
					'showSelected',
					'selection',
					'reset',
					'getCountryState',
					'update'
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

		//check if the profile was checked
		$aSession = unserialize(Yii::app()->session->get('search_criteria'));
		$isMarked = false;
		if(isset($aSession['employees'])){
			$aSelectedEmployees = $aSession['employees'];
			$isMarked = array_search($id, $aSelectedEmployees);
		}

		$this->render('view',array(
			'model' => $model,
			'isMarked' => $isMarked,
		));
	}

	/**
	 * This action ahow a profile in a printable format without toolbar and js
	 * @param int $id
	 */
	public function actionPrint($id)
	{
		$model = $this->loadModel($id);
		$this->render('print',array(
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
			$aSelectedEmployees = array_unique($aSelectedEmployees);
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
		$iActiveInstance = '';
		$aSession = unserialize(Yii::app()->session->get('search_criteria'));

		if (!empty($aSession['current_instance_id'])) {
			$iActiveInstance = $aSession['current_instance_id'];
			$aHints = Instances::model()->getHints($iActiveInstance);

			$i = Instances::model()->findByPk($iActiveInstance);
			$this->dbTitle = $i->name;
		} else {
			//go back to set an instance
			$this->redirect('/site/index');
		}

		$aPostedData = array();
		if(!empty($aSession['data'])){
			$aPostedData = $aSession['data'];
		}

		$model=new Employees('search');
		$model->unsetAttributes();  // clear any default values

		$this->render('admin',array(
			'model'=>$model,
			'aPostedData' => $aPostedData,
			'iActiveInstance' => $iActiveInstance,
			'aHints' => $aHints,
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
					'pagination'=>array('pageSize'=>50),
				));
			} else {
				$model->instances_id = $aInstances;
				$dataProvider = $model->search();
			}
		}

		//show selected button action
		if (isset($_GET['showSelected']) && !empty($aSession['employees'])) {
			$oCriteria1 = new CDbCriteria;
			$oCriteria1->addInCondition('t.id',$aSession['employees']);

			$dataProvider = new CActiveDataProvider($model, array(
				'criteria'=>$oCriteria1,
				'pagination'=>array('pageSize'=>50),
			));
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

				$dataProvider = new CActiveDataProvider($model, array(
					'criteria'=>$oCriteria,
					'pagination'=>array('pageSize'=>50),
				));
			} else {
				$model->attributes=$_GET['Employees'];
				$model->instances_id = $aInstances;
				$dataProvider = $model->search();
			}
		}

		if(isset($_POST['Search'])) {
			$oCriteria = new CDbCriteria;
			$aSearchFields = array(
				't.geographical_area',
				't.contact_info',
				't.profile',
				't.name',
				't.title',
				'present_employer.name',
				'notes.note');
			$aPostedData = $_POST;

			if($_POST['Search']['boolean_search']){
				// prepare condition string
				$sConditionalString = str_replace(array("'", 'OR ', 'AND ', 'ANDNOT ', 'NOT '), array('"', '', '+', '-', '-'), trim($_POST['Search']['boolean_search']));
				$isNot = substr_count($sConditionalString,'-');
				$iWords = str_word_count($sConditionalString);
				//workaround to avoid only NOT conditions with returns emty results
				if ($isNot == $iWords) {
					$sConditionalString = 'a* '.$sConditionalString;
				}
				if(substr($sConditionalString, 0, 1) != '-'){
					$sConditionalString = "'+".$sConditionalString."'";
				} else {
					$sConditionalString = "'".$sConditionalString."'";
				}

				$oCriteria->with = array('notes', 'present_employer');
				$oCriteria->condition = 'MATCH (t.search, notes.note, present_employer.name) AGAINST ('.$sConditionalString.' IN BOOLEAN MODE)';
			} else {
				$sConditionalString = '';
				$oCriteria->with = array('notes', 'present_employer');

				if($_POST['Search']['present_or_past_employer']){
					$aCond = explode('::', trim($_POST['Search']['present_or_past_employer']));

					$sConditionalString .= '+(';
					foreach($aCond as $sWord){
						if (!empty($sWord)) {
							if (1 == str_word_count($sWord)) {
								$sConditionalString .= trim($sWord).'* ';
							} else {
								$sConditionalString .= '"'. trim($sWord).'" ';
							}

						}
					}
					$sConditionalString = trim($sConditionalString);
					$sConditionalString .= ') ';
				}

				if($_POST['Search']['contact_info']){
					$aCond = explode(' ', trim($_POST['Search']['contact_info']));

					$sConditionalString .= '+(';
					foreach($aCond as $sWord){
						$sConditionalString .= '"'.$sWord.'" ';
					}
					$sConditionalString .= ') ';
				}

				if($_POST['Search']['exact_word']){
					$sWord = trim($_POST['Search']['exact_word']);
					$sConditionalString .= '+("' . $sWord . '") ';
				}

				if($_POST['Search']['any_word']){
					$aWordsToBeSearched = explode(' ', trim($_POST['Search']['any_word']));
					$sConditionalString .= '+(';
					$aConditionalString = array();
					foreach($aWordsToBeSearched as $sWord){
						$aConditionalString[]= $sWord;
					}
					$sConditionalString .= implode(' ', $aConditionalString);
					$sConditionalString .= ') ';
				}

				if($_POST['Search']['all_word']){
					$aWordsToBeSearched = explode(' ', trim($_POST['Search']['all_word']));
					$aConditionalString = array();
					foreach($aWordsToBeSearched as $sWord){
						$aConditionalString[]= '+' . $sWord;
					}
					$sConditionalString .= implode(' ', $aConditionalString).' ';
				}

				if($_POST['Search']['none_word']){
					$aWordsToBeSearched = explode(' ', trim($_POST['Search']['none_word']));
					$aConditionalString = array();
					foreach($aWordsToBeSearched as $sWord){
						$aConditionalString[] = '-' . $sWord;
					}
					$sConditionalString .= implode(' ', $aConditionalString);
				}

				$isNot = substr_count($sConditionalString,'-');
				$iWords = str_word_count($sConditionalString);
				//workaround to avoid only NOT conditions with returns emty results
				if ($isNot == $iWords) {
					$sConditionalString = 'a* '.$sConditionalString;
				}

				$oCriteria->condition = 'MATCH (t.search, notes.note, present_employer.name) AGAINST (\''.$sConditionalString.'\' IN BOOLEAN MODE)';

				if($_POST['Search']['present_employer']){
					$oCriteria1 = new CDbCriteria;
					$aCond = explode('::', trim($_POST['Search']['present_employer']));
					foreach ($aCond as $key=>$sWord) {
						if (!empty($sWord)) {
							$sWord = trim($sWord);
							$oCriteria1->addSearchCondition('present_employer.name', $sWord, true, 'OR');
						}
					}
					$oCriteria->mergeWith($oCriteria1);
				}

				if($_POST['Search']['country_state']){
					$oCriteria1 = new CDbCriteria;
					$aCond = explode('::', trim($_POST['Search']['country_state']));
					foreach ($aCond as $key=>$sWord) {
						if (!empty($sWord)) {
							$sWord = trim($sWord);
							$oCriteria1->addSearchCondition('t.geographical_area', $sWord, true, 'OR');
						}
					}
					$oCriteria->mergeWith($oCriteria1);
//                  $sConditionalString .= '+(';
//                  foreach($aCond as $sWord){
//                      $sConditionalString .= '"'.$sWord.'" ';
//                  }
//                  $sConditionalString .= ') ';
				}
			}

//			echo '<pre>'.print_r($oCriteria, true).'</pre>'; //die();

			// instance condition
			if(Yii::app()->user->credentials['type'] != 'admin'){
				$oCriteria->addSearchCondition('t.instances_id', $_POST['Search']['instances_id']);
			}

			Yii::app()->session->add('search_criteria', serialize(array(
				'criteria' => $oCriteria,
				'data' => $aPostedData,
				'current_instance_id'=>$_POST['Search']['instances_id'],
			)));

			$dataProvider = new CActiveDataProvider($model, array(
				'criteria'=>$oCriteria,
				'pagination'=>array('pageSize'=>50),
			));
		}

		if(empty($dataProvider)){
			$aSession = unserialize(Yii::app()->session->get('search_criteria'));
			if(!empty($aSession) && isset($aSession['criteria'])){
				$dataProvider = new CActiveDataProvider($model, array(
					'criteria' => $aSession['criteria'],
					'pagination'=>array('pageSize'=>50),
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
		$aToolbar['currentId'] = isset($aToolbar['employees'][0]) ? $aToolbar['employees'][0] : null;
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

	/**
	*  Reset search
	*/
	public function actionReset()
	{
		Yii::app()->session->remove('search_criteria');
		Yii::app()->end();
	}

	/**
	 * Ajax request get country/state for autocomplete
	 * @return json
	 */
	public function actionGetCountryState(){
		$aResult = array();
		$sTerm = trim($_GET['term']);

		$oCriteria = new CDbCriteria;
		$oCriteria->addCondition('t.geographical_area LIKE "'.$sTerm.'%"');
		$oCriteria->order = 't.geographical_area ASC';
		$oCriteria->group = 't.geographical_area';
		$oCriteria->limit = 15;
		$aGeoAreas = Employees::model()->findAll($oCriteria);
		foreach($aGeoAreas as $iKey => $aGeoArea){
			$aResult[] = array(
				'item' => $aGeoArea['geographical_area'],
				'value' => $aGeoArea['geographical_area']
			);
		}

		echo CJSON::encode($aResult);
		Yii::app()->end();
	}

	/**
	* Check if user is allowed to search this instance
	* @param int $iInstanceId
	* @return boolean
	*/
	protected function checkIfAllowedInstance($iInstanceId)
	{
		if(InstancesUsers::model()->find('instance_id = :iID AND user_id = :uID', array(':iID' => $iInstanceId, ':uID' => Yii::app()->user->id))){
			return true;
		}
		return false;
	}
}
