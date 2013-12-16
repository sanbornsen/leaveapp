<?php
/* @var $this LeaveController */
/* @var $model Leave */

$this->breadcrumbs=array(
	'Leaves'=>array('index'),
	$model->leave_id=>array('view','id'=>$model->leave_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Leave', 'url'=>array('index')),
	array('label'=>'Create Leave', 'url'=>array('create')),
	array('label'=>'View Leave', 'url'=>array('view', 'id'=>$model->leave_id)),
	array('label'=>'Manage Leave', 'url'=>array('admin')),
);
?>

<h1>Update Leave <?php echo $model->leave_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>