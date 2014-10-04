<?php

/**
 * This is the model class for table "dialogs_list".
 *
 * The followings are the available columns in table 'dialogs_list':
 * @property integer $id
 * @property string $type
 * @property integer $type_id
 * @property string $type_url
 * @property string $user_id
 * @property integer $add_time
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property DialogsMsg[] $dialogsMsgs
 * @property DialogsMsgToUser[] $dialogsMsgToUsers
 * @property DialogsUsers[] $dialogsUsers
 */
class DialogsList extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dialogs_list';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, add_time', 'required'),
			//array('type, type_id, type_url, user_id, add_time, created_at, updated_at', 'required'),
			array('type_id, add_time, created_at, updated_at', 'numerical', 'integerOnly'=>true),
			array('type, type_url, name', 'length', 'max'=>255),
			array('user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type, type_id, type_url, user_id, add_time, name, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'dialogsMsgs' => array(self::HAS_MANY, 'DialogsMsg', 'dialog_id'),
			'dialogsMsgToUsers' => array(self::HAS_MANY, 'DialogsMsgToUser', 'dialog_id'),
			'dialogsUsers' => array(self::HAS_MANY, 'DialogsUsers', 'dialog_id'),
		);
	}

	public function lastMsgToUser($user_id)
	{
            
                $dialogUser = DialogsUsers::model()->find(
                                array(
                                    'condition' => "t.user_id=:user_id AND t.dialog_id=".$this->id, 
                                    'params' => array(":user_id"=>$user_id)
                                ));
                if ($dialogUser)
                    return DialogsMsgToUser::model()->find(
                                array(
                                    'condition' => "t.user_id=:user_id AND t.dialog_id=:dialog_id",// AND t.add_time>".$dialogUser->delete_last_time, 
                                    'params' => array(":user_id"=>$user_id, ":dialog_id" => $this->id), 
                                    'order' => 'add_time DESC', 
                               ));
	}

	public function allUsers()
	{
            $user_id = intval(Yii::app()->user->id);
            $users_id = DialogsUsers::model()->findAll(
                        array(
                            'select' => 'user_id, delete_time',
                            'condition' => "t.dialog_id=:dialog_id",// AND delete_time='0'", 
                            'params' => array(":dialog_id" => $this->id), 
                            'order' => 'add_time DESC', 
                        ));
            if ($users_id) {
                $i = 0;
                foreach ($users_id as $key => $id) {
                    $user = Users::model()->find(
                                array(
                                    'condition' => "id=".$id->user_id,  
                                ));
                    $userContact = '';
                    if ($user) {
                        $userContact = Users_Contacts::model()->find(
                                    array(
                                        'condition' => "t.xabina_id='".$user->login."' AND t.user_id=".$user_id,  
                                    ));
                        if ($userContact) {
                            //echo $user->login.'='.$userContact->xabina_id.' '.$userContact->fullname.'<br/>';
                            if ($userContact->fullname) {
                                $user->last_name = '';
                                $user->first_name = $userContact->fullname;
                            }
                            if ($userContact->photo)
                                $user->photo = '/images/contacts/'.$user_id.'/'.$userContact->id.'/'.$userContact->photo;
                        }
                    }
                    $users[$i] = $user;
                    $i++;
                }
            }
            return $users;
	}
	public function allUsersActive()
	{
            $user_id = intval(Yii::app()->user->id);
            $users_id = DialogsUsers::model()->findAll(
                        array(
                            'select' => 'user_id, delete_time',
                            'condition' => "t.dialog_id=:dialog_id AND delete_time='0'", 
                            'params' => array(":dialog_id" => $this->id), 
                            'order' => 'add_time DESC', 
                        ));
            if ($users_id) {
                $i = 0;
                foreach ($users_id as $key => $id) {
                    $user = Users::model()->find(
                                array(
                                    'condition' => "id=".$id->user_id,  
                                ));
                    $userContact = '';
                    if ($user) {
                        $userContact = Users_Contacts::model()->find(
                                    array(
                                        'condition' => "t.xabina_id='".$user->login."' AND t.user_id=".$user_id,  
                                    ));
                        if ($userContact) {
                            //echo $user->login.'='.$userContact->xabina_id.' '.$userContact->fullname.'<br/>';
                            if ($userContact->fullname) {
                                $user->last_name = '';
                                $user->first_name = $userContact->fullname;
                            }
                            if ($userContact->photo)
                                $user->photo = '/images/contacts/'.$user_id.'/'.$userContact->id.'/'.$userContact->photo;
                        }
                    }
                    $users[$i] = $user;
                    $i++;
                }
            }
            return $users;
	}
        


        /*
         * get name of dialog $dialog_id
         * return name
         */
        public function getOneDialog () {//$for
            $user_id = intval(Yii::app()->user->id);
            $out = '';
            $dialogUser = DialogsUsers::model()->find(
                             array(
                                 'condition' => "t.user_id=".$user_id." AND t.delete_time='0' AND t.dialog_id=".$this->id, 
                             ));            
            if ($dialogUser) {
                $lastMsgToUser = '';
                $lastMsg = '';

                $dialogTime = $dialogUser->add_time;

                $lastMsgToUser = $this->lastMsgToUser($user_id);

                if (!$dialogName=$dialogUser->name) {
                    if (!$dialogName = $this->name) {
                        $dialogName = $this->getName($this->id);
                    }
                } 
                
                if ($lastMsgToUser) {
                    $dialogTime = $lastMsgToUser->msg->add_time;
                    $lastMsg = $lastMsgToUser->msg;      
                }
                $sql = 'SELECT COUNT(*) as cnt FROM dialogs_msg_to_user WHERE user_id='.$user_id.' AND dialog_id='.$this->id.' AND status!=1';// AND add_time>'.$dialogUser->delete_last_time;
                $connection=Yii::app()->db;
                $command = $connection->createCommand($sql);
                $cnt = $command->queryAll();

                if (!$cnt[0]['cnt'])
                    $cnt[0]['cnt'] = 0;
                $dialogs[$dialogTime]['cnt'] = $cnt[0]['cnt'];

                $dialogs[$dialogTime]['dialog'] = $this;
                $dialogs[$dialogTime]['msg'] = $lastMsg;
                $msg = $dialogs[$dialogTime]['msg'];
                $dialogs[$dialogTime]['users'] = $this->allUsers();
                $dialogs[$dialogTime]['usersActive'] = $this->allUsersActive();
                
                if ($lastMsg) {
                    $userContact = '';
                    if ($lastMsg->user) {
                        $userContact = Users_Contacts::model()->find(
                                    array(
                                        'condition' => "xabina_id='".$lastMsg->user->login."' AND user_id=".$user_id,  
                                    ));
                        if ($userContact) {
                            if ($userContact->fullname) {
                                if (count($dialogs[$dialogTime]['users'])>2) {
                                    $lastMsg->user->last_name = $userContact->last_name;
                                    $lastMsg->user->first_name = $userContact->first_name;
                                    if (!$lastMsg->user->last_name AND !$lastMsg->user->first_name) {
                                        $lastMsg->user->first_name = $userContact->fullname;
                                    }
                                } else {
                                    $lastMsg->user->last_name = '';
                                    $lastMsg->user->first_name = $userContact->fullname;
                                }
                            }
                            if ($userContact->photo)
                                $lastMsg->user->photo = '/images/contacts/'.$user_id.'/'.$userContact->id.'/'.$userContact->photo;
                        }
                    }
                    $dialogs[$dialogTime]['author'] = $lastMsg->user;                        
                } else
                    $dialogs[$dialogTime]['author'] = '';

                $dialogs[$dialogTime]['dialogName'] = $dialogName;
                
                if ($msg) {
                    $multi = '';
                    if (count($dialogs[$dialogTime]['users'])>2){$multi = 'multi-dialog';}
                    $out .= '<li id="dialog_'.$dialogs[$dialogTime]['dialog']->id.'"><div class="dialogue-photo pull-left '.$multi.'"><a href="/dialogs/detail?id='.$dialogs[$dialogTime]['dialog']->id.'">';
                            
                    if (count($dialogs[$dialogTime]['users'])) {
                        $photos = array();
                        $cssClass[$this->id] = 'err';
                        foreach ($dialogs[$dialogTime]['users'] as $user) {
                            
                            if (($user->id!=$user_id || count($dialogs[$dialogTime]['users'])>2) AND $user->photo) {
                                if (substr_count($user->photo, '/images/'))
                                    $photos[] = $user->photo; 
                                else
                                    $photos[] = '/images/users/'.$user->id.'/'.$user->photo;                                    
                            } elseif (($user->id!=$user_id || count($dialogs[$dialogTime]['users'])>2) AND !$user->photo) {
                                $photos[] = '/images/dialogues_nophoto.png';     
                            }
                            $userInDialog = DialogsUsers::model()->findAll(array('condition' => "user_id='".$user->id."' AND delete_time='0' AND dialog_id='".$this->id."'")); 
                            //var_dump($userInDialog);
                            if ($user->id!=$user_id AND $cssClass[$this->id]!='ok' AND $userInDialog) {
                                $activityState = Yii::app()->user->getActivityStatus($user->login); 
                                if ($cssClass[$this->id]!='ok') {
                                    if ($activityState == Users::USER_ACTIVITY_STATUS_ONLINE){
                                        $cssClass[$this->id] = 'ok';
                                    } elseif ($activityState == Users::USER_ACTIVITY_STATUS_BUSY) {
                                        $cssClass[$this->id] = 'time';
                                    } else if ($cssClass[$this->id]!='time' AND $cssClass[$this->id]!='ok') {
                                        $cssClass[$this->id] = 'err';
                                    }
                                }
                            }
                        }
                        
                        if (count($photos)==1) {
                            $out .= '<img src="'.$photos[0].'" width="36px" height="36px" alt=""/>';                                
                        } elseif (count($photos)<1) {   
                            $out .= '<img src="/images/dialogues_nophoto.png" width="36px" height="36px" alt=""/>';   
                        } else {

                            $iph = 0;
                            $imgs = '';
                            foreach ($photos as $photo) {
                                if (count($photos)>1) {
                                    $imgs .= '<img class="gr-m" src="'.$photo.'" alt=""/>';      
                                } else {
                                    $iph++;
                                    $out .= '<img src="'.$photo.'" width="36px" height="36px" alt=""/>';     
                                }
                            }  
                            if ($iph<4) {
                                for ($i=$iph;$i<4;$i++) 
                                    $imgs .= '<img class="gr-m" src="/images/dialogues_group_photo.png" alt=""/>';
                            }
                            if ($imgs) {
                                $out .= '<div class="group-photo-cont">';
                                $out .= $imgs;
                                $out .= '</div>';
                            }                                  
                        }                        
                    }
                    if (count($dialogs[$dialogTime]['users'])>1) { 
                        $out .= '<a class="ico '.$cssClass[$this->id].'" href="#"></a>';
                    }
                    
                    $out .= '</a></div><div class="dialogue-info pull-left"><div class="dialogue-name"><a class="linkDialogName" href="/dialogs/detail?id='.$dialogs[$dialogTime]['dialog']->id.'">';
                   
                    if (count($dialogs[$dialogTime]['users'])<2) {
                        $out .= '<span>'.$dialogs[$dialogTime]['dialogName'].'<span/>';
                    } else {
                        $out .= $dialogs[$dialogTime]['dialogName'];
                    }
                    
                    $out .= '</a><div class="dialogues-name-actions-cont">';
                    
                    if (count($dialogs[$dialogTime]['users'])>2) {// AND $dialogs[$dialogTime]['dialog']->user_id==$user_id) {
                        $out .= '<span class="drdn-cont"><a href="#" class="button-mini arr-grey" data-toggle="dropdown"></a><ul class="dropdown-menu contact-select-dropdown list-unstyled" role="menu"><li class="arr"></li>';
                        if (count($dialogs[$dialogTime]['usersActive'])<2) {
                            $out .= '<li>...</li>';
                        } else {
                            foreach ($dialogs[$dialogTime]['users'] as $user) {

                                if ($user_id==$user->id)
                                    continue; 

                                $sql = 'SELECT delete_time FROM dialogs_users WHERE user_id='.$user->id.' AND dialog_id='.$this->id.'';
                                $connection=Yii::app()->db;
                                $command = $connection->createCommand($sql);
                                $delete_time = $command->queryAll();
                                if ($delete_time[0]['delete_time']!='0')
                                    continue;  

                                $out .= '<li class="clearfix"><div class="img-cont">';

                                $photoSmall = '';
                                if ($user->photo) {
                                    if (substr_count($user->photo, '/images/'))
                                        $photoSmall = $user->photo; 
                                    else
                                        $photoSmall = '/images/users/'.$user->id.'/'.$user->photo;  
                                } else {
                                    $photoSmall = '/images/dialogues_nophoto.png';
                                }

                                $out .= '<img src="'.$photoSmall.'" alt=""><!--<span class="ico ok"></span>--></div><div class="contact-name">';
                                $out .= ($user->first_name ? $user->first_name.' ' : '').($user->last_name ? $user->last_name : '');   

                                   $out .= '</div><div class="transaction-buttons-cont"><a href="/dialogs/delUser?id='.$dialogs[$dialogTime]['dialog']->id.'&user_id='.$user->id.'" class="button remove-mini delUser" onClick="delUserFromDialog($(this));return false;"></a></div></li>';

                            }
                        }
                        $out .= '</ul></span><span class="drdn-cont editDialogBtn"><a href="#" onClick="editDialog($(this));return false;" class="button-mini edit-mini" ></a></span>';  
                    }
                    $out .= '</div></div><div class="dialoque-text">';
                    

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
                            } else if ($deleteUserText)
                                $msg_text = '<b>'.$msg_user.'</b> removed <b>'.$deleteUserText.'</b> from dialogue.';
                            else
                                $msg_text = '<b>'.$msg_user.'</b> left dialogue';
                        }
                    }
                    
                    
                    if ($dialogs[$dialogTime]['author']) {
                        if ($dialogs[$dialogTime]['author']->id==$user_id AND !$msg_text) {
                            $out .= '<b>You:</b> ';
                        } elseif (count($dialogs[$dialogTime]['users'])>2 AND !$msg_text) {
                            $out .= '<b>'.($dialogs[$dialogTime]['author']->last_name ? $dialogs[$dialogTime]['author']->last_name : $dialogs[$dialogTime]['author']->first_name).':</b> ';
                        }
                    }
                    
                    

                    
                    
                    if ($msg_text) {
                        $out .= ($msg ? str_replace("\n", " ", str_replace("\r", " ", htmlspecialchars_decode($msg_text))) : '...');
                    } else if ($msg) {
                        
                        if (!$msg->text) {
                            $cards = DialogsCard::model()->find(
                                    array(
                                        'condition' => "t.msg_id=:msg_id", 
                                        'params' => array(":msg_id"=>$msg->id)
                                    ));
                            if ($cards) {
                                $msg->text = 'send contacts';
                            }
                        }
                        $out .= ($msg ? str_replace("\n", " ", str_replace("\r", " ", htmlspecialchars_decode($msg->text))) : '...');
                    }
                                
                    $out .= '</div></div><div class="contact-actions transaction-buttons-cont"><div class="btn-group with-delete-confirm"><a class="button menu" data-toggle="dropdown" href="#"></a><ul class="dropdown-menu"><li><a class="button edit" href="/dialogs/detail?id='.$dialogs[$dialogTime]['dialog']->id.'"></a></li><li><a href="#" data-url="'.Yii::app()->createUrl('/dialogs/delUser?id='.$dialogs[$dialogTime]['dialog']->id.'&user_id='.$user_id).'" class="button delete delUser" onClick="$(this).addClass(\'opened\');dropdownOpen($(this));"></a>';
                    $out .= '<script>';    
                    $out .= '$(document).ready(function () {$(\'.with-delete-confirm .delUser\').confirmation({title: \''.Yii::t('Front', 'Are you sure?').'\',singleton: true,popout: true,onConfirm: function () {var ths = $(this).parents(\'.popover\').prev(\'a\');delUserFromDialog(ths);return false;}})});';
                    /*successNotify('Category', '<?= Yii::t('Front', 'Category successfully removed') ?>', $(this).parents('.popover').prev('a'))
                    deleteRow($(this).parents('.popover').prev('a'));*/
                    $out .= '</script>';
                    $out .= '</li></ul></div></div>'; 
                    if ($msg) {
                        $out .= '<div class="datetime pull-right">'.date('d.m.Y H:i', $msg->add_time).'</div>';
                        if ($dialogs[$dialogTime]['cnt']) {
                            $out .= '<div class="dialogue-count">'.$dialogs[$dialogTime]['cnt'].'</div>';
                        }
                    }
                    $out .= '<div class="clearfix"></div></li>';  
                }
                            
            }
            //if ($for == 'ajax') // view for ajax only
            //    $out = str_replace('"', '\"', str_replace("\n", "", str_replace("\r", "<br/>", $out)));
            //else // view for other
                $out = $out;            
            echo $out;
        }
        public function getName($dialog_id)
	{
            $user_id = intval(Yii::app()->user->id); // you id
            
            $dialogWith = DialogsUsers::model()->findAll(
                                    array(
                                        'condition' => "t.user_id!=:user_id AND t.dialog_id=".$dialog_id,//." AND t.delete_time='0'", 
                                        'params' => array(":user_id"=>$user_id), 
                                        'order' => 't.add_time DESC', 
                                    ));  
            $dialogWithUser = '';
            $dialogName = '';
            if (count($dialogWith)<2 AND count($dialogWith)>0) {
                if ($withId = $dialogWith[0]->user_id) {

                    $userContact = '';
                    if ($dialogWith[0]->user) {
                        $userContact = Users_Contacts::model()->find(
                                    array(
                                        'condition' => "xabina_id='".$dialogWith[0]->user->login."' AND user_id=".$user_id,  
                                    ));
                        if ($userContact) {
                            if ($userContact->fullname) {
                                $dialogWith[0]->user->last_name = '';
                                $dialogWith[0]->user->first_name = $userContact->fullname;
                            }
                            if ($userContact->photo)
                                $dialogWith[0]->user->photo = '/images/contacts/'.$user_id.'/'.$userContact->id.'/'.$userContact->photo;
                        }
                    }
                    $dialogWithUser = $dialogWith[0]->user;  
                }
                if ($dialogWithUser)
                    $dialogName = ($dialogWithUser->first_name ? $dialogWithUser->first_name.' ' : '')."".($dialogWithUser->last_name ? $dialogWithUser->last_name : '');
            } elseif (count($dialogWith)>1) {
                foreach ($dialogWith as $user) {
                    //if ($user->delete_time!='0')
                    //    continue;
                    
                    if ($withId = $user->user_id) {

                        $userContact = '';
                        if ($user->user) {
                            $userContact = Users_Contacts::model()->find(
                                        array(
                                            'condition' => "xabina_id='".$user->user->login."' AND user_id=".$user_id,  
                                        ));
                            if ($userContact) {
                                if ($userContact->last_name || $userContact->first_name) {
                                    $user->user->last_name = $userContact->last_name;
                                    $user->user->first_name = $userContact->first_name;
                                }
                                //if ($userContact->photo)
                                //    $user->user->photo = '/images/contacts/'.$user_id.'/'.$userContact->id.'/'.$userContact->photo;
                            }
                        }
                        $dialogWithUser = $user->user;  
                    }
                    if ($dialogWithUser) {
                        if ($dialogName)
                            $dialogName .= ', '.($dialogWithUser->last_name ? $dialogWithUser->last_name : $dialogWithUser->first_name);
                        else
                            $dialogName = ($dialogWithUser->last_name ? $dialogWithUser->last_name : $dialogWithUser->first_name);
                    }
                }
            }
            if (!$dialogName)
                $dialogName = 'There are no interlocutors';
            
            return $dialogName;
        }
        
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'type_id' => 'Type',
			'type_url' => 'Type Url',
			'user_id' => 'User',
			'add_time' => 'Add Time',
			'name' => 'Name',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('type_url',$this->type_url,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('add_time',$this->add_time);
		$criteria->compare('name',$this->name,true);
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
	 * @return DialogsList the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
