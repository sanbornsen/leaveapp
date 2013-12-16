<?php
/* @var $this LeaveController */
/* @var $model Leave */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'leave_id'); ?>
		<?php echo $form->textField($model,'leave_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_from'); ?>
		<?php echo $form->textField($model,'leave_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_to'); ?>
		<?php echo $form->textField($model,'leave_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_reason'); ?>
		<?php echo $form->textArea($model,'leave_reason',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approved_by'); ?>
		<?php echo $form->textField($model,'approved_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'applied_on'); ?>
		<?php echo $form->textField($model,'applied_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approved_on'); ?>
		<?php echo $form->textField($model,'approved_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_way'); ?>
		<?php echo $form->textArea($model,'leave_way',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_type'); ?>
		<?php echo $form->textField($model,'leave_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->