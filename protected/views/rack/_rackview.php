<?php
/* @var $this RackController */
/* @var $data Rack */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('rackName')); ?>:</b>
	<?php echo CHtml::encode($data->rackName); ?>
	<br />

	<?php echo CHtml::image($data->rackType0->thumbnailPath,Yii::t('rdt','Rack miniature')); ?>
	
</div>