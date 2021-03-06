<?php
/* @var $this PduController */
/* @var $model Pdu */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pduCircuits-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('rdt','Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div>
	
	<p><?php echo Yii::t('rdt','Use this items to filter the objects.'); ?></p>
	
	<div class="custom-row">
		<?php echo $form->labelEx($modelRoom,'roomId',array('label'=>Yii::t('rdt','Room Name'))); ?>
		<?php echo $form->dropDownList($modelRoom,'roomId',$this->actionRoomOptions($model->pduId),
			array(
				'empty'=>Yii::t('rdt','- Choose an option -'),
				'ajax'=>array(
					'type'=>'POST',
					'url'=>$this->createUrl('rowOptions'),
					'update'=>'#rowId',
				),
		)); ?>
		<?php echo $form->error($modelRoom,'roomId'); ?>
	</div>
	
	<div class="custom-row">
		<?php echo $form->labelEx($modelRow,'rowId',array('label'=>Yii::t('rdt','Row Name'))); ?>
		<?php //echo $form->dropDownList($modelRow,'rowId',
				echo CHtml::dropDownList('rowId','',array(), //MAC: this replacces the form field dropdownlist an insert a plain html drop down list
			array(
				'empty'=>Yii::t('rdt','- Choose an option -'),
				'ajax'=>array(
					'type'=>'POST',
					'url'=>$this->createUrl('rackOptions'),
					'update'=>'#rackId',
				),
		)); ?>
		<?php echo $form->error($modelRow,'rowId'); ?>
	</div>
	
	<div class="custom-row">
		<?php echo $form->labelEx($modelRack,'rackId',array('label'=>Yii::t('rdt','Rack Name'))); ?>
		<?php //echo $form->dropDownList($modelRack,'rackName',
				echo CHtml::dropDownList('rackId','',array(), //MAC: this replacces the form field dropdownlist an insert a plain html drop down list
			array(
				'empty'=>Yii::t('rdt','- Choose an option -'),
				'ajax'=>array(
					'type'=>'POST',
					'url'=>$this->createUrl('objectOptions'),
					'update'=>'#PduCircuits_objectId',	
				),
			)); ?>
		<?php echo $form->error($modelRack,'rackId'); ?>
	</div>
	</div>
	
	<div>
	<div class="custom-row">
		<?php echo $form->labelEx($model,'objectId'); ?>
		<?php echo $form->dropDownList($model,'objectId',array('empty'=>Yii::t('rdt','- Choose an option -'))); ?>
		<?php echo $form->error($model,'objectId'); ?>
	</div>

	<div class="custom-row">
		<?php echo $form->labelEx($model,'pduCircuitBus'); ?>
		<?php if($modelPdu->pduType->pduBuses==2){
			echo $form->dropDownList($model,'pduCircuitBus',array('empty'=>Yii::t('rdt','- Choose an option -'), 'A'=>Yii::t('rdt','Bus A'), 'B'=>Yii::t('rdt','Bus B')));
		} else echo $form->dropDownList($model,'pduCircuitBus',array('empty'=>Yii::t('rdt','- Choose an option -'), 'A'=>Yii::t('rdt','Bus A')));?>
		<?php echo $form->error($model,'pduCircuitBus'); ?>
	</div>

	<div class="custom-row">
		<?php echo $form->labelEx($model,'pduCircuitNumber'); ?>
		<?php echo $form->dropDownList($model,'pduCircuitNumber',$this->getAvailableCircuits($model->pduId),array('empty'=>Yii::t('rdt','- Choose an option -'))); ?>
		<?php echo $form->error($model,'pduCircuitNumber'); ?>
	</div>
	</div>
	 
	<div>
	<div class="custom-row">
		<?php echo $form->labelEx($model,'breakerRate'); ?>
		<?php echo $form->dropDownList($model,'breakerRate',$this->getBreakerRateOptions(),array('empty'=>Yii::t('rdt','- Choose an option -'))); ?>
		<?php echo $form->error($model,'breakerRate'); ?>
	</div>
	
	<div class="custom-row">
		<?php echo $form->labelEx($model,'breakerState'); ?>
		<?php echo $form->dropDownList($model,'breakerState',array('empty'=>Yii::t('rdt','- Choose an option -'), '0'=>'OFF', '1'=>'ON')); ?>
		<?php echo $form->error($model,'breakerState'); ?>
	</div>
	
	<div class="custom-row">
		<?php echo $form->labelEx($model,'pduCircuitDescription'); ?>
		<?php echo $form->textArea($model,'pduCircuitDescription', array('size'=>60,'maxLength'=>1024)); ?>
		<?php echo $form->error($model,'pduCircuitDescription'); ?>
	</div>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('rdt','Create') : Yii::t('rdt','Save'), array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->