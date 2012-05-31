<?php

/**
 * This is the model class for table "stats".
 *
 * The followings are the available columns in table 'stats':
 * @property integer $id
 * @property integer $user_id
 * @property string $login_date
 * @property string $search
 */
class Stats extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Stats the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stats';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('login_date, search', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, login_date, search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'login_date' => 'Login Date',
			'search' => 'Search',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('login_date',$this->login_date,true);
		$criteria->compare('search',$this->search,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Log for current usser the terms of search received as parameter
	 * @param unknown_type $aSearch
	 */
	public function log_search($aSearch)
	{
		$user_id = Yii::app()->user->id;
		$current_date = date( 'Y-m-d H:i:s', time() );
		$instance_id = $aSearch['instances_id'];
		if (!empty($instance_id)) {
			$oInstance = Instances::model()->findByPk($instance_id);
		}
		$search = $oInstance->name;
		unset($aSearch['instances_id']);
		foreach($aSearch as $key => $term) {
			if(!empty($term)) {
				$search .= ", $key: $term";
			}
		}
		if(!empty($user_id) && !empty($search)) {
			$model = new Stats();
			$aData = array(
				'user_id' => $user_id,
				'login_date' => $current_date,
				'search' => $search
			);	
			$model->attributes = $aData;	
			$model->save();
		}
	}
	
	/**
	 * Return Username By user-Id to be rendered in grid
	 * @param unknown_type $data - the current row data
	 * @param unknown_type $row - the row index
	 */
	public function renderUser($data,$row)
	{
		$userModel = new Users();
		$oUser = $userModel->findByPk($data->user_id);
		return $oUser->username;
	}
}