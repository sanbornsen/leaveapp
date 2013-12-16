<?php
/* @var $this LeaveController */
/* @var $model Leave */
/* @var $form CActiveForm */
?>

<div class="form well">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'leave-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php if($form->errorSummary($model)):?>
		<div class="alert alert-error"><?php echo $form->errorSummary($model); ?></div>
	<?php endif;?>
	<div>
		<?php echo $form->labelEx($model,'leave_from'); ?>
		<?php echo $form->textField($model,'leave_from',array('id'=>'dpd1')); ?>
		<?php echo $form->error($model,'leave_from',array('style'=>'color:red')); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'leave_to'); ?>
		<?php echo $form->textField($model,'leave_to',array('id'=>'dpd2')); ?>
		<?php echo $form->error($model,'leave_to',array('style'=>'color:red')); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'leave_type'); ?>
		<?php echo $form->dropDownList($model,'leave_type', $leave_types, array('prompt'=>'-----------------------'));?>
		<?php echo $form->error($model,'leave_type',array('style'=>'color:red')); ?>
	</div>
	
	<div >
		<?php echo $form->labelEx($model,'leave_reason'); ?>
		<?php echo $form->textArea($model,'leave_reason',array('rows'=>6, 'cols'=>150, 'style'=>'width:500px!important')); ?>
		<?php echo $form->error($model,'leave_reason',array('style'=>'color:red')); ?>
	</div>


	

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->





   