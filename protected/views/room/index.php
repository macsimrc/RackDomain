<?php
/* @var $this RoomController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	$model->location->locationName=>array('location/view','id'=>$model->location->locationId),
	Yii::t('rdt','Rooms'),
);

$this->menu=array(
	array('label'=>Yii::t('rdt','Back To Location'), 'url'=>array('location/view','id'=>$model->location->locationId)),
	array('label'=>Yii::t('rdt','Create Room'), 'url'=>array('create')),
	array('label'=>Yii::t('rdt','Manage Room'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('rdt','Rooms'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
