<?php
$this->breadcrumbs=array(
	(UserModule::t('Users'))=>array('admin'),
	$model->username=>array('view','id'=>$model->id),
	(UserModule::t('Update')),
);
$this->menu=array(
	array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
	array('label'=>UserModule::t('View User'), 'url'=>array('view','id'=>$model->id)),
	array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
	array('label'=>UserModule::t('Manage User'), 'url'=>array('admin')),
	array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
);
?>

<h1><?php echo  UserModule::t('Update User')." ".$model->username; ?></h1>

<?php 
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile)); 
?>