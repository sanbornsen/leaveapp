<?php

class UsersController extends Controller
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
				'actions'=>array('index','view','changepass','usersbypost','views'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','getparents','create','update'),
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
	
	
	public function actionViews($user)
	{
		$model = Users::model()->findBySql("SELECT * FROM users WHERE user_name LIKE '".$user."'");
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$_POST['Users']['password'] = md5($_POST['Users']['user_name']);
			$model->attributes=$_POST['Users'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	public function actionGetparents(){
		//die(var_dump($_POST));
		$id = $_POST['id'];
		$parent_pos = Position::model()->findByPk($id);
		$parent_pos = $parent_pos->pos_parent;
		$users = Users::model()->findAll('user_position = '.$parent_pos);
		$html = '<option value="0">--------none----------</option>';
		foreach ($users as $user) {
			if(isset($usr) && $usr->user_parent == $user->user_id){
				$html .= '<option value="'.$user->user_id.'" selected>'.ucwords($user->f_name).' '.ucwords($user->l_name).'</option>';
			}
			else {
				$html .= '<option value="'.$user->user_id.'">'.ucwords($user->f_name).' '.ucwords($user->l_name).'</option>';
			}			
		}
		echo $html;
	}
	
	
	public function actionUsersbypost(){
		//die(var_dump($_POST));
		$id = $_POST['id'];
		$parent_pos = Position::model()->findByPk($id);
		$parent_pos = $parent_pos->pos_id;
		$users = Users::model()->findAll('user_position = '.$parent_pos);
		$html = '<option value="0">--------none----------</option>';
		foreach ($users as $user) {
			if(isset($usr) && $usr->user_parent == $user->user_id){
				$html .= '<option value="'.$user->user_id.'" selected>'.ucwords($user->f_name).' '.ucwords($user->l_name).'</option>';
			}
			else {
				$html .= '<option value="'.$user->user_id.'">'.ucwords($user->f_name).' '.ucwords($user->l_name).'</option>';
			}			
		}
		echo $html;
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

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
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
		$dataProvider=new CActiveDataProvider('Users');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Chnage password
	 */
	 
	 public function actionChangepass(){
		//die(var_dump($_GET['oldpass']."  ".$_GET['newpass']."  ".$_GET['newpass1']));
		$user = Users::model()->findByUsername(Yii::app()->user->getId());
		if($_GET['oldpass'] != "" && $_GET['newpass'] && $_GET['newpass1']){
			if(strlen($_GET['newpass'])>=8){
			if(md5($_GET['oldpass'])==$user->password){
				if($_GET['newpass'] == $_GET['newpass1']){
					$user->password = md5($_GET['newpass']);
					$user->changepass = 0;
					$user->save('false');
					echo "<div class='alert alert-success'>Your password has been changed successfuly.</div>";
				}
				else{
					echo "<div class='alert alert-error'>New Password didn't match.</div>";
				}
			}
			else{
				echo "<div class='alert alert-error'>You have entered a wrong password.</div>";
			}
			}
			else{
				echo "<div class='alert alert-error'>Password is too short! Need atleast 8 dot.</div>";
			}
		}
		else{
			echo "<div class='alert alert-error'>Please enter some value.</div>";
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
