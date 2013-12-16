<?php
/* @var $this UsersController */
/* @var $data Users */
?>

<div style="padding:20px;" class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_name), array('view', 'id'=>$data->user_id)); ?>
	<br />
	<b>Name:</b>
	<?php echo CHtml::encode(ucwords($data->f_name." ".$data->l_name)); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_position')); ?>:</b>
	<?php echo CHtml::encode(Position::model()->getPosById($data->user_position)); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_email')); ?>:</b>
	<?php echo CHtml::encode($data->user_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_dob')); ?>:</b>
	<?php echo CHtml::encode($data->user_dob); ?>
	<br />


</div>