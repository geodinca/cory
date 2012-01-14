<?php

class ImportsController extends Controller
{
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->redirect('admin');
	}
	
	/**
	 * Import employees and companies from excel file
	 * @return render statistics regarding the import
	 */
	public function actionAdmin(){
		$model = new Employees('import');
		$oInstanceModel = new Instances;
		
		// import results
		$iOldCompanies = 0;
		$iNewCompanies = 0;
		$iNewEployees = 0; 
		$iUpdatedEmployees = 0;
		$iFailedEployees = 0;
		
		if(isset($_POST['Employees'])){
			// save instance
			$oInstance = new Instances;
			$oInstance->attributes = $_POST['Instances'];
			$oInstance->created = date('Y-m-d H:i:s');
			if($oInstance->save()){
			
				$model->importdata = CUploadedFile::getInstance($model, 'importdata');
				// path to xls imported file
				$sFileToImport = $model->importdata->tempName;
				
				// unregister Yii autolod, PHP Excel use it's own
				spl_autoload_unregister(array('YiiBase','autoload'));
				// import 3'rd party files
				Yii::import('application.vendors.PHPExcel',true);
				
				if(stristr($model->importdata->name, '.xlsx')){
	            	$objReader = new PHPExcel_Reader_Excel2007;
				} else {
					$objReader = new PHPExcel_Reader_Excel5;
				}
	            $objPHPExcel = $objReader->load(@$sFileToImport);
	            $objWorksheet = $objPHPExcel->getActiveSheet();
	            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
	
	            // register back to Yii autoload
	            spl_autoload_register(array('YiiBase','autoload'));
	            
	            // get already saved companies
				$aSavedCompanies = CHtml::listData(Companies::model()->findAll(), 'name', 'id');
				
				// already imported companies
				$iOldCompanies = count($aSavedCompanies);
				
	            for ($row = 2; $row <= $highestRow; ++$row) {
					$sCompanyName = strtolower($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
					if(!array_key_exists($sCompanyName, $aSavedCompanies)){
						$oCompanyModel = Companies::model()->findByAttributes(array('name' => ucwords($sCompanyName)));
						if(!$oCompanyModel){
							$oCompanyModel = new Companies;
							$iNewCompanies++;
						}
						
		              	$oCompanyModel->attributes = array(
			            	'name' => ucwords($sCompanyName), 
			            	'street' => $objWorksheet->getCellByColumnAndRow(5, $row)->getValue(), 
			            	'city' => $objWorksheet->getCellByColumnAndRow(6, $row)->getValue(), 
			            	'country' => $objWorksheet->getCellByColumnAndRow(7, $row)->getValue(), 
			            	'state' => $objWorksheet->getCellByColumnAndRow(7, $row)->getValue(), 
			            	'zip' => $objWorksheet->getCellByColumnAndRow(8, $row)->getValue(), 
			            	'phone' => $objWorksheet->getCellByColumnAndRow(9, $row)->getValue(), 
			            	'web' => $objWorksheet->getCellByColumnAndRow(10, $row)->getValue(), 
			            	'products' => $objWorksheet->getCellByColumnAndRow(22, $row)->getValue(), 
			            	'sales'  => $objWorksheet->getCellByColumnAndRow(23, $row)->getValue()
			            );
			            
			            if($oCompanyModel->save()){
			            	$aSavedCompanies[$sCompanyName] = $oCompanyModel->id;
			            }
					} 
					// get company id to save into employees table
					$iCompanyId = $aSavedCompanies[$sCompanyName];
					
					if($iCompanyId){
						$sEmployeeName = ucwords($objWorksheet->getCellByColumnAndRow(0, $row)->getValue());
						
						$oEmployeesModel = Employees::model()->findByAttributes(array('name' => $sEmployeeName));
						if(!$oEmployeesModel){
							$iNewEployees++;
							$oEmployeesModel = new Employees;
						} else {
							$iUpdatedEmployees++;	
						}
						
						$oEmployeesModel->attributes = array(
							'companies_id' => $iCompanyId,
							'instances_id' => $oInstance->id, 
							'name' => $sEmployeeName,
							'title' => $objWorksheet->getCellByColumnAndRow(1, $row)->getValue(),
							'geographical_area' => $objWorksheet->getCellByColumnAndRow(3, $row)->getValue(),
							'contact_info' => $objWorksheet->getCellByColumnAndRow(4, $row)->getValue(),
							'email' => $objWorksheet->getCellByColumnAndRow(11, $row)->getValue(),
							'home_street' => $objWorksheet->getCellByColumnAndRow(12, $row)->getValue(),
							'home_city' => $objWorksheet->getCellByColumnAndRow(13, $row)->getValue(),
							'home_state_country' => $objWorksheet->getCellByColumnAndRow(14, $row)->getValue(),
							'home_zip' => $objWorksheet->getCellByColumnAndRow(15, $row)->getValue(),
							'home_phone' => $objWorksheet->getCellByColumnAndRow(16, $row)->getValue(),
							'actual_location_street' => $objWorksheet->getCellByColumnAndRow(17, $row)->getValue(),
							'actual_location_city' => $objWorksheet->getCellByColumnAndRow(18, $row)->getValue(),
							'actual_location_state' => $objWorksheet->getCellByColumnAndRow(19, $row)->getValue(),
							'profile' => $objWorksheet->getCellByColumnAndRow(21, $row)->getValue(),
							'date_entered' => date('Y-m-d H:i:s'),
							'misc_info' => $objWorksheet->getCellByColumnAndRow(26, $row)->getValue()
						);
						if(!$oEmployeesModel->save()){
			            	$iFailedEployees++;
			            }
					}
	            }
			}
		}
		
		$this->render('admin',array(
			'model' => $model, 
			'oInstanceModel' => $oInstanceModel,
			'iOldCompanies' => $iOldCompanies,
			'iNewCompanies' => $iNewCompanies,
			'iNewEployees' => $iNewEployees,
			'iUpdatedEmployees' => $iUpdatedEmployees,
			'iFailedEployees' => $iFailedEployees,
		));
	}

}