<?php

/**
 * This is the model class for table "{{country}}".
 *
 * The followings are the available columns in table '{{country}}':
 * @property integer $countryId
 * @property string $countryName
 * @property string $countryAbbreviation
 * @property integer $Status
 * @property integer $Flag
 *
 * The followings are the available model relations:
 * @property Department[] $departments
 */
class Country extends InfraActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Country the static model class
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
		return '{{country}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('countryId', 'required'),
			array('countryId, Status, Flag', 'numerical', 'integerOnly'=>true),
			array('countryName, countryAbbreviation', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('countryId, countryName, countryAbbreviation, Status, Flag', 'safe', 'on'=>'search'),
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
			'departments' => array(self::HAS_MANY, 'Department', 'countryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'countryId' => Yii::t('rdt', 'Country'),
			'countryName' => Yii::t('rdt', 'Country Name'),
			'countryAbbreviation' => Yii::t('rdt', 'Country Abbreviation'),
			'Status' => Yii::t('rdt', 'Status'),
			'Flag' => Yii::t('rdt', 'Flag'),
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

		$criteria->compare('countryId',$this->countryId);
		$criteria->compare('countryName',$this->countryName,true);
		$criteria->compare('countryAbbreviation',$this->countryAbbreviation,true);
		$criteria->compare('Status',$this->Status);
		$criteria->compare('Flag',$this->Flag);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}