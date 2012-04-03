<?php
/**
 * Widget to present user notes
 * @author cmarin
 *
 */

//Yii::import('application.models.Notes');

class GetUserNotes extends CWidget
{
	public $iEmployeeId = 0;
	public $iUserId = 0;

	public function init()
	{
		$oNote = Notes::model()->find('employee_id = :eId AND user_id = :uID', array(':eId' => $this->iEmployeeId, ':uID' => $this->iUserId));
		if(isset($oNote) && !empty($oNote->note)){
			//echo CHtml::encode($oNote->note);
			echo Yii::app()->format->note($oNote->note);
		}
	}

	public function run()
	{
		// this method is called by CController::endWidget()
	}
}