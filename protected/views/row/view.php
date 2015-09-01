<?php
/* @var $this RowController */
/* @var $model Row */

$this->breadcrumbs=array(
	$model->room->location->locationName=>array('location/view','id'=>$model->room->location->locationId),
	$model->room->roomName=>array('room/view','id'=>$model->room->roomId),
	$model->rowName,
);

$this->menu=array(
	array('label'=>'Back To Room', 'url'=>array('room/view', 'id'=>$model->room->roomId)),
	array('label'=>'Update Row', 'url'=>array('update', 'id'=>$model->rowId)),
	array('label'=>'Delete Row', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->rowId, 'rid'=>$model->room->roomId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Create Racks', 'url'=>array('rack/create', 'rid'=>$model->rowId)),
	array('label'=>'Order Racks', 'url'=>array('rack/order', 'rid'=>$model->rowId)),
);
?>

<h1>View Row <?php echo $model->rowName; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'rowName',
		'rowDescription',
	),
)); ?>

<br />
<h1>Row Racks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$rackDataProvider,
	'itemView'=>'/rack/_view',
	'htmlOptions'=>array('class'=>'list-view-horizontal'),
)); ?>
