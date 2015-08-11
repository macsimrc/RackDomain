<?php
/* @var $this CountryController */
/* @var $model Country */

$this->breadcrumbs=array(
	'Countries'=>array('index'),
	$model->countryId,
);

$this->menu=array(
	array('label'=>'List Country', 'url'=>array('index')),
	array('label'=>'Create Country', 'url'=>array('create')),
	array('label'=>'Update Country', 'url'=>array('update', 'id'=>$model->countryId)),
	array('label'=>'Delete Country', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->countryId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Country', 'url'=>array('admin')),
);
?>

<h1>View Country #<?php echo $model->countryId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'countryId',
		'countryName',
		'countryAbbreviation',
		'Status',
		'Flag',
	),
)); ?>
