<?php
/* @var $this RackController */
/* @var $model Rack */

$this->breadcrumbs=array(
	Yii::t('rdt','Racks')=>array('index'),
	Yii::t('rdt','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('rdt','List Rack'), 'url'=>array('index')),
	array('label'=>Yii::t('rdt','Create Rack'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#rack-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('rdt','Manage Racks'); ?></h1>

<p><?php echo
Yii::t('rdt','You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</p>

<?php echo CHtml::link(Yii::t('rdt','Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rack-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'rackId',
		'rowId',
		'rackPosition',
		'rackName',
		'rackFacePosition',
		'rackType',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
