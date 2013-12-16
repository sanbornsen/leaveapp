<?php

class LeaveController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','accept','reject','myleave','askcomment','addcomment','getcomment'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Leave;
		$types = LeaveType::model()->findAll();
		$leave_types = CHtml::listData($types, 'leave_type_id', 'leave_type_name');
		//die(var_dump($leave_types));
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Leave']))
		{
			//die(var_dump($_POST));
			$current_user = Yii::app()->user->name;
			$user_id = Users::model()->getUserId($current_user);
			$parent = Users::model()->getParent($user_id);
			if($user_id){
				$model->user_id = $user_id;
				$model->leave_way = json_encode(array($parent=>'pending'));
			}
			else{
				$model->user_id = 0;
			}
			$_POST['Leave']['leave_from'] = date('Y-m-d',strtotime($_POST['Leave']['leave_from']));
			$_POST['Leave']['leave_to'] = date('Y-m-d',strtotime($_POST['Leave']['leave_to']));
			//$_POST['Leave']['applied_on'] = date('Y-m-d');
			$model->applied_on = date('Y-m-d');
			$model->attributes=$_POST['Leave'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->leave_id));
		}

		$this->render('create',array(
			'model'=>$model,
			'leave_types' => $leave_types,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Leave']))
		{
			$model->attributes=$_POST['Leave'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->leave_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$id = Users::model()->findIdByUsername(Yii::app()->user->name);
		$rawData=Leave::model()->findAllBySql('SELECT * FROM `leave` ORDER BY `leave`.`leave_id` DESC');
		$size = sizeof($rawData);
		for($i=0;$i<$size;$i++){
			$way = $rawData[$i]->leave_way;
			$comments = array();
			if($rawData[$i]->comment!="")
				$comments = json_decode($rawData[$i]->comment, TRUE);
			$arr = json_decode($way, TRUE);
			if(!array_key_exists($id, $arr) and !array_key_exists($id, $comments))
				unset($rawData[$i]);
		}
		//exit;
		$dataProvider=new CArrayDataProvider($rawData, array('keyField' =>'leave_id'));
		//var_dump($dataProvider->getData());
		//exit;
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	public function actionMyleave()
	{
		$id = Users::model()->findIdByUsername(Yii::app()->user->name);
		$rawData=Leave::model()->findAllBySql('SELECT * FROM `leave` WHERE `leave`.`user_id` = '.$id);
		$dataProvider=new CArrayDataProvider($rawData, array('keyField' =>'leave_id'));
		//var_dump($dataProvider->getData());
		//exit;
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Leave('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Leave']))
			$model->attributes=$_GET['Leave'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	
	public function actionAccept(){
		$leave_id = $_GET['leave_id'];
		$user_id = Users::model()->findIdByUsername(Yii::app()->user->name);
		$leave = Leave::model()->findByPk($leave_id);
		$way = json_decode($leave->leave_way,TRUE);
		if(array_key_exists($user_id, $way)){
			$way[$user_id] = "accepted";
			$leave->approved_by = $user_id;
			$leave->leave_way = json_encode($way);
			$leave->save(false);
			echo Leave::model()->leavestatus($leave_id);
		}
		
	}
	
	public function actionReject(){
		$leave_id = $_GET['leave_id'];
		$user_id = Users::model()->findIdByUsername(Yii::app()->user->name);
		$parent = Users::model()->getParent($user_id);
		$leave = Leave::model()->findByPk($leave_id);
		$way = json_decode($leave->leave_way,TRUE);
		if(array_key_exists($user_id, $way)){
			$way[$user_id] = "rejected";
			$leave->approved_by = 0;
			if($parent){
				$way[$parent] = "pending";
			}
			$leave->leave_way = json_encode($way);
			$leave->save(false);
			echo Leave::model()->leavestatus($leave_id);
		}
		
	}
	
	public function actionAskcomment(){
		$leave_id = $_POST['id'];
		$user = $_POST['user'];
		$current_user = Users::model()->findIdByUsername(Yii::app()->user->name);
		$leave = Leave::model()->findByPk($leave_id);
		$comments = array();
		if($leave->comment != ""){
			$comments = json_decode($leave->comment, TRUE);
		}
		if(!array_key_exists($user, $comments)){
			$comments[$user]['comment'] = "";
			$comments[$user]['user'] = $current_user;
			$leave->comment = json_encode($comments);
			$leave->save(FALSE);
			echo '1';
		}
		else{
			echo '0';
		}
		
	}
	
	
	public function actionAddcomment(){
		$leave_id = $_POST['id'];
		$user = Users::model()->findIdByUsername(Yii::app()->user->name);
		$leave = Leave::model()->findByPk($leave_id);
		$comments = array();
		if($leave->comment != ""){
			$comments = json_decode($leave->comment, TRUE);
		}
		if(array_key_exists($user, $comments)){
			$comments[$user]['comment'] = $_POST['comment'];
			$leave->comment = json_encode($comments);
			$leave->save(FALSE);
			echo Leave::model()->showcomment($leave_id);
		}
		else{
			echo '0';
		}
		
	}
	
	
	public function actionGetcomment(){
		$leave_id = $_POST['id'];
		$user = Users::model()->findIdByUsername(Yii::app()->user->name);
		$leave = Leave::model()->findByPk($leave_id);
		$comments = array();
		if($leave->comment != ""){
			$comments = json_decode($leave->comment, TRUE);
		}
		if(array_key_exists($user, $comments)){
			echo $comments[$user]['comment'];
		}
		else{
			echo '0';
		}
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Leave the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Leave::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Leave $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='leave-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	
}
