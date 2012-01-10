<?php

/**
 * This is the model class for table "instances".
 *
 * The followings are the available columns in table 'instances':
 * @property string $id
 * @property string $name
 * @property string $client_id
 * @property string $created
 * @property string $expire
 */
class Instances extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Instances the static model class
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
		return 'instances';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, client_id, created, expire', 'required'),
			array('name', 'length', 'max'=>255),
			array('client_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, client_id, created, expire', 'safe', 'on'=>'search'),
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
			'client' => array(self::BELONGS_TO, 'Clients', 'client_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Instance Name',
			'client_id' => 'Instance Client',
			'created' => 'Created',
			'expire' => 'Instance Expiration Date',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('client_id',$this->client_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('expire',$this->expire,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}