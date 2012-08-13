<?php
/**
 * Widget to present user notes
 * @author cmarin
 *
 */

//Yii::import('application.models.Notes');

class GetUserProfile extends CWidget
{
	public $iEmployeeId = 0;
	public $iUserId = 0;

	public function init()
	{
		$oProfile = Employees::model()->find('id = :eId', array(':eId' => $this->iEmployeeId));
		if(isset($oProfile) && !empty($oProfile->profile)){
			//echo CHtml::encode($oNote->note);
			echo Yii::app()->format->profile($oProfile->profile);
		}
	}

	public function run()
	{
		// this method is called by CController::endWidget()
	}
}