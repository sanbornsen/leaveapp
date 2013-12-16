<?php /* @var $this Controller */ 
if(!Yii::app()->user->isGuest){
	$user = Users::model()->find('user_name LIKE "'.Yii::app()->user->name.'"');
	if($user){
	if($user->changepass){
		$changepass = $user->changepass;
	}
	}	
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/datepicker.css" />
    
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-datepicker.js"></script>
	<?php Yii::app()->bootstrap->register(); ?>
</head>

<?php if(isset($changepass)):?>
	<body onload="changepass_modal()">
<?php else:?>
	<body>
<?php endif;?>

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a style="float:right" href="/leaveapp/index.php" class="brand">
				Leave Management
			</a>
			<ul id="yw2" class="nav">
				<li><a href="<?=Yii::app()->baseUrl?>/site/index">Home</a></li>
				<li><a href="<?=Yii::app()->baseUrl?>/site/page?view=about">About</a></li>
				<li><a href="<?=Yii::app()->baseUrl?>/site/contact">Contact</a></li>
				<?php if(!Yii::app()->user->isGuest):?>
					<li><a href="<?=Yii::app()->baseUrl?>/users">Users</a></li>
					<?php if(Yii::app()->user->name != "admin"):?>
						<li><a href="<?=Yii::app()->baseUrl?>/leave">Leaves</a></li>
					<?php endif;?>
				<?php endif;?>
				<?php if(Yii::app()->user->isGuest):?>
					<li><a href="<?=Yii::app()->baseUrl?>/site/login">Login</a></li>
				<?php  else: ?>
					<li><a href="<?=Yii::app()->baseUrl?>/site/logout">Logout (<?=Yii::app()->user->name?>)</a></li>
				<?php endif;?>
			</ul>
		</div>
	</div>
</div>
<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>
	<hr>
	<center>
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo 'NITMAS'; ?>
	</div><!-- footer -->
	</center>
</div><!-- page -->

</body>
</html>


<script>
// Script for date picker on the form
	if (top.location != location) {
    top.location.href = document.location.href ;
  	}
		$(function(){
			window.prettyPrint && prettyPrint();
			$('#dp1').datepicker({
				format: 'mm-dd-yyyy'
			});
			$('#dp2').datepicker();
			$('#dp3').datepicker();
			$('#dp3').datepicker();
			$('#dpYears').datepicker();
			$('#dpMonths').datepicker();
			
			
			var startDate = new Date(2012,1,20);
			var endDate = new Date(2012,1,25);
			$('#dp4').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() > endDate.valueOf()){
						$('#alert').show().find('strong').text('The start date can not be greater then the end date');
					} else {
						$('#alert').hide();
						startDate = new Date(ev.date);
						$('#startDate').text($('#dp4').data('date'));
					}
					$('#dp4').datepicker('hide');
				});
			$('#dp5').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() < startDate.valueOf()){
						$('#alert').show().find('strong').text('The end date can not be less then the start date');
					} else {
						$('#alert').hide();
						endDate = new Date(ev.date);
						$('#endDate').text($('#dp5').data('date'));
					}
					$('#dp5').datepicker('hide');
				});

        // disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#dpd1').datepicker({
          onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
          }
          checkin.hide();
          $('#dpd2')[0].focus();
        }).data('datepicker');
        
        var checkout = $('#dpd2').datepicker({
          onRender: function(date) {
            return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');
		});
		
		var dateofbirth = $('#dob').datepicker({format: 'yyyy-mm-dd'}).on('changeDate', function(ev) {
          //dateofbirth.hide();
        });
</script>


<div id="changepass" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 id="myModalLabel">Change your password.</h3>
	</div>
	<div class="modal-body">
		<input type='password' name='oldpass' id='oldpass' placeholder="Old Password"/> </br>
		<input type='password' name='newpass' id='newpass' placeholder="New Password"/> </br>
		<input type='password' name='newpass1' id='newpass1' placeholder="Retype new Password"/> </br> 
		<button class="btn btn-primary" onClick="changepass()">Change</button> 
		&nbsp&nbsp&nbsp&nbsp 
		<span id="loading_changepass"></span>
	</div>
	<div class="modal-footer">
		<span style="float:left" id="changepass_reply"></span>
	</div>
</div>

<script>
// function to open chnage password modal
function changepass_modal()
{
$('#changepass').modal();
}

// ajax to chnage password
function changepass()
{
document.getElementById('loading_changepass').innerHTML =	'<img src="<?=Yii::app()->baseUrl?>/images/loader.gif">';
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
    document.getElementById('loading_changepass').innerHTML = "";
	document.getElementById("changepass_reply").innerHTML=xmlhttp.responseText;
    if(xmlhttp.responseText == "<div class='alert alert-success'>Your password has been changed successfuly.</div>"){
	    document.getElementById("oldpass").value = "";
	    document.getElementById("newpass").value = "";
	    document.getElementById("newpass1").value = "";
    }
    else if(xmlhttp.responseText == "<div class='alert alert-error'>New Password didn't match.</div>"){
    	document.getElementById("newpass").value = "";
	    document.getElementById("newpass1").value = "";
    }
    else if(xmlhttp.responseText == "<div class='alert alert-error'>You have entered a wrong password.</div>"){
    	document.getElementById("oldpass").value = "";
    }
  	}
  }
