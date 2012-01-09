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
		
		if(isset($_POST['Employees'])){
			// load Excel reader class
//			require_once('D:\xampp\htdocs\cory\protected\extensions\excelreader/Excel/reader.php');
			
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
			$aSavedCompanies = array(); //CHtml::listData(Companies::model()->findAll(), 'name', 'id');
			
//			echo '</table>' . "\n";
            for ($row = 2; $row <= $highestRow; ++$row) {
//              echo '<tr>' . "\n";
//              for ($col = 0; $col <= $highestColumnIndex; ++$col) {

				$sCompanyName = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
				if(!array_key_exists($sCompanyName, $aSavedCompanies)){
					$oCompanyModel = new Companies;
	              	$oCompanyModel->attributes = array(
		            	'name' => $sCompanyName, 
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
				echo '<pre>'.print_r($sCompanyName.'--'.$iCompanyId, true).'</pre>';
				
//                echo '<td>' . $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() . '</td>' . "\n";
//              }
//              echo '</tr>' . "\n";
            }
//            echo '</table>' . "\n";
            
            
            die();
			
			$oExcel = new Spreadsheet_Excel_Reader();
			// set output encoding
			$oExcel->setOutputEncoding('UTF-8');
			$oExcel->read($sFileToImport);
			echo '<pre>'.print_r($oExcel, true).'</pre>';
		}
		
		$this->render('admin',array('model' => $model));
	}

}