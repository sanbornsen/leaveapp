<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $user_id
 * @property string $user_name
 * @property string $password
 * @property string $f_name
 * @property string $l_name
 * @property string $user_email
 * @property string $user_dob
 * @property string $user_position
 * @property integer $user_parent
 * @property string $user_status
 * @property integer $user_salary
 * @property string $join_date
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_name, f_name, l_name, user_email, user_dob, user_position, user_salary', 'required'),
			array('user_parent, user_salary', 'numerical', 'integerOnly'=>true),
			array('user_name, f_name, l_name, user_email, user_position', 'length', 'max'=>255),
			array('user_name', 'unique', 'attributeName'=> 'user_name', 'caseSensitive' => 'false'),
			array('user_email', 'unique', 'attributeName'=> 'user_email', 'caseSensitive' => 'false'),
			array('password', 'length', 'max'=>50),
			array('user_status', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, user_name, password, f_name, l_name, user_email, user_dob, user_position, user_parent, user_status, user_salary, join_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'user_name' => 'User Name',
			'password' => 'Password',
			'f_name' => 'First Name',
			'l_name' => 'Last Name',
			'user_email' => 'User Email',
			'user_dob' => 'User Dob',
			'user_position' => 'User Position',
			'user_parent' => 'User Parent',
			'user_status' => 'User Status',
			'user_salary' => 'User Salary',
			'join_date' => 'Join Date',
		);
	}
	
	public function isAdmin($name){
		if($name == "admin"){
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('f_name',$this->f_name,true);
		$criteria->compare('l_name',$this->l_name,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_dob',$this->user_dob,true);
		$criteria->compare('user_position',$this->user_position,true);
		$criteria->compare('user_parent',$this->user_parent);
		$criteria->compare('user_status',$this->user_status,true);
		$criteria->compare('user_salary',$this->user_salary);
		$criteria->compare('join_date',$this->join_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function getNameById($id){
		$user = Users::model()->findByPk($id);
		if($user){
			$post = Position::model()->getPosById($user->user_position);
			return ucwords($user->f_name." ".$user->l_name)." (".$post.")";
		}
		else{
			return "No parent";
		}
	}

	public function getUserId($name){
		$user = $this->find('user_name LIKE "'.trim($name).'"');
		if($user){
			return $user->user_id;
		}
		else{
			return false;
		}
	}
	
	public function findIdByUsername($username){
		$user = $this->find('user_name LIKE "'.$username.'"');
		return $user->user_id;
	}
	
	public function findNameByUserid($id){
		//die(var_dump($id));
		$user = Users::model()->findByPk($id);
		$name = "<a href='".Yii::app()->baseUrl."/users/".$id."'>".ucwords($user->f_name)." ".ucwords($user->l_name)."</a>";
		return $name;
		}

	public function getParent($id){
		$user = $this->findByPk($id);
		if($user){
			return $user->user_parent;
		}
		else{
			return 0;
		}
	}
	
	public function findByUsername($username){
		return $this->find('user_name LIKE "'.$username.'"');
	}
}
