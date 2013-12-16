<?php
/* @var $this LeaveController */
/* @var $data Leave */
?>

<div class="view" style="float:left;width:100%;border:1px solid;margin:10px;padding:10px">
	<div style="float:left;width:50%">
	<strong>Leave Number : </strong>
	<?=CHtml::link(CHtml::encode("#".$data->leave_id), array('view', 'id'=>$data->leave_id))?>
	<br>
	
	<strong>Leave Applied by : </strong>
	<?=Users::model()->findNameByUserid($data->user_id)?>
	<br>
	
	<strong>Leave Applied on : </strong>
	<?=date('d-M-Y',strtotime($data->applied_on))?>
	<br>
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_from')); ?>:</b>
	<?php echo CHtml::encode(date('d-M-Y',strtotime($data->leave_from))); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('leave_to')); ?>:</b>
	<?php echo CHtml::encode(date('d-M-Y',strtotime($data->leave_to))); ?>
	<br />
	
	<strong> Leave Days : </strong>
	<?php 
	$d = $data->leave_from;
	while (strtotime($d) <= strtotime($data->leave_to)) {
		$day = date("D",strtotime($d));
		if($day == "Sun"){
			echo "<span style='color:red'>".$day."</span>";
		}
		else{
			echo "<span>".$day."</span>";
		}
		if(strtotime($d) != strtotime($data->leave_to)){
			echo ", ";
		}
		$d = date ("Y-m-d", strtotime("+1 day", strtotime($d)));
	}
	
	?>
	<br>
	<strong>Letter : </strong><br>
	<?=$data->leave_reason?>
	<br>
	<strong>Status : </strong>
	<span id="leavestatus_<?=$data->leave_id?>">
	<?php echo Leave::model()->leavestatus($data->leave_id);?>
	</span>
</div>
<div>
	
	<?php $way = json_decode($data->leave_way,TRUE);
	if(isset($way[Users::model()->findIdByUsername(Yii::app()->user->name)])):
	if($data->user_id != Users::model()->findIdByUsername(Yii::app()->user->name) and $way[Users::model()->findIdByUsername(Yii::app()->user->name)] == "pending"):?>
	<span id="leave_action_<?=$data->leave_id?>">
		<button onclick="javascript:leave_accept(<?=$data->leave_id?>)" class="btn btn-primary">Accept</button>
		<button onclick="javascript:leave_reject(<?=$data->leave_id?>)" class="btn">Reject</button>
		<button onclick="javascript:ask_comment_modal(<?=$data->leave_id?>)" class="btn">Ask to comment</button>
	</span>
	<?php endif; endif;?>
	<?php
	$current_user = Users::model()->findIdByUsername(Yii::app()->user->name);
	$comments = array();
	if($data->comment != "")
		$comments = json_decode($data->comment,TRUE); 
	$flag = 1;
	foreach($way as $l){
		if($l == "accepted" or $l == "rejected")
			$flag = 0;
	}
	//echo $flag;
	if(array_key_exists($current_user,$comments) and $flag):?>
	<span id="comment_<?=$data->leave_id?>">
		<button id="comment_button_<?=$data->leave_id?>" onclick="javascript:comment_modal(<?=$data->leave_id?>)" class="btn">
		<?php if($comments[$current_user]['comment']==""):?>
			Add a Comment
		<?php else:?>
			Edit Comment
		<?php endif;?>
		</button>
	</span>
	<?php endif;?>
	
	
	<div style="max-height: 70%;overflow: hidden;" id="show_comment_<?=$data->leave_id?>">
	<?php
	echo Leave::model()->showcomment($data->leave_id);
	?>
	</div>
</div>
</div>