<?php
/* @var $this RowController */
/* @var $model Row */

$this->breadcrumbs=array(
	'Filas'=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Listar Fila', 'url'=>array('index')),
	array('label'=>'Crear Fila', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#row-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Filas</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'row-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'rowId',
		'roomId',
		'rowName',
		'rowDescription',
		'createTime',
		'createUserId',
		/*
		'updateTime',
		'updateUserId',
		'Status',
		'Flag',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
