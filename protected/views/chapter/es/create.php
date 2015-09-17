<?php
/* @var $this ChapterController */
/* @var $model Chapter */

$this->breadcrumbs=array(
	'Chapters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Chapter', 'url'=>array('index')),
	array('label'=>'Manage Chapter', 'url'=>array('admin')),
);
?>

<h1>Create Chapter</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>