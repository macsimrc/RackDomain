<?php

/**
 * This is the model class for table "{{location_type}}".
 *
 * The followings are the available columns in table '{{location_type}}':
 * @property integer $locationTypeId
 * @property string $locationTypeName
 * @property string $locationTypeDescription
 *
 * The followings are the available model relations:
 * @property Location[] $location
 */
class LocationType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{location_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('locationTypeName, locationTypeDescription', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('locationTypeId, locationTypeName, locationTypeDescription', 'safe', 'on'=>'search'),
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
			'location' => array(self::HAS_MANY, 'Location', 'locationType'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'locationTypeId' => 'Location Type',
			'locationTypeName' => 'Location Type Name',
			'locationTypeDescription' => 'Location Type Description',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('locationTypeId',$this->locationTypeId);
		$criteria->compare('locationTypeName',$this->locationTypeName,true);
		$criteria->compare('locationTypeDescription',$this->locationTypeDescription,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LocationType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
