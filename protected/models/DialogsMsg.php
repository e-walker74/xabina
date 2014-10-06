<?php

/**
 * This is the model class for table "dialogs_msg".
 *
 * The followings are the available columns in table 'dialogs_msg':
 * @property integer $id
 * @property string $text
 * @property integer $add_time
 * @property string $user_id
 * @property integer $dialog_id
 * @property integer $edit_time
 * @property integer $delete_time
 * @property varchar $for
 * @property integer $created_at
 * @property integer $updated_at
 *
 * The followings are the available model relations:
 * @property DialogsCard[] $dialogsCards
 * @property DialogsFiles[] $dialogsFiles
 * @property Users $user
 * @property DialogsList $dialog
 * @property DialogsMsgToUser[] $dialogsMsgToUsers
 */
class DialogsMsg extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dialogs_msg';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('add_time, user_id, dialog_id', 'required'),
			//array('text, add_time, user_id, dialog_id, edit_time, delete_time, for, created_at, updated_at', 'required'),
			array('add_time, dialog_id, edit_time, delete_time, created_at, updated_at', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('for', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, text, add_time, user_id, dialog_id, edit_time, delete_time, for, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'dialogsCards' => array(self::HAS_MANY, 'DialogsCard', 'msg_id'),
			'dialogsFiles' => array(self::HAS_MANY, 'DialogsFiles', 'msg_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'dialog' => array(self::BELONGS_TO, 'DialogsList', 'dialog_id'),
			'dialogsMsgToUsers' => array(self::HAS_MANY, 'DialogsMsgToUser', 'msg_id'),
		);
	}

        /*
         * get block with one msg (full view)
         */
	public function getOneMsg($msg_id, $for)
	{
            $user_id = intval(Yii::app()->user->id); // you id
            $time = time();
            $notRead = '';
            /*
             * find this msg
             */
            if ($msg_id) { // if have param msg_id
                $msg = DialogsMsg::model()->find(
                            array(
                                'condition' => "t.id=:msg_id", 
                                'params' => array(":msg_id"=>$msg_id)
                            ));
                
                
                $cards = DialogsCard::model()->findAll(
                            array(
                                'condition' => "t.msg_id=:msg_id", 
                                'params' => array(":msg_id"=>$msg_id)
                            ));
                $contactList = '';
                if ($cards) {
                    foreach ($cards as $contact) {
                        $book = Users_Contacts::model()->find(
                                        array(
                                            'condition' => "id='".$contact->book_id."' AND user_id=".$contact->user_id,  
                                        ));
                        if ($book) {
                            $bInfo = $book->hint;
                            $bName = ($book->first_name ? $book->first_name.' ' : '').($book->last_name ? $book->last_name : '');
                            if (!$bName AND $book->fullname) 
                                $bName = $book->fullname;
                            else if (!$bName)
                                $bName = 'NoName';
                            $bImg = $book->photo;
                            if (!$bImg)
                                $bImg = '/images/contact_no_foto.png';
                            else
                                $bImg = '/images/contacts/'.$book->user_id.'/'.$book->id.'/'.$bImg;
                            if ($contactList)
                                $contactList .= '<li><div class="cImg"><img src="'.$bImg.'" alt="" width="40"/></div><div class="cName">'.$bName.'</div><div class="cInfo">'.$bInfo.'</div><div class="hide cId">'.$book->id.'</div><div class="hide uId">'.$book->user_id.'</div></li>';
                            else
                                $contactList = '<ol class="fromBookList"><li><div class="cImg"><img src="'.$bImg.'" alt="" width="40"/></div><div class="cName">'.$bName.'</div><div class="cInfo">'.$bInfo.'</div><div class="hide cId">'.$book->id.'</div><div class="hide uId">'.$book->user_id.'</div></li>';
                        }
                    }
                    if ($contactList)
                        $contactList .= '</ol>';
                }
                $deleteUser = '';
                $addUser = '';
                if (substr_count($msg->text, '{system}deteleUser_')) {
                    $deleteUser = intval(str_replace('{system}deteleUser_', '', $msg->text));                    
                }
                if (substr_count($msg->text, '{system}addUser_')) {
                    $addUser = intval(str_replace('{system}addUser_', '', $msg->text));                    
                }
                $msg_text = '';
                $msg_user_id = $msg->user_id;
                if ($deleteUser || $addUser) {       
                    if ($addUser)
                        $deleteUser = $addUser;
                    if ($msg->user) {
                        
                        if ($msg->user->id==$user_id) {
                            $msg->user->first_name = '';
                            $msg->user->last_name = 'You';
                        } else {
                            $userContact = Users_Contacts::model()->find(
                                        array(
                                            'condition' => "xabina_id='".$msg->user->login."' AND user_id=".$user_id,  
                                        ));
                            if ($userContact) {
                                if ($userContact->fullname) {
                                    $msg->user->last_name = '';
                                    $msg->user->first_name = $userContact->fullname;
                                }
                                if ($userContact->photo)
                                    $msg->user->photo = '/images/contacts/'.$user_id.'/'.$userContact->id.'/'.$userContact->photo;
                            }
                        }
                    }
                    $msg_user = ($msg->user->first_name ? $msg->user->first_name.' ' : '').($msg->user->last_name ? $msg->user->last_name : '');
                    
                    
            
                    $userDel = Users::model()->find(
                                array(
                                    'condition' => "id=".$deleteUser,  
                                ));
                    $deleteUserText = '';
                    if ($userDel) {
                        $userDelDialog = DialogsUsers::model()->find(
                                    array(
                                        'condition' => "user_id=".$userDel->id." AND dialog_id=".$msg->dialog_id,  
                                    ));
                        if ($userDel AND $userDel->id!=$user_id) {

                            $userContact = Users_Contacts::model()->find(
                                        array(
                                            'condition' => "xabina_id='".$userDel->login."' AND user_id=".$user_id,  
                                        ));
                            if ($userContact) {
                                if ($userDel->last_name OR $userDel->first_name) {
                                    $userDel->last_name = $userContact->last_name;
                                    $userDel->first_name = $userContact->first_name;
                                } else if ($userContact->fullname) {
                                    $userDel->last_name = '';
                                    $userDel->first_name = $userContact->fullname;
                                }
                            }
                            $deleteUserText = ($userDel->first_name ? $userDel->first_name.' ' : '').($userDel->last_name ? $userDel->last_name : '');
                        } else if ($userDel->id==$user_id) {
                            $userDel->first_name = '';
                            $userDel->last_name = 'You';
                            $deleteUserText = ($userDel->first_name ? $userDel->first_name.' ' : '').($userDel->last_name ? $userDel->last_name : '');
                        }
                        if ($addUser) {
                                $msg_text = '<b>'.$msg_user.'</b> added <b>'.$deleteUserText.'</b> in dialogue.';
                            } else {
                            if ($userDel->last_name=='You' AND $deleteUserText) {
                                $msg_text = '<b>'.$msg_user.'</b> removed <b>'.$deleteUserText.'</b> from dialogue.';
                            } else if ($deleteUserText) {
                                if ($userDelDialog){
                                    if ($userDelDialog->delete_time>0)
                                        $msg_text = '<b>'.$msg_user.'</b> removed <b>'.$deleteUserText.'</b> from dialogue. You can <a href="/dialogs/add/?ids='.$userDel->id.'&dialog_id='.$msg->dialog_id.'&fromBook=1">return the user</a> to dialogue';
                                    else
                                        $msg_text = '<b>'.$msg_user.'</b> removed <b>'.$deleteUserText.'</b> from dialogue.';
                                }
                            }else
                                $msg_text = '<b>'.$msg_user.'</b> left dialogue';
                        }
                    }
                }
                $forWho = $msg->for;
                if ($msg) { // if msg exist
                    $allUsers = $msg->dialog->allUsers();
                    /*
                     * status msg - waiting or read
                     */            
                    $status = '';
                    $msgStatus = '';
                    $msgToUser = DialogsMsgToUser::model()->find(
                                                    array(
                                                        'condition' => "t.user_id=:user_id  AND t.msg_id=".$msg_id, 
                                                        'params' => array(":user_id"=>$user_id), 
                                                    ));  
                    if ($msg->user_id == $user_id) { //if author = you (anybody read)
                        $status = DialogsMsgToUser::model()->find(
                                                        array(
                                                            'select' => 'id',
                                                            'condition' => "t.user_id!=:user_id AND (t.status=1 OR t.status=3) AND t.msg_id=".$msg_id, 
                                                            'params' => array(":user_id"=>$user_id)
                                                        ));  
                        if ($status)
                            $msgStatus = 1;
                    } else { //if author != you (you read msg or not)
                        if ($msgToUser) {
                            if ($msgToUser->status==2 || $msgToUser->status==3) {
                                $msgToUser->status = 1;
                                $notRead = 1;
                                
                                $dialogUsers = DialogsUsers::model()->findAll(
                                                array(
                                                    'condition' => "t.user_id!=:user_id AND t.dialog_id=".$msgToUser->dialog_id, 
                                                    'params' => array(":user_id"=>$user_id), 
                                                ));
                                if ($dialogUsers) {
                                    foreach ($dialogUsers as $usr) {
                                        $toComet = new DialogsComet;
                                        $toComet->add_time = $time;
                                        $toComet->type = 'readMsg';
                                        $toComet->type_id = $msgToUser->msg_id;
                                        $toComet->author_id = $user_id;
                                        $toComet->user_id = $usr->user_id;
                                        $toComet->save();
                                        unset($toComet);
                                    }
                                }
                            }
                            $msgToUser->save();
                            $msgStatus = $msgToUser->status;
                        }
                    }            
                    if ($msg->user_id == $user_id) {
                        if ($msgStatus=='1') 
                            $msgStatus = 'sent'; 
                        else 
                            $msgStatus = 'waiting';
                    }
                   /*
                    * write author information
                    */
                    $author = '';
                    $msgAction = '';
                    $cssClass = '';
                    $msg_color = 'white';
                    
                    $forMsg = '';
                    if (count($allUsers)>2) {
                        if ($forWho=='me') {
                            $forMsg = '<span class="drdn-cont"><a href="#" class="button-mini lock" data-toggle="dropdown"></a></span>';
                        } else  if ($forWho=='group') {

                            $msgToUsers = DialogsMsgToUser::model()->findAll(
                                                            array(
                                                                'condition' => "t.user_id!=".$msg->user_id." AND t.msg_id=".$msg->id, 
                                                            ));  
                            if ($msgToUsers) {
                                $people = '';
                                foreach ($msgToUsers as $mtu) {
                                    if ($mtu->user) {
                                        $userContact = Users_Contacts::model()->find(
                                                    array(
                                                        'condition' => "xabina_id='".$mtu->user->login."' AND user_id=".$user_id,  
                                                    ));
                                        if ($userContact) {
                                            if ($userContact->fullname) {
                                                $mtu->user->last_name = '';
                                                $mtu->user->first_name = $userContact->fullname;
                                            }
                                            if ($userContact->photo)
                                                $mtu->user->photo = '/images/contacts/'.$user_id.'/'.$userContact->id.'/'.$userContact->photo;
                                        }
                                        if ($mtu->user->id==$user_id)  {
                                            $mtu->user->last_name = '';
                                            $mtu->user->first_name = "<b>You</b>";
                                        }
                                    }          
                                    $people .= '<li class="clearfix"><a href="#" class="action none">'.($mtu->user->first_name ? $mtu->user->first_name.' ' : '').($mtu->user->last_name ? $mtu->user->last_name : '').'</a></li>';
                                }              
                            }
                            $forMsg = '<span class="drdn-cont"><a href="#" class="button-mini group" data-toggle="dropdown"></a><ul class="dropdown-menu contact-select-dropdown list-actions-dropdown list-unstyled" role="menu"><li class="arr"></li>'.$people.'</ul></span>';
                        } else {
                            $forMsg = '<span class="drdn-cont"><a href="#" class="button-mini planet" data-toggle="dropdown"></a></span>';
                        }  
                    }
                    if ($msg->user_id==$user_id) {
                        $author = 'You';
                        
                                                /*<!--<li class="clearfix">
                                                    <a href="#" class="action download">Скачать файл</a>
                                                </li>
                                                <li class="clearfix">
                                                    <a href="#" class="action edit">Редактировать</a>
                                                </li>-->*/
                        $actions = '';
                        if ($msgStatus!='sent') {
                            $actions = '<a href="#" class="action edit" onClick="editMsg(\''.$msg->id.'\');return false;">Редактировать</a>';
                            $actions .= '<a href="#" class="action delete" onClick="deleteMsg(\''.$msg->id.'\');return false;">Удалить</a>';
                        }
                        if ($actions)
                            $msgAction = $forMsg.'<span class="drdn-cont" ><a href="#" class="button-mini plus-contour" data-toggle="dropdown"></a><ul class="dropdown-menu contact-select-dropdown list-actions-dropdown list-unstyled" role="menu" ><li class="arr"></li><li class="clearfix">'.$actions.'</li></ul></span>';
                        else
                            $msgAction = $forMsg;
                        
                        $activityState = Yii::app()->user->getActivityStatus($user_id); 
                        if ($activityState == Users::USER_ACTIVITY_STATUS_ONLINE){
                            $cssClass = 'ok';
                        } elseif ($activityState == Users::USER_ACTIVITY_STATUS_BUSY) {
                            $cssClass = 'time';
                        } else {
                            $cssClass = 'err';
                        }                        
                    } else {
                        $msg_color = 'pink';
                        
                        $userContact = '';
                        if ($msg->user) {
                            $userContact = Users_Contacts::model()->find(
                                        array(
                                            'condition' => "xabina_id='".$msg->user->login."' AND user_id=".$user_id,  
                                        ));
                            if ($userContact) {
                                if ($userContact->fullname) {
                                    $msg->user->last_name = '';
                                    $msg->user->first_name = $userContact->fullname;
                                }
                                if ($userContact->photo)
                                    $msg->user->photo = '/images/contacts/'.$user_id.'/'.$userContact->id.'/'.$userContact->photo;
                            }
                        }
                        
                        $author = ($msg->user->first_name ? $msg->user->first_name.' ' : '').($msg->user->last_name ? $msg->user->last_name : '');
                        
                        
                        $activityState = Yii::app()->user->getActivityStatus($msg->user->id); 
                        if ($activityState == Users::USER_ACTIVITY_STATUS_ONLINE){
                            $cssClass = 'ok';
                        } elseif ($activityState == Users::USER_ACTIVITY_STATUS_BUSY) {
                            $cssClass = 'time';
                        } else {
                            $cssClass = 'err';
                        }
                        $msgAction = $forMsg.'<span class="drdn-cont" ><a href="#" class="button-mini plus-contour" data-toggle="dropdown"></a><ul class="dropdown-menu contact-select-dropdown list-actions-dropdown list-unstyled" role="menu" ><li class="arr"></li><li class="clearfix"><a href="#" class="action mark" onClick="markMsg(\''.$msg->id.'\');return false;">Пометить как непрочитанное</a></li></ul></span>';
                    }
                    $defColor = '';
                    if ($notRead) {
                        $defColor = $msg_color;
                        $msg_color = 'grey';
                        if ($for == 'ajax') 
                            $msg_color = $defColor;
                    }
                    /*
                     * write msg box view
                     */
                    $photo = '';
                    if ($deleteUser) {
                        $photo = '<img src="/images/dialogues_photo_xabina.png" width="37px" height="37px" alt=""/>';
                    } else {
                        if ($msg->user->photo) {
                            if (substr_count($msg->user->photo, '/images/'))
                                $photo = '<img src="'.$msg->user->photo.'" width="37px" height="37px" alt=""/>'; 
                            else
                                $photo = '<img src="/images/users/'.$msg->user->id.'/'.$msg->user->photo.'" width="37px" height="37px" alt=""/>';
                        } else
                            $photo = '<img src="/images/dialogues_nophoto.png" width="37px" height="37px" alt=""/>';
                    }
                    $group = '';
                    $color = '';
                    if ($msgToUser->group!='grey' AND $msgToUser->group!='0') {
                        $color = $msgToUser->group;
                        if ($color)
                            $group = $color.'-border';
                    }
                    if (!$color) {
                        $color = 'grey';
                    }
                    if ($author=='You')
                        $author_you = 'author_you';
                    else
                        $author_you = 'author_not_you';
                    
                    if ($deleteUser){
                        $author = 'Xabina';
                    }
                    if ($msgStatus)
                        $msgStatusView = '<div class="message-status '.$msgStatus.'">';
                    $output = '<li id="msg_'.$msg->id.'" class="msg_li" onMouseOver="markMsgRead($(this));" style="overflow:visible"><div class="interlocutor-photo pull-left">'.$photo.'</div><div class="message-container '.$msg_color.' '.$group.'" rel="'.$defColor.'"><div class="message-arr"></div><div class="message-top"><div class="interlocutor-name '.$author_you.'">'.$author.'</div><div class="meassage-datetime">'.date('d.m.Y H:i', $msg->add_time).'</div>'.$msgStatusView.'</div><div class="message-actions-cont">'.$msgAction.'<span  class="drdn-cont" ><a href="#" class="button-mini category '.$color.'" data-toggle="dropdown" ></a><ul class="dropdown-menu contact-select-dropdown list-categories-dropdown list-unstyled" role="menu" ><li class="arr"></li><li class="clearfix"><a href="#" class="category grey" onClick="setMsgColor(\'grey\',\''.$msg->id.'\');return false;">Clear all Categories</a></li><li class="clearfix"><a href="#" class="category blue" onClick="setMsgColor(\'blue\',\''.$msg->id.'\');return false;">Blue Category</a></li><li class="clearfix"><a href="#" class="category green" onClick="setMsgColor(\'green\',\''.$msg->id.'\');return false;">Green Category</a></li><li class="clearfix"><a href="#" class="category red" onClick="setMsgColor(\'red\',\''.$msg->id.'\');return false;">Red Category</a></li><li class="clearfix"><a href="#" class="category yellow" onClick="setMsgColor(\'yellow\',\''.$msg->id.'\');return false;">Yellow Category</a></li></ul></span></div></div><div class="message-text">';
                    if ($msg_text)
                        $outputCenter = str_replace("\n", "<br/>", str_replace("\r", "<br/>", htmlspecialchars_decode($msg_text)));
                    else {
                        $outputCenter = str_replace("\n", "<br/>", str_replace("\r", "<br/>", htmlspecialchars_decode($msg->text)));
                    }
                    $outputEnd = '</div>'.$contactList.'<div class="clearfix"></div></div></li>';

                    if ($for == 'ajax') // view for ajax only
                        $output = str_replace('"', '\"', str_replace("\n", "", str_replace("\r", "<br/>", $output)).$outputCenter.str_replace("\n", "", str_replace("\r", "", $outputEnd)));
                    else // view for other
                        $output = $output.$outputCenter.$outputEnd;
                    $checkCnt = '';
                    if ($deleteUser || $addUser)
                        $checkCnt = $msg->dialog_id;
                    $output = array("output" => $output, "check" => $checkCnt);
                    
                    return $output;
                }
            }
	}
        
        
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => 'Text',
			'add_time' => 'Add Time',
			'user_id' => 'User',
			'dialog_id' => 'Dialog',
			'edit_time' => 'Edit Time',
			'delete_time' => 'Delete Time',
			'for' => 'For',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('dialog_id',$this->dialog_id);
		$criteria->compare('edit_time',$this->edit_time);
		$criteria->compare('delete_time',$this->delete_time);
		$criteria->compare('for',$this->for,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DialogsMsg the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
