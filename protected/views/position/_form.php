<?php
/* @var $this PositionController */
/* @var $model Position */
/* @var $form CActiveForm */
?>

<div style="padding-left:30px" class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'position-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pos_name'); ?>
		<?php echo $form->textField($model,'pos_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'pos_name',array('style'=>'color:red')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pos_parent'); ?>
		<?php $posts = Position::model()->findAll();?>
		<select name="Position[pos_parent]">
			<option value="0">--------none----------</option>
			<?php foreach ($posts as $post):?>
				<option value="<?=$post->pos_id?>"><?=$post->pos_name?></option>
			<?php endforeach;?>
		</select>
		<?php echo $form->error($model,'pos_parent'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->