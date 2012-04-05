<?php

/**
 * This is the model class for table "companies".
 *
 * The followings are the available columns in table 'companies':
 * @property integer $id
 * @property string $name
 * @property string $street
 * @property string $city
 * @property string $country
 * @property string $state
 * @property string $zip
 * @property string $phone
 * @property string $web
 * @property string $products
 * @property string $sales
 */
class Companies extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Companies the static model class
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
		return 'companies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instances_id', 'numerical', 'integerOnly'=>true),
			array('name', 'required'),
			array('name, street, city, country, state, zip, phone, web, sales', 'length', 'max'=>255),
			array('products', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, street, city, country, state, zip, phone, web, products, sales', 'safe', 'on'=>'search'),
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
				'employee'  => array(self::HAS_MANY, 'Employees', 'companies_id'),
				'instances' => array(self::BELONGS_TO, 'Instances', 'instances_id')
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
			'street' => 'Street',
			'city' => 'City',
			'country' => 'Country',
			'state' => 'State',
			'zip' => 'Zip',
			'phone' => 'Phone',
			'web' => 'Web',
			'products' => 'Products',
			'sales' => 'Sales',
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
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('web',$this->web,true);
		$criteria->compare('products',$this->products,true);
		$criteria->compare('sales',$this->sales,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>50),
		));
	}
}