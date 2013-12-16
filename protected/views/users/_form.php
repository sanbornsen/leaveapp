<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div style="padding-left:30px" class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ang">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_name',array('style'=>'color:red')); ?>
	</div>

	<div class="ang">
		<?php echo $form->labelEx($model,'f_name'); ?>
		<?php echo $form->textField($model,'f_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'f_name',array('style'=>'color:red')); ?>
	</div>

	<div class="ang">
		<?php echo $form->labelEx($model,'l_name'); ?>
		<?php echo $form->textField($model,'l_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'l_name',array('style'=>'color:red')); ?>
	</div>

	<div >
		<?php echo $form->labelEx($model,'user_email'); ?>
		<?php echo $form->textField($model,'user_email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_email',array('style'=>'color:red')); ?>
	</div>

	<div class="ang">
		<?php echo $form->labelEx($model,'user_dob'); ?>
		<?php echo $form->textField($model,'user_dob',array('placeholder'=>'YYYY-MM-DD','id'=>'dob')); ?>
		<?php echo $form->error($model,'user_dob',array('style'=>'color:red')); ?>
	</div>
	<div class="ang">
		<?php echo $form->labelEx($model,'user_position'); ?>
		<?php $posts = Position::model()->findAll();?>
		<select id="user_position" name="Users[user_position]" onchange="javascript:parents()">
			<option value="0">--------none----------</option>
			<?php foreach ($posts as $post):?>
				<?php if($model->user_position == $post->pos_id):?>
					<option value="<?=$post->pos_id?>" selected><?=$post->pos_name?></option>
				<?php else:?>
					<option value="<?=$post->pos_id?>"><?=$post->pos_name?></option>
				<?php endif;?>
			<?php endforeach;?>
		</select>
		<?php echo $form->error($model,'user_position',array('style'=>'color:red')); ?>
	</div>

	<div class="ang">
		<?php echo $form->labelEx($model,'user_parent'); ?>
		<select id="parent_list" name="Users[user_parent]">
			<option value="0">--------none----------</option>
		</select>
		<?php echo $form->error($model,'user_parent',array('style'=>'color:red')); ?>
	</div>

	<div class="ang">
		<?php echo $form->labelEx($model,'user_salary'); ?>
		<?php echo $form->textField($model,'user_salary'); ?>
		<?php echo $form->error($model,'user_salary',array('style'=>'color:red')); ?>
	</div>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
	function parents(id){
		var val = document.getElementById('user_position').value;
		var xmlhttp;
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  		xmlhttp=new XMLHttpRequest();
	  	}
		else{// code for IE6, IE5
	  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  	}
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    	if(xmlhttp.responseText != '0'){
		    		document.getElementById('parent_list').innerHTML = xmlhttp.responseText;
		    	}
		    }	
		  }
		xmlhttp.open("POST","<?=Yii::app()->baseUrl?>/users/getparents",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+val);


	}
	
	$(document).ready(function(){
		parents(<?=$model->user_id?>);
	});
	
</script>
