<?php
/* @var $this PositionController */
/* @var $model Position */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pos_id'); ?>
		<?php echo $form->textField($model,'pos_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pos_name'); ?>
		<?php echo $form->textField($model,'pos_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pos_parent'); ?>
		<?php echo $form->textField($model,'pos_parent'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->