var baseurl = '<?php echo Yii::app()->baseUrl; ?>';
var oldpass = encodeURIComponent(document.getElementById("oldpass").value);
var newpass = encodeURIComponent(document.getElementById("newpass").value);
var newpass1 = encodeURIComponent(document.getElementById("newpass1").value);
xmlhttp.open("GET",baseurl+"/users/changepass?oldpass="+oldpass+"&newpass="+newpass+"&newpass1="+newpass1,true);
xmlhttp.send();
}


</script>


<div id="asktocomment" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 id="myModalLabel">Ask someone for suggestion.</h3>
	</div>
	<div class="modal-body">
		<?php $posts = Position::model()->findAll();?>
		<select id="user_position_modal" name="Users[user_position]" onchange="javascript:usersbypost()">
			<option value="0">--------none----------</option>
			<?php foreach ($posts as $post):?>
					<option value="<?=$post->pos_id?>"><?=$post->pos_name?></option>
			<?php endforeach;?>
		</select>
		<select id="usersfrompos" name="Users[user_parent]">
				<option value="0">--------none----------</option>
		</select>
		<br>
		<button id="ask_comment" onclick="" class="btn btn-primary">Ask</button>
	</div>
	<div class="modal-footer">
		<span style="float:left" id="askcomment_reply"></span>
	</div>
	
</div>

<script>

	function ask_comment_modal(id){
		$('#asktocomment').modal();
		$('#ask_comment').attr("onclick","ask_comment("+id+")");
	}
	
	function ask_comment(id){
		var user = document.getElementById('usersfrompos').value;
		if(user == "0"){
			alert('Give an user');
		}
		else{
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
			    	if(xmlhttp.responseText == '1'){
			    		document.getElementById('askcomment_reply').innerHTML = "<div class='alert alert-success'>Please wait for this person to comment.</div>";
			    	}
			    	else{
			    		document.getElementById('askcomment_reply').innerHTML = "<div class='alert alert-error'>This person is already asked for comment.</div>";
			    	}
			    }	
			  }
			xmlhttp.open("POST","<?=Yii::app()->baseUrl?>/leave/askcomment",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("id="+id+"&user="+user);
		}
	}
	
	function usersbypost(){
		var val = document.getElementById('user_position_modal').value;
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
		    		document.getElementById('usersfrompos').innerHTML = xmlhttp.responseText;
		    	}
		    }	
		  }
		xmlhttp.open("POST","<?=Yii::app()->baseUrl?>/users/usersbypost",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id="+val);


	}
	
</script>




<div id="addcomment" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 id="myModalLabel">Ask someone for suggestion.</h3>
	</div>
	<div class="modal-body">
		<div id="comment_box" style="padding:10px;height:30px;width:450px;border: 1px solid; margin:10px 0px;" contenteditable="true"></div>
		<button id="add_comment" onclick="" class="btn btn-primary">Add Comment</button>
	</div>
	<div class="modal-footer">
		<span style="float:left" id="addcomment_reply"></span>
	</div>
</div>
<script>
	function comment_modal(id){
		$('#addcomment').modal();
		$('#add_comment').attr("onclick","add_comment("+id+")");
		//$('#comment_box').html = "";
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
			    		document.getElementById('comment_box').innerHTML = xmlhttp.responseText;
			    	}
			    }	
			  }
			xmlhttp.open("POST","<?=Yii::app()->baseUrl?>/leave/getcomment",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("id="+id);
	}
	
	
	function add_comment(id){
		var comment = document.getElementById('comment_box').innerHTML;
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
			    		document.getElementById('addcomment_reply').innerHTML = "<div class='alert alert-success'>Your comment is added.</div>";
			    		document.getElementById('comment_button_'+id).innerHTML = 'Edit Comment';
			    		document.getElementById('show_comment_'+id).innerHTML = xmlhttp.responseText; 
			    	}
			    }	
			  }
			xmlhttp.open("POST","<?=Yii::app()->baseUrl?>/leave/addcomment",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("id="+id+"&comment="+comment);
	}
</script>
