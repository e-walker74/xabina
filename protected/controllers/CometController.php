<?php

class CometController extends Controller
{
	public function actionIndex()
	{
            $limit = 1;
            $time = time();
            if (isset($_GET['last_id']))
                $last = $_GET['last_id'];
            else
                $last = 1;
            $page = '';
            if (isset($_GET['page']))
                $page = '1';
            $cometOut = '';
            //echo  $time ;
            $user_id = Yii::app()->user->id;
            // script will be killed in limit+5sec
            set_time_limit($limit);

            function escape($str) {
                return str_replace('"','\"',$str);
            }
            // find new
            while (time()-$time<$limit) {

                // checking for new
                $newRows = DialogsComet::model()->findAll(
                                                    array(
                                                        'condition' => "t.user_id=:user_id AND t.add_time>".($time-4), // AND t.type_id>".$last."
                                                        'params' => array(":user_id"=>$user_id), 
                                                    ));  
                    
                    /*if (isset($_GET['id'])) {
                        $hasDialog = DialogsComet::model()->find(
                                                            array(
                                                                'condition' => "t.user_id=:user_id AND t.dialog_id=".$_GET['id'], // AND t.type_id>".$last."
                                                                'params' => array(":user_id"=>$user_id), 
                                                            )); 
                        if ($hasDialog->delete_time>0) {
                            echo 'outOfDialog();{newLine}';
                            flush();
                            exit;
                        }
                    }*/
                //var_dump($newRows);
                if ($newRows) {
                    foreach ($newRows as $newRow) {
                        // js for client
                        if ($newRow->type=="msg" AND !$page) {
                            $newMsg = DialogsMsg::model()->find(
                                                                array(
                                                                    'condition' => "t.id=".$newRow->type_id 
                                                                ));
                            
                            if ($newMsg) {
                                
                                $deleteUser = '';
                                if (substr_count($newMsg->text, '{system}deteleUser_')) {
                                    $deleteUser = intval(str_replace('{system}deteleUser_', '', $newMsg->text));                    
                                }
                                if ($deleteUser==$user_id)
                                    echo 'outOfDialog();';
                                $addUser = '';
                                if (substr_count($newMsg->text, '{system}addUser_')) {
                                    $addUser = intval(str_replace('{system}addUser_', '', $newMsg->text));                    
                                }
                                if ($addUser==$user_id)
                                    echo 'inDialog();';

                                $content = $newMsg->getOneMsg($newMsg->id, 'ajax');
                                
                                if (isset($content['check'])) {
                                    echo 'checkUsers("'.$content['check'].'");{newLine}';
                                }
                                
                                $content = $content['output'];
                                echo 'delWriteMsg("'.$newRow->author_id.'");{newLine}';
                                echo 'putMessage("'.$newMsg->id.'","'.$newMsg->dialog_id.'","'.str_replace("\r\n", "", str_replace("\n", "", $content)).'","down");{newLine}';
                            }
                        } elseif ($newRow->type=="msg" AND $page) {
                  
                            $msg = DialogsMsg::model()->find(
                                                                array(
                                                                    'condition' => "t.id=".$newRow->type_id 
                                                                ));
                            $dialogUser = DialogsUsers::model()->find(
                                                array(
                                                    'condition' => "t.user_id=:user_id AND t.dialog_id=".$msg->dialog_id, 
                                                    'params' => array(":user_id"=>$user_id), 
                                                ));          
                            if ($msg) {
                                $sql = 'SELECT COUNT(*) as cnt FROM dialogs_msg_to_user WHERE user_id='.$user_id.' AND dialog_id='.$msg->dialog_id.' AND status!=1';// AND add_time>'.$dialogUser->delete_last_time;
                                $connection=Yii::app()->db;
                                $command = $connection->createCommand($sql);
                                $cnt = $command->queryAll();
                                if (!isset($cnt[0]['cnt']))
                                    $cnt[0]['cnt'] = 0;
                                

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


                                if (!$msg_text) {
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
                                    if ($msg->text) {
                                        if ($msg->user->id==$user_id) {

                                            $text = str_replace("\n", " ", str_replace("\r", " ", htmlspecialchars_decode('<b>You:</b> '.$msg->text)));

                                        } elseif (count($dialogUser->dialog->allUsers())>2) {

                                            if ($msg->user) {
                                                $userContact = Users_Contacts::model()->find(
                                                            array(
                                                                'condition' => "xabina_id='".$msg->user->login."' AND user_id=".$user_id,  
                                                            ));
                                                if ($userContact) {
                                                    if ($userContact->fullname) {
                                                        $msg->user->last_name = $userContact->last_name;
                                                        $msg->user->first_name = $userContact->first_name;
                                                        if (!$msg->user->last_name AND !$msg->user->first_name) {
                                                            $msg->user->first_name = $userContact->fullname;
                                                        }
                                                    }
                                                }

                                            }
                                            $text = str_replace("\n", " ", str_replace("\r", " ", htmlspecialchars_decode('<b>'.$msg->user->last_name.':</b> '.$msg->text)));
                                        } else {
                                            $text = str_replace("\n", " ", str_replace("\r", " ", htmlspecialchars_decode($msg->text)));
                                        }
                                    } else {
                                        $text = '-';
                                    }
                                } 
                                if ($msg->add_time) {
                                    $add_time = date('d.m.Y H:i', $msg->add_time);
                                } else {
                                    $add_time = '-';
                                }
                                if ($msg_text) {
                                    echo 'putNewMsgCount("'.$cnt[0]['cnt'].'","'.$msg->dialog_id.'","'.$msg_text.'","'.$add_time.'");{newLine}';
                                    echo 'checkUsers("'.$msg->dialog_id.'");{newLine}';
                                } else
                                    echo 'putNewMsgCount("'.$cnt[0]['cnt'].'","'.$msg->dialog_id.'","'.$text.'","'.$add_time.'");{newLine}';
                            }
                        } elseif ($newRow->type=="writeMsg") {
                            
                            $authorObj = $newRow->author;
                            
                            if ($authorObj) {
                                $userContact = Users_Contacts::model()->find(
                                            array(
                                                'condition' => "xabina_id='".$authorObj->login."' AND user_id=".$user_id,  
                                            ));
                                if ($userContact) {
                                    if ($userContact->fullname) {
                                        $authorObj->last_name = '';
                                        $authorObj->first_name = $userContact->fullname;
                                    }
                                    if ($userContact->photo)
                                        $authorObj->photo = '/images/contacts/'.$user_id.'/'.$userContact->id.'/'.$userContact->photo;
                                }
                            }
                            $author = ($authorObj->first_name ? $authorObj->first_name.' ' : '').($authorObj->last_name ? $authorObj->last_name : '');
                            $photo = '';
                            if ($authorObj->photo) {
                                if (substr_count($authorObj->photo, '/images/'))
                                    $photo = '<img src="'.$authorObj->photo.'" width="37px" height="37px" alt=""/>';
                                else
                                    $photo = '<img src="/images/users/'.$authorObj->id.'/'.$authorObj->photo.'" width="37px" height="37px" alt=""/>';
                            } else
                                $photo = '<img src="/images/dialogues_nophoto.png" width="37px" height="37px" alt=""/>';


                            $msg_color = 'pink';
                            $output = '<li id="write_'.$newRow->author_id.'" class="writeMsg"><div class="interlocutor-photo pull-left">'.$photo.'</div><div class="message-container '.$msg_color.'"><div class="message-arr"></div><div class="message-top"><div class="interlocutor-name">'.$author.'</div><div class="meassage-datetime">'.date('d.m.Y H:i', $newRow->add_time).'</div></div><div class="message-text"><img src="/images/typing.png" alt=""></div><div class="clearfix"></div></div></li>';

                            echo 'writeMsgView("'.$newRow->type_id.'","'.$authorObj->id.'","'.str_replace('"', '\"', $output).'","down");{newLine}';
                            
                        } elseif ($newRow->type=="readMsg") {
                            echo 'readMsg("'.$newRow->type_id.'");{newLine}';
                        }
                    }
                    //$this->render('index', array('out' => $cometOut));
                    //exit from script
                    //echo '<script type="text/javascript">'.$cometOut.'</script>';
                    flush();
                    exit;
                }
                
                // wait 
                sleep(1);
            }
           
            //echo $time.'<br/>'.time();
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}