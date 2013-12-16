<?php
/* @var $this LeaveController */
/* @var $model Leave */

$this->breadcrumbs=array(
	'Leaves'=>array('index'),
	$model->leave_id,
);

$this->menu=array(
	array('label'=>'List Leave', 'url'=>array('index')),
	array('label'=>'Create Leave', 'url'=>array('create')),
	array('label'=>'Update Leave', 'url'=>array('update', 'id'=>$model->leave_id)),
	array('label'=>'Delete Leave', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->leave_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Leave', 'url'=>array('admin')),
);
?>

<h1>View Leave #<?php echo $model->leave_id; ?></h1>
<div class="well">
<?php $parents = json_decode($model->leave_way);?>
<strong>Leave Aplicant : </strong> <?=Users::model()->getNameById($model->user_id)?> <br>
<strong>Leave Type : </strong> <?=LeaveType::model()->getNameById($model->leave_type)?><br>
<strong>Leave From : </strong><?php $start = date('d-m-Y',strtotime($model->leave_from)); echo $start; ?><br>
<strong>Leave From : </strong><?php $end = date('d-m-Y',strtotime($model->leave_to)); echo $end; ?><br>

<?php 
	$count = 0;
	while(strtotime($start) <= strtotime($end)){
		if(date('D',strtotime($start)) != 'Sun'){
			$count++;
		}
		$start = date ("Y-m-d", strtotime("+1 day", strtotime($start)));
	}
?>



<strong>Application Letter : </strong> <br>
<p><?=$model->leave_reason?></p><br>
</div>
<strong>Status : </strong>
<?php foreach($parents as $key => $value):?>
	<?php if($key == $model->approved_by):?>
		<div class="alert alert-success"><?=Users::model()->getNameById($key)?> : Approved </div>
	<?php elseif($value == 'pending'):?>
		<div class="alert"><?=Users::model()->getNameById($key)?> : Pending </div>
	<?php elseif($value == 'rejected'):?>
		<div class="alert alert-error"><?=Users::model()->getNameById($key)?> : Rejected </div>
	<?php endif;?>
<?php endforeach;?>