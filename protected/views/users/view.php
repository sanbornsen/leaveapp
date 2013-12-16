<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_id,
);

$this->menu=array(
	array('label'=>'List Users', 'url'=>array('index')),
	array('label'=>'Create Users', 'url'=>array('create')),
	array('label'=>'Update Users', 'url'=>array('update', 'id'=>$model->user_id)),
	array('label'=>'Delete Users', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>View Users #<?php echo $model->user_name; ?></h1>
<table class="detail-view" id="yw0">
<tr class="odd"><th>User Name</th><td><?=$model->user_name?></td></tr>
<tr class="even"><th>Name</th><td><?=ucwords($model->f_name." ".$model->l_name)?></td></tr>
<tr class="odd"><th>User Email</th><td><?=$model->user_email?></td></tr>
<tr class="even"><th>User Position</th><td><?=Position::model()->getPosById($model->user_position)?></td></tr>
<tr class="odd"><th>User Parent</th><td><?=Users::model()->getNameById($model->user_parent)?></td></tr>
</table>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
	),
)); ?>
