<?php

/**
 * This is the model class for table "employees".
 *
 * The followings are the available columns in table 'employees':
 * @property string $id
 * @property integer $companies_id
 * @property integer $instances_id
 * @property string $name
 * @property string $title
 * @property string $geographical_area
 * @property string $contact_info
 * @property string $email
 * @property string $home_street
 * @property string $home_city
 * @property string $home_state_country
 * @property string $home_zip
 * @property string $home_phone
 * @property string $actual_location_street
 * @property string $actual_location_city
 * @property string $actual_location_state
 * @property string $profile
 * @property string $date_entered
 * @property string $date_update
 * @property string $misc_info
 */
class Employees extends CActiveRecord
{
	public $importdata;

	/**
	 * Property to display relational data from Companies Model
	 */
	public $company_name;

	/**
	 * Property to display notes data from Notes Model
	 */
	public $note;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Employees the static model class
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
		return 'employees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('importdata', 'required', 'on' => 'import'),
			array('importdata', 'file', 'types' => 'xls, xlsx', 'on' => 'import'),
			array('companies_id, instances_id', 'numerical', 'integerOnly'=>true),
			array('name, title, geographical_area, email, home_street, home_city, home_state_country, home_zip, home_phone, actual_location_street, actual_location_city, actual_location_state', 'length', 'max'=>255),
			array('contact_info, profile, date_entered, date_update, misc_info', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array(
			    'name, title, geographical_area, note, company_name',
			    'safe',
			    'on'=>'search'
			),
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
			'present_employer' => array(self::BELONGS_TO, 'Companies', 'companies_id'),
		    'notes' => array(self::HAS_ONE, 'Notes', 'employee_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'companies_id' => 'Companies',
			'instances_id' => 'Instances',
			'name' => 'Name',
			'title' => 'Title',
			'geographical_area' => 'Geographical Area',
			'contact_info' => 'Contact Info',
			'email' => 'Email',
			'home_street' => 'Home Street',
			'home_city' => 'Home City',
			'home_state_country' => 'Home State Country',
			'home_zip' => 'Home Zip',
			'home_phone' => 'Home Phone',
			'actual_location_street' => 'Actual Location Street',
			'actual_location_city' => 'Actual Location City',
			'actual_location_state' => 'Actual Location State',
			'profile' => 'Profile',
			'date_entered' => 'Date Entered',
			'date_update' => 'Date Update',
			'note' => 'Notes',
			'import' => 'Upload files',
		    'company_name' => 'Company'
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

		//$criteria->compare('companies_id',$this->companies_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('geographical_area',$this->geographical_area,true);
		if($this->note)
		{
		    $criteria->together  =  true;
		    $criteria->with = array('notes');
		    $criteria->compare('notes.note',$this->note,true);
		}
		if($this->company_name)
		{
		    $criteria->together  =  true;
		    $criteria->with = array('present_employer');
		    $criteria->compare('present_employer.name',$this->company_name,true);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}