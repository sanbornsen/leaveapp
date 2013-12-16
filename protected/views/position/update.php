<?php
/* @var $this PositionController */
/* @var $model Position */

$this->breadcrumbs=array(
	'Positions'=>array('index'),
	$model->pos_id=>array('view','id'=>$model->pos_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Position', 'url'=>array('index')),
	array('label'=>'Create Position', 'url'=>array('create')),
	array('label'=>'View Position', 'url'=>array('view', 'id'=>$model->pos_id)),
	array('label'=>'Manage Position', 'url'=>array('admin')),
);
?>

<h1>Update Position <?php echo $model->pos_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>