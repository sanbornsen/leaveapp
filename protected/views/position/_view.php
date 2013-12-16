<?php
/* @var $this PositionController */
/* @var $data Position */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pos_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pos_id), array('view', 'id'=>$data->pos_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pos_name')); ?>:</b>
	<?php echo CHtml::encode($data->pos_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pos_parent')); ?>:</b>
	<?php echo CHtml::encode($data->pos_parent); ?>
	<br />


</div>