<?php
/* @var $this LocationController */
/* @var $model Location */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'location-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('rdt','Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>
	
	<div style="float:left;">
	<div class="custom-row">
		<?php echo $form->labelEx($model,'departmentId'); ?>
		<?php echo $form->dropDownList($model,'departmentId',$this->actionDepartmentOptions(),
			array(
				'empty'=>Yii::t('rdt','- Choose an option -'),
				'ajax'=>array(
					'type'=>'POST',
					'url'=>$this->createUrl('cityOptions'),
					'update'=>'#Location_cityId',
				),
			)
		); ?>
		<?php echo $form->error($model,'departmentId'); ?>
	</div>
	
	<div class="custom-row">
		<?php echo $form->labelEx($model,'cityId'); ?>
		<?php echo $form->dropDownList($model,'cityId',array('empty'=>Yii::t('rdt','- Choose an option -'))); ?>
		<?php echo $form->error($model,'cityId'); ?>
	</div>
	</div>
	
	<div style="float:left;">
	<div class="custom-row">
		<?php echo $form->labelEx($model,'divisionId'); ?>
		<?php echo $form->dropDownList($model,'divisionId',$this->actionDivisionOptions(),
			array(
				'empty'=>Yii::t('rdt','- Choose an option -'),
				'ajax'=>array(
					'type'=>'POST',
					'url'=>$this->createUrl('subdivisionOptions'),
					'update'=>'#Location_subdivisionId',
				),
			)
		); ?>
		<?php echo $form->error($model,'divisionId'); ?>
	</div>
	
	<div class="custom-row">
		<?php echo $form->labelEx($model,'subdivisionId'); ?>
		<?php echo $form->dropDownList($model,'subdivisionId',array('empty'=>Yii::t('rdt','- Choose an option -'))); ?>
		<?php echo $form->error($model,'subdivisionId'); ?>
	</div>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'locationName'); ?>
		<?php echo $form->textField($model,'locationName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'locationName'); ?>
	</div>
	
	<div style="float:left;">
	<div class="custom-row">
		<?php echo $form->labelEx($model,'locationAddress'); ?>
		<?php echo $form->textField($model,'locationAddress',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'locationAddress'); ?>
	</div>
	
	<div class="custom-row">
		<?php echo $form->labelEx($model,'locationNeighborhood'); ?>
		<?php echo $form->textField($model,'locationNeighborhood',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'locationNeighborhood'); ?>
	</div>
	</div>

	<div style="float:left;">
	<div class="custom-row">
		<?php echo $form->labelEx($model,'locationType'); ?>
		<?php echo $form->dropDownList($model,'locationType', $this->getLocationTypeOptions(), array('empty'=>Yii::t('rdt','- Choose an option -'))); ?>
		<?php echo $form->error($model,'locationType'); ?>
	</div>

	<div class="custom-row">
		<?php echo $form->labelEx($model,'locationStatus'); ?>
		<?php echo $form->dropDownList($model,'locationStatus', $this->getLocationStatusOptions(), array('empty'=>Yii::t('rdt','- Choose an option -'))); ?>
		<?php echo $form->error($model,'locationStatus'); ?>
	</div>
	</div>

	<div style="float:left;">
	<div class="custom-row">
		<?php echo $form->labelEx($model,'locationLongitude'); ?>
		<?php echo $form->textField($model,'locationLongitude',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'locationLongitude'); ?>
	</div>

	<div class="custom-row">
		<?php echo $form->labelEx($model,'locationLatitude'); ?>
		<?php echo $form->textField($model,'locationLatitude',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'locationLatitude'); ?>
	</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('rdt','Create') : Yii::t('rdt','Save'), array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->