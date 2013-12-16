<?php

/**
 * This is the model class for table "leave".
 *
 * The followings are the available columns in table 'leave':
 * @property integer $leave_id
 * @property integer $user_id
 * @property string $leave_from
 * @property string $leave_to
 * @property string $leave_reason
 * @property integer $approved_by
 * @property string $applied_on
 * @property string $approved_on
 * @property string $leave_way
 * @property integer $leave_type
 */
class Leave extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Leave the static model class
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
		return 'leave';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('leave_from, leave_to, leave_reason, leave_type', 'required'),
			array('user_id, approved_by, leave_type', 'numerical', 'integerOnly'=>true),
			array('leave_from, leave_to', 'length', 'max'=>10),
			array('approved_on', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('leave_id, user_id, leave_from, leave_to, leave_reason, approved_by, applied_on, approved_on, leave_way, leave_type', 'safe', 'on'=>'search'),
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
			'leave_id' => 'Leave',
			'user_id' => 'User',
			'leave_from' => 'Leave From',
			'leave_to' => 'Leave To',
			'leave_reason' => 'Application Letter',
			'approved_by' => 'Approved By',
			'applied_on' => 'Applied On',
			'approved_on' => 'Approved On',
			'leave_way' => 'Leave Way',
			'leave_type' => 'Leave Type',
		);
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

		$criteria->compare('leave_id',$this->leave_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('leave_from',$this->leave_from,true);
		$criteria->compare('leave_to',$this->leave_to,true);
		$criteria->compare('leave_reason',$this->leave_reason,true);
		$criteria->compare('approved_by',$this->approved_by);
		$criteria->compare('applied_on',$this->applied_on,true);
		$criteria->compare('approved_on',$this->approved_on,true);
		$criteria->compare('leave_way',$this->leave_way,true);
		$criteria->compare('leave_type',$this->leave_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function leavestatus($id){
		$leave = Leave::model()->findByPk($id);
		$parents = json_decode($leave->leave_way,TRUE);
		$htm = '';
		foreach($parents as $key => $value):
			if($key == $leave->approved_by):
				$htm .= '<div class="alert alert-success">'.Users::model()->getNameById($key).' : Approved </div>';
			elseif($value == 'pending'):
				$htm .= '<div class="alert">'.Users::model()->getNameById($key).' : Pending </div>';
			elseif($value == 'rejected'):
				$htm .= '<div class="alert alert-error">'.Users::model()->getNameById($key).' : Rejected </div>';
			endif;
		endforeach;
		return $htm;
	}
	
	public function showcomment($id){
		$leave = Leave::model()->findByPk($id);
		$comments = array();
		if($leave->comment != "")
			$comments = json_decode($leave->comment,TRUE);
		$htm = '';
		foreach($comments as $key => $comment){
			if($comment['comment']!=""){
				$htm .= '<p style="margin:10px 0px"><strong>'.Users::model()->findNameByUserid($key).' </strong><span class="small-text">(requested by '.Users::model()->findNameByUserid($comment['user']).')</span> says  :<br> '.$comment['comment'].'</p>';
			}
		}
		echo $htm;
	}
		
}
