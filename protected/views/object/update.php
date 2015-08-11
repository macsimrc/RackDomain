<?php
/* @var $this ObjectController */
/* @var $model Object */

$this->breadcrumbs=array(
	'Objects'=>array('index'),
	$model->objectId=>array('view','id'=>$model->objectId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Object', 'url'=>array('index')),
	array('label'=>'Create Object', 'url'=>array('create')),
	array('label'=>'View Object', 'url'=>array('view', 'id'=>$model->objectId)),
	array('label'=>'Manage Object', 'url'=>array('admin')),
);
?>

<h1>Update Object <?php echo $model->objectId; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>