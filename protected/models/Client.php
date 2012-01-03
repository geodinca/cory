<?php

/**
 * This is the model class for table "tbl_clients".
 *
 * The followings are the available columns in table 'tbl_clients':
 * @property integer $id
 * @property string $name
 * @property string $demo_title
 * @property string $application_title
 * @property string $expiration
 *
 * The followings are the available model relations:
 * @property TblEmployees[] $tblEmployees
 */
class Client extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Client the static model class
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
		return 'tbl_clients';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, demo_title, application_title', 'length', 'max'=>255),
			array('expiration', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, demo_title, application_title, expiration', 'safe', 'on'=>'search'),
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
			'tblEmployees' => array(self::HAS_MANY, 'TblEmployees', 'clients_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'demo_title' => 'Demo Title',
			'application_title' => 'Application Title',
			'expiration' => 'Expiration',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('demo_title',$this->demo_title,true);
		$criteria->compare('application_title',$this->application_title,true);
		$criteria->compare('expiration',$this->expiration,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}