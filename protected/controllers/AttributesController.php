<?php

class AttributesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	/**
	 * @var private property containing the associated AttributesChapter model inside
	 */
	private $_attributesChapter = null;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights',
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			'attributesChapterContext + create index admin',
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Attributes;

		//Assign the value of the attributeChapterId parameter before the create action
		$model->attributeChapterId = $this->_attributesChapter->attributeChapterId;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Attributes']))
		{
			$model->attributes=$_POST['Attributes'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->attributeId));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Attributes']))
		{
			$model->attributes=$_POST['Attributes'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->attributeId));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Attributes');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Attributes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Attributes']))
			$model->attributes=$_GET['Attributes'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Attributes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Attributes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Attributes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='attributes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Protected method to load the associated Attribute Chapter model class
	 * @param integer attributeChapterId the primary identifier of the associated Attribute Chapter
	 * @return object the Attribute Chapter data model based on the primary key
	 */
	protected function loadAttributesChapter($attributeChapterId)
	{
		//if the attribute chapter property is null, create it based on input id
		if($this->_attributesChapter===null)
		{
			$this->_attributesChapter=AttributesChapter::model()->findByPk($attributeChapterId);
			if($this->_attributesChapter===null)
			{
				throw new CHttpException(404, 'The requested attribute chapter does not exist.');
			}
		}
		return $this->_attributesChapter;
	}
	
	/**
	 * In.class defined filter method, configured for use in the above filters()
	 * method. It is called before the actionCreate() action method is run in
	 * order to ensure a proper attributeChapter context
	 */
	public function filterAttributesChapterContext($filterChain)
	{
		//set the attributeChapter identifier on GET input request variables
		if(isset($_GET['acid']))
		{
			$this->loadAttributesChapter($_GET['acid']);
		}
		else
			throw new CHttpException(403, 'Must specify an attribute chapter before performing this action.');
		
		//complete the running of the other filters and execute the requested action
		$filterChain->run();
	}
	
}
