<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	'Cities'=>array('index'),
	$model->cityId=>array('view','id'=>$model->cityId),
	'Update',
);

$this->menu=array(
	array('label'=>'List City', 'url'=>array('index')),
	array('label'=>'Create City', 'url'=>array('create')),
	array('label'=>'View City', 'url'=>array('view', 'id'=>$model->cityId)),
	array('label'=>'Manage City', 'url'=>array('admin')),
);
?>

<h1>Update City <?php echo $model->cityId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>