<?php

class RoomController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	/**
	 * @var private property containing the associated Sds model instance.
	 */
	private $_location = null;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights',
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			'locationContext + create index admin', //perform check to ensure valid sds context
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
				'actions'=>array('create','update'),
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
	
	
	public function setLocationId($id)//$id del controlador
	{
		$model = Room::model()->findByPk($id);
		$lid = $model->location->locationId;
		Yii::app()->user->setState('lid',$lid);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->setLocationId($id);
		
		$rowDataProvider=new CActiveDataProvider('Row', array(
			'criteria'=>array(
				'condition'=>'roomId=:roomId',
				'params'=>array(':roomId'=>$this->loadModel($id)->roomId),
			),
			'pagination'=>array(
				'pageSize'=>5,
			),
		));
		
		$pduDataProvider=new CActiveDataProvider('Pdu', array(
			'criteria'=>array(
				'condition'=>'roomId=:roomId',
				'params'=>array(':roomId'=>$this->loadModel($id)->roomId),
			),
			'pagination'=>array(
				'pageSize'=>5,
			),
		));
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'rowDataProvider'=>$rowDataProvider,
			'pduDataProvider'=>$pduDataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Room;
		$model->locationId = $this->_location->locationId;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Room']))
		{
			$this->addToReport($this->_location->locationId);
			
			$model->attributes=$_POST['Room'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->roomId));
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
		$this->setLocationId($id);
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Room']))
		{
			$model->attributes=$_POST['Room'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->roomId));
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
	public function actionDelete($id,$lid)
	{
		$this->setLocationId($id);
		
		$this->loadModel($id)->delete();
		
		$this->removeFromReport($lid);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('location/view', 'id'=>$lid));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
			
		$dataProvider=new CActiveDataProvider('Room', array(
			'criteria'=>array(
				'condition'=>'locationId=:locationId',
				'params'=>array(':locationId'=>$this->_location->locationId),
			),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Room('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Room']))
			$model->attributes=$_GET['Room'];
		
		$model->locationId = $this->_location->locationId;

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Room the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Room::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('rdt','The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Room $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='room-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Protected method to load the associated Sds model class
	 * @param integer sdsId the primary identifier of the associated Sds
	 * @return object the Sds data model based on the primary key
	 */
	protected function loadLocation($id)
	{
		//if the project property is null, create it based on input id
		if($this->_location===null)
		{
			$this->_location=Location::model()->findByPk($id);
			if($this->_location===null)
			{
				throw new CHttpException(404,Yii::t('rdt','The requested Location does not exist.'));
			}
		}
		
		return $this->_location;
	}
	
	/**
	 * In-class defined filter method, configured for use in the above filters() method.
	 * It is called before the actionCreate() action method is run in order to ensure a
	 * proper sds context.
	 */
	public function filterLocationContext($filterChain)
	{
		//set the sds identifier based on GET input request variables
		if(isset($_GET['lid']))
		{
			$this->loadLocation($_GET['lid']);
		}
		else {
			throw new CHttpException(403,Yii::t('rdt','Must specify a Location before performing this action.'));
		}
		
		$model = Location::model()->findByPk($this->_location->locationId);
		$lid = $model->locationId;
		Yii::app()->user->setState('lid',$lid);
		//complete the running of other filters and execute the requested action
		$filterChain->run();
	}
	
	public function addToReport($id)//$id is the locationId
	{
		$q = 'UPDATE tbl_report SET rooms=rooms+1 WHERE locationId=:locationId';
		$params = array(':locationId'=>$id);
		$cmd = Yii::app()->db->createCommand($q);
		$cmd->execute($params);
	}
	
	public function removeFromReport($id)//$id is the locationId
	{
		$q = 'UPDATE tbl_report SET rooms=rooms-1 WHERE locationId=:locationId';
		$params = array(':locationId'=>$id);
		$cmd = Yii::app()->db->createCommand($q);
		$cmd->execute($params);
	}
}
