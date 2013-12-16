<?php
/* @var $this LeaveController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Leaves',
);

$this->menu=array(
	array('label'=>'Create Leave', 'url'=>array('create')),
	array('label'=>'My Leave', 'url'=>array('myleave')),
	array('label'=>'Manage Leave', 'url'=>array('admin')),
);
?>

<h1>Leaves</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>


<script>
	function leave_accept(id){
		var xmlhttp;
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    	if(xmlhttp.responseText!=""){
			    	document.getElementById("leavestatus_"+id).innerHTML = xmlhttp.responseText;
			    	$('#leave_action_'+id).fadeOut('slow');
			    }
		  	}
		  }
		xmlhttp.open("GET","<?=Yii::app()->baseUrl?>/leave/accept?leave_id="+id,true);
		xmlhttp.send();
	}
	
	function leave_reject(id){
		var xmlhttp;
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
			    if(xmlhttp.responseText!=""){
			    	document.getElementById("leavestatus_"+id).innerHTML = xmlhttp.responseText;
			    	$('#leave_action_'+id).fadeOut('slow');
			    }
		  	}
		  }
		xmlhttp.open("GET","<?=Yii::app()->baseUrl?>/leave/reject?leave_id="+id,true);
		xmlhttp.send();
	}
	
</script>