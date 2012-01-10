<?php

class ImportsController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->redirect('admin');
		Yii::app()->die();
	}
	
	/**
	 * Import employees and companies from excel file
	 * @return render statistics regarding the import
	 */
	public function actionAdmin(){
		$model = new Employees('import');
		$oInstanceModel = new Instances;
		
		if(isset($_POST['Employees'])){
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
//            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
//            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

            // register back to Yii autoload
            spl_autoload_register(array('YiiBase','autoload'));
            
            // get already saved companies
			$aSavedCompanies = CHtml::listData(Companies::model()->findAll(), 'name', 'id');
			// stats data
			$iOldCompanies = count($aSavedCompanies);
			$iNewCompanies = 0;
			$iNewEployees = 0; 
			$iUpdatedEmployees = 0;
			$iFailedEployees = 0;
			
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
						//@TODO Det next instance id 
						'instances_id' => 1, 
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
						'profile' => $objWorksheet->getCellByColumnAndRow(20, $row)->getValue(),
						'date_entered' => date('Y-m-d H:i:s'),
						'misc_info' => $objWorksheet->getCellByColumnAndRow(26, $row)->getValue()
					);
					if(!$oEmployeesModel->save()){
		            	$iFailedEployees++;
		            }
				}
            }
            
            //@TODO Move this to view
			echo 'Old companies '.$iOldCompanies.', new imported '.$iNewCompanies.';<br />';
			echo 'Imported '.$iNewEployees.', new employees, updated '.$iUpdatedEmployees.', failed: <b style="color: red;">'.$iFailedEployees.'</b><br />';
		}
		
		$this->render('admin',array('model' => $model, 'oInstanceModel' => $oInstanceModel));
	}

}