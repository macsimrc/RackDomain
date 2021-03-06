<?php

class ReportsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights',
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'cityOptions', 'subdivisionOptions', 'adduser'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	} */

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{	
		Yii::app()->user->setState('lid',$id);
		
		$roomDataProvider=new CActiveDataProvider('Room', array(
			'criteria'=>array(
				'condition'=>'locationId=:locationId',
				'params'=>array(':locationId'=>$this->loadModel($id)->locationId),
			),
			'pagination'=>array(
				'pageSize'=>1,
			),
		));
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'roomDataProvider'=>$roomDataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Location;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Location']))
		{
			$model->attributes=$_POST['Location'];
			// This code asures that if no longitude neither latitude parameter is set on location-form
			// Automatically set the location coordinates parameters be set based on the location city
			if($_POST['Location']['locationLongitude']==null||$_POST['Location']['locationLatitude']==null){
				$cityCoord = City::model()->findByPk($_POST['Location']['cityId']);
				$model->locationLongitude = $cityCoord->cityLongitude;
				$model->locationLatitude = $cityCoord->cityLatitude;
			}
			
			if($model->save())
			{
				//assign the user creating the new location as an owner of the location
				//so they have access to all project features
				$form=new LocationUserForm;
				$form->username = Yii::app()->user->name;
				$form->location = $model;
				$form->role = 'Coordinator';
				if($form->validate())
				{
					$form->assign();
				}
				$this->redirect(array('view','id'=>$model->locationId));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		Yii::app()->user->setState('lid',$id);
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Location']))
		{
			$model->attributes=$_POST['Location'];
			// This code asures that if no longitude neither latitude parameter is set on location-form
			// Automatically set the location coordinates parameters be set based on the location city
			if($_POST['Location']['locationLongitude']==null||$_POST['Location']['locationLatitude']==null){
				$cityCoord = City::model()->findByPk($_POST['Location']['cityId']);
				$model->locationLongitude = $cityCoord->cityLongitude;
				$model->locationLatitude = $cityCoord->cityLatitude;
			}
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->locationId));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		Yii::app()->user->setState('lid',$id);
		
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('location/index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{	
		$q = 'SELECT tbl_division.divisionName,Count(tbl_location.locationName) as total FROM tbl_division
			INNER JOIN tbl_location ON tbl_location.divisionId = tbl_division.divisionId
			GROUP BY tbl_division.divisionName';
		$cmd = Yii::app()->db->createCommand($q);
		$result = $cmd->queryAll();
		foreach ($result as $value)
		{
			$division[]=$value['divisionName'];
			$locations[]=(int)$value['total'];
		}
			
		$q = 'SELECT tbl_division.divisionName,(Sum(tbl_report.usedUrs)/Sum(tbl_report.urs))*100 AS ocupation FROM tbl_report
			INNER JOIN tbl_location ON tbl_report.locationId = tbl_location.locationId
			INNER JOIN tbl_division ON tbl_location.divisionId = tbl_division.divisionId
			GROUP BY tbl_division.divisionName';
		$cmd = Yii::app()->db->createCommand($q);
		$result = $cmd->queryAll();
		foreach ($result as $value)
			$ocupation[]=(int)$value['ocupation'];
		
		$this->render('index',array(
			'division'=>$division,
			'locations'=>$locations,
			'ocupation'=>$ocupation,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		$criteria = new CDbCriteria();
		$criteria->alias = 'tbl_location';
		$criteria->join = 'INNER JOIN tbl_location_user_assignment ON tbl_location_user_assignment.locationId = tbl_location.locationId';
		$criteria->condition = 'tbl_location_user_assignment.userId=:userId';
		$criteria->params = array(':userId'=>Yii::app()->user->id);
		$dataProvider = new CActiveDataProvider('Location', array(
			'criteria'=>$criteria,
		));
		
		$model=new Location('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Location']))
			$model->attributes=$_GET['Location'];

		$this->render('admin',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Location the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Location::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('rdt','The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Location $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='location-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/*
	 * Returns a list of valid departments for the geo-localization
	 */
	public function actionDepartmentOptions()
	{
		$department=Department::model()->findAll();
		return CHtml::listData($department,'departmentId','departmentName');
	}
	
	/*
	 * Returns a list of valid cities for the geo-localization
	 */
	public function actionCityOptions()
	{
		
		$city=City::model()->findAll('departmentId=:departmentId',
			array(':departmentId'=>$_POST['Location']['departmentId']));
		
		$city=CHtml::listData($city,'cityId','cityName');
		foreach($city as $value=>$cityName)
		{
			echo CHtml::tag('option',array('value'=>$value),CHtml::encode($cityName),true);
		}
	}
	
	/*
	 * Returns a list of valid divisions for mapping the Location in the company context
	 */
	public function actionDivisionOptions()
	{
		$division=Division::model()->findAll();
		return CHtml::listData($division,'divisionId','divisionName');
	}
	
	/*
	 * Returns a list of valid subdivisions for mapping the Location in the company context
	 */
	public function actionSubdivisionOptions()
	{
		
		$subdivision=Subdivision::model()->findAll('divisionId=:divisionId',
			array(':divisionId'=>$_POST['Location']['divisionId']));
		
		$subdivision=CHtml::listData($subdivision,'subdivisionId','subdivisionName');
		foreach($subdivision as $value=>$subdivisionName)
		{
			echo CHtml::tag('option',array('value'=>$value),CHtml::encode($subdivisionName),true);
		}
	}
	
	/*
	 * Returns a list of Location Types
	 */
	public function getLocationTypeOptions()
	{
		$locationType = LocationType::model()->findAll();
		return CHtml::listData($locationType, 'locationTypeId', 'locationTypeName');
	}
	
	/*
	 * Returns a list of Location Types
	 */
	public function getLocationStatusOptions()
	{
		$locationStatus = LocationStatus::model()->findAll();
		return CHtml::listData($locationStatus, 'locationStatusId', 'locationStatusName');
	}
	
	/**
	 * provides a form so that location administrators can
	 * associate other users to the project
	 */
	public function actionAdduser($lid)
	{
		//if(Yii::app()->user->checkAccess('Location.Adduser'))
		//{
		$location = $this->loadModel($lid);
		// check if the current user have access to actionAddUser prevents the access from direct URL injection
		if(!Yii::app()->user->checkAccess('addUserToLocation', array('location'=>$location)))
		{
			throw new CHttpException(403, Yii::t('rdt','You are not authorized to perform this action.'));
		}

		$form = new LocationUserForm;
		// collect user input data
		if(isset($_POST['LocationUserForm']))
		{
			$form->attributes=$_POST['LocationUserForm'];
			$form->location = $location;
			// validate user input
			if($form->validate())
			{
				if($form->assign())
				{
					Yii::app()->user->setFlash('success', $form->username .Yii::t('rdt',' has been added to the Location.'));
					//reset the form for another user to be associated if desired
					$form->unsetAttributes();
					$form->clearErrors();
				}
			}
		}
		//}//end if checkAccess
		
		//The CActiveRecord method with relations does not return the role data, by this reason
		// is needed to obtain thye data from a raw query to the database and convert it into an Data Provider type
		// using CArrayDataProvider
		/*
		$rawData = Yii::app()->db->createCommand()
			->select('tbl_users.id, tbl_users.username, tbl_location_user_assignment.role')
			->from('tbl_users')
			->join('tbl_location_user_assignment', 'tbl_location_user_assignment.userId = tbl_users.id')
			->where('tbl_location_user_assignment.locationId=:locationId', array(':locationId'=>$lid))
			->queryAll();
		
		$locationUsers=new CArrayDataProvider($rawData, array(
			'id'=>'id',
			'sort'=>array(
				'attributes'=>array(
					'username', 'role'
				),
			),
		));
		*/
		$criteria = new CDbCriteria();
		$criteria->condition = 'locationId=:locationId';
		$criteria->params = array(':locationId'=>$lid);
		$locationUsers = new CActiveDataProvider('LocationUserAssignment',array('criteria'=>$criteria));
		
		$form->location = $location;
		
		$this->render('adduser', array(
			'model'=>$form,
			'locationUsers'=>$locationUsers,
		));
	}
	
	public function actionMap($id)
	{
		$model = $this->loadModel($id);
		$this->render('map', array(
			'model'=>$model,
		));
	}
	
	public function actionRemoveUser($lid,$id)
	{
		//$criteria = new CDbCriteria();
		//$criteria->condition = 'locationId=:locationId AND userId=:userId';
		//$criteria->params = array(':locationId'=>$lid,':userId'=>$id);
		$model = LocationUserAssignment::model()->findByAttributes(array('locationId'=>$lid,'userId'=>$id));
		if($model->role=='Coordinator')
		{
			Yii::app()->user->setFlash('error',Yii::t('rdt','You need at least one User as Coordinator in this Location'));
		} else {
			$model->delete();
		}
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('location/addUser', 'lid'=>$lid));
		
	}
	
	public function actionGraphview()
	{
		$dataProvider = new CActiveDataProvider('ChartData');
		$this->render('graphview', array(
			'dataProvider'=>$dataProvider,
		));
		
	}
}
