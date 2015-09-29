<?php
$this->breadcrumbs=array(
	UserModule::t('Profile Fields')=>array('admin'),
	UserModule::t('Create'),
);
$this->menu=array(
	array('label'=>UserModule::t('Manage User'), 'url'=>array('/user/admin')),
	array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('admin')),
);
?>

<h1><?php echo UserModule::t('Create Profile Field'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>