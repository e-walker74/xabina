<?php

class DialogsController extends Controller {

    public $layout = 'banking';
    
    public function filters()
    {
        return array(
            'accessControl',
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
            array('allow', // allow readers only access to the view file
                'actions' => array(''),
                'users' => array('*')
            ),
            array('allow', // allow readers only access to the view file
                'actions' => array(
                    'index',
                    'detail',
                    'delUser',
                    'setMsgColor',
                    'saveName',
                    'getOneDialog',
                    'deleteMsg',
                    'markMsg',
                    'loadMsg',
                    'new',
                    'checkUsers',
                    'editMsg',
                    'addMsgCards',
                    'add',
                    'ajaxPush'),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }
    
    public function actionIndex() {
        
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Dialogs'))] = '';     
        
        $user_id = Yii::app()->user->id;
        $dialogList = DialogsUsers::model()->findAll(
                            array(
                                'condition' => "t.user_id=:user_id AND t.delete_time='0'", 
                                'params' => array(":user_id"=>$user_id), 
                                'order' => 'add_time DESC', 
                            ));
        
        $dialogs = '';
        if ($dialogList) {
            foreach ($dialogList as $key => $dialogUser) {
                $dialog = '';
                $lastMsgToUser = '';
                
                $dialog = $dialogUser->dialog;
                $dialogTime = $dialogUser->add_time;
                
                if ($dialog) {
                    $lastMsgToUser = $dialog->lastMsgToUser($user_id);
                }
                if ($lastMsgToUser) {
                    $dialogTime = $lastMsgToUser->msg->add_time;
                }
                
                $dialogs[$dialogTime]['dialog'] = $dialog;
            }
        }
        if (is_array($dialogs))
            krsort($dialogs);
        $this->render('index', array(
                                'dialogs' => $dialogs,
                                'user_id' => $user_id
                                ));
    }
    /*
     * get one dialog (view for dialog list page)
     */
    public function actionGetOneDialog()
    {
        $user_id = Yii::app()->user->id;
        if (isset($_GET['dialog_id'])) {
            $dialog = DialogsUsers::model()->find(
                                            array(
                                                'condition' => "t.user_id=:user_id AND t.dialog_id=".$_GET['dialog_id'], 
                                                'params' => array(":user_id"=>$user_id)
                                            ));
            if ($dialog->dialog) {
                //if (isset($_GET['ajax']))
                 //   echo $dialog->getOneDialog();//'ajax');
                //else 
                    echo $dialog->dialog->getOneDialog();
            }
        }
    }
    /*
     * delete user ($_GET['user_id']) from dialog ($_GET['id'])
     */
    public function actionDelUser() {
        $user_id = Yii::app()->user->id;
        $time = time();
        if ($_GET['id'] AND $_GET['user_id']) {
            
            $dialog_id = intval($_GET['id']);
            $del_id = intval($_GET['user_id']);
            
            if ($del_id!=$user_id) {
                $dialogExist = DialogsUsers::model()->find(
                                            array(
                                                'select' => 'id',
                                                'condition' => "t.user_id=:user_id AND t.dialog_id=".$dialog_id, 
                                                'params' => array(":user_id"=>$user_id)
                                            ));
            } else {
                $dialogExist = 1;
            }
            if ($dialogExist) {
                $userDialog = DialogsUsers::model()->find(
                                        array(
                                            'condition' => "user_id=:user_id AND dialog_id=".$dialog_id, 
                                            'params' => array(":user_id"=>$del_id)
                                        ));
                $userDialog->delete_time = $time;
                $userDialog->delete_last_time = $time;
                if ($userDialog->save()) {
                    $dialogUserList = DialogsUsers::model()->findAll(
                                        array(
                                            'select' => 'user_id',
                                            'condition' => "t.dialog_id=:dialog_id AND (t.delete_time='0' OR t.user_id='".$del_id."')", 
                                            'params' => array(":dialog_id"=>$dialog_id)
                                        ));

                    if ($dialogUserList) {

                        $type = 'msg';
                        $text = $del_id;
                        $for = 'all';

                        $msg = new DialogsMsg;
                        $msg->text = '{system}deteleUser_'.$del_id;
                        $msg->add_time = $time;
                        $msg->user_id = $user_id;
                        $msg->dialog_id = $dialog_id;
                        $msg->for = $for;
                        if ($msg->save()) {
                            foreach ($dialogUserList as $key => $dialogUser) {

                                $msgToUser = new DialogsMsgToUser;
                                $msgToUser->msg_id = $msg->id;
                                $msgToUser->dialog_id = $dialog_id;
                                $msgToUser->user_id = $dialogUser->user_id;
                                if ($dialogUser->user_id==$user_id) 
                                    $msgToUser->status = '1';
                                else
                                    $msgToUser->status = '2';
                                $msgToUser->add_time = $time;
                                $msgToUser->save();
                                unset($msgToUser);
                                
                                $msgToComet = new DialogsComet;
                                $msgToComet->add_time = $time;
                                $msgToComet->type = $type;
                                $msgToComet->type_id = $msg->id;
                                $msgToComet->author_id = $user_id;
                                $msgToComet->user_id = $dialogUser->user_id;
                                $msgToComet->save();
                                unset($msgToComet);
                                
                            }
                        }
                    }
                }                   
            }
                //DialogsMsgToUser::model()->deleteAll(array('condition' => "dialog_id=:id AND user_id=".$del_id, 'params' => array(":id"=>$dialog_id)));        
        }
        
        if (!isset($_GET['noredir']))
            $this->actionDetail();
        
    }

    /*
     * set color ($_GET['color']) for msg ($_GET['msg_id'])
     */    
    public function actionSetMsgColor() {
        $user_id = Yii::app()->user->id;
        if (isset($_GET['color']) AND isset($_GET['msg_id'])) {
            $msgToUser = DialogsMsgToUser::model()->find(
                                    array(
                                        'condition' => "t.user_id=:user_id AND msg_id=".$_GET['msg_id'], 
                                        'params' => array(":user_id"=>$user_id), 
                                    ));
            if ($msgToUser) {
                $msgToUser->group = $_GET['color'];
                if ($msgToUser->save())
                    echo $msgToUser->msg_id;
            }
        }
    }
    /*
     * save dialog name
     */
    public function actionSaveName() {
        $user_id = Yii::app()->user->id;
        $dialog_id = intval($_GET['dialog_id']);
        $dialog_name = htmlspecialchars(strip_tags($_GET['dialog_name']));
        if ($dialog_id AND $dialog_name) {
            $dialogUser = DialogsUsers::model()->find(
                                    array(
                                        'condition' => "t.user_id=:user_id AND dialog_id=".$dialog_id, 
                                        'params' => array(":user_id"=>$user_id), 
                                    ));
            if ($dialogUser) {
                $dialogUser->name = $dialog_name;
                $dialogUser->save();
            }
        }
    }
    /*
     * delete msg ($_GET['msg_id'])
     */    
    public function actionDeleteMsg() {
        $user_id = Yii::app()->user->id;
        if (isset($_GET['msg_id'])) {
            $msg = DialogsMsg::model()->find(
                                    array(
                                        'condition' => "t.user_id=:user_id AND id=".$_GET['msg_id'], 
                                        'params' => array(":user_id"=>$user_id), 
                                    ));
            if ($msg) {
                $msgToUser = DialogsMsgToUser::model()->find(
                                        array(
                                            'condition' => "t.msg_id=".$_GET['msg_id']." AND t.status!=2 AND t.user_id!=".$user_id, 
                                        ));
                if (!$msgToUser) {
                    DialogsMsgToUser::model()->deleteAll(
                                        array(
                                            'condition' => "msg_id=".$_GET['msg_id'] 
                                        ));
                    DialogsMsg::model()->deleteAll(
                                    array(
                                        'condition' => "user_id=$user_id AND id=".$_GET['msg_id'], 
                                    ));
                    echo $_GET['msg_id'];
                }
            }
        }
    }
    /*
     * mark msg ($_GET['msg_id'])
     */    
    public function actionMarkMsg() {
        $user_id = Yii::app()->user->id;
        if (isset($_GET['msg_id'])) {
            $msg = DialogsMsgToUser::model()->find(
                                    array(
                                        'condition' => "t.user_id=:user_id AND msg_id=".$_GET['msg_id'], 
                                        'params' => array(":user_id"=>$user_id), 
                                    ));
            if ($msg) {
                $msg->status = 3;
                if ($msg->save())
                    echo $_GET['msg_id'];
            }
        }
    }
    /*
     * mark msg ($_GET['msg_id'])
     */    
    public function actionEditMsg() {
        $user_id = Yii::app()->user->id;
        
        if (isset($_POST['msg_id'])) {
            $msg_id = intval($_POST['msg_id']);
            $text = $_POST['text'];
            if ($msg_id) {
                $msg = DialogsMsg::model()->find(
                                        array(
                                            'condition' => "t.user_id=:user_id AND id=".$msg_id, 
                                            'params' => array(":user_id"=>$user_id), 
                                        ));
                if ($msg) {
                    $msg->text = $text;
                    if ($msg->save())
                        echo '1';
                }
            }
        }
    }
    /*
     * mark msg ($_GET['msg_id'])
     */    
    public function actionCheckUsers() {
        $user_id = Yii::app()->user->id;
        
        if (isset($_GET['dialog_id'])) {
            $dialog_id = intval($_GET['dialog_id']);
            if ($dialog_id) {
                $dialog = DialogsList::model()->find(
                                        array(
                                            'condition' => "t.id=".$dialog_id
                                        ));
                $out = '';
                if ($dialog) {
                    $users = $dialog->allUsersActive();
                    if ($users<2) {
                        $out = '<li class="arr"></li><li>...</li>';
                    } else {
                        foreach ($users as $user) {
                            if (!$out)
                                $out = '<li class="arr"></li>';
                            if ($user_id==$user->id)
                                continue; 

                            $sql = 'SELECT delete_time FROM dialogs_users WHERE user_id='.$user->id.' AND dialog_id='.$dialog_id.'';
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

                            $out .= '</div><div class="transaction-buttons-cont"><a href="/dialogs/delUser?id='.$dialog_id.'&user_id='.$user->id.'" class="button remove-mini delUser" onClick="delUserFromDialog($(this));return false;"></a></div></li>';                       
                        }
                    }
                    echo $out;
                }
            }
        }
    }
    /*
     * addMsgCards
     */
    public function addMsgCards ($cid, $msg_id) {
        $time = time();
        $user_id = Yii::app()->user->id;
        if ($cid AND $msg_id) {
            $cid = explode(',', $cid);
            foreach ($cid as $c) {
                $newMsgCard = new DialogsCard;
                $newMsgCard->user_id = $user_id;
                $newMsgCard->msg_id = $msg_id;
                $newMsgCard->book_id = $c;
                $newMsgCard->save();       
                unset($newMsgCard);
            }
        }
    }
    /*
     * load msg (before $_GET['msg_id']) from dialog ($_GET['dialog_id'])
     */    
    public function actionLoadMsg() {
        $time = microtime();
        $user_id = Yii::app()->user->id;
        if (isset($_GET['msg_id']) AND isset($_GET['dialog_id'])) {
            $dialog = DialogsUsers::model()->find(
                                array(
                                    'condition' => "t.user_id=:user_id AND t.dialog_id=".intval($_GET['dialog_id']), 
                                    'params' => array(":user_id"=>$user_id)
                                ));
            if ($dialog) {
                $msgRows = DialogsMsgToUser::model()->findAll(
                                                    array(
                                                        'condition' => "t.user_id=:user_id AND t.msg_id<".intval($_GET['msg_id'])." AND dialog_id=".intval($_GET['dialog_id']),//." AND t.add_time>".$dialog->delete_last_time, 
                                                        'params' => array(":user_id"=>$user_id), 
                                                        'limit' => '10',
                                                        'order' => 'id DESC'
                                                    ));  
                /*foreach ($msgRows as $msg) {
                    if ($msg->status!=1) {
                        $msg->status = 1;
                        $msg->save();
                    }
                }*/
                if ($msgRows) {
                    foreach ($msgRows as $msgRow) {
                        $content = $msgRow->msg->getOneMsg($msgRow->msg->id, 'ajax');
                        $content = $content['output'];
                        echo 'putMessage("'.$msgRow->msg->id.'","'.intval($_GET['dialog_id']).'","'.$content.'","up");{newLine}';
                    }
                    echo '\n\n'.microtime()-$time;
                    flush();
                    exit;
                }
            }
        }
    }
    /*
     * add new dialog with users (array $_GET['ids'])
     */
    public function actionNew() {
        
        $user_id = Yii::app()->user->id;
        $time = time();
        $fromBook = '';
        $regularId = '';
        $act = '';
        
        if (isset($_GET['fromBook']))
            $fromBook = 1;
        $row = '';
        if ($_GET['ids']) {
            
            $ids = explode(',', $_GET['ids']);
            
            if (count($ids)) {
                
                if (count($ids)==1) {
                    $regularId = Users::model()->find(
                                            array(
                                                'select' => 'id, login',
                                                'condition' => "t.login='".$ids[0]."' OR t.id='".$ids[0]."'"
                                            ));
                    if ($regularId->id==$user_id)
                        return false;
                    
                    if ($regularId) {
                        $ids[0] = $regularId->id;
                        $sql = 'SELECT one.dialog_id FROM dialogs_users one, dialogs_users two WHERE one.user_id='.intval($ids[0]).' AND two.user_id='.$user_id.' AND one.dialog_id=two.dialog_id';
                        $connection=Yii::app()->db;
                        $command = $connection->createCommand($sql);
                        $row = $command->queryAll();
                        $inDialog = '';
                        foreach ($row as $did) {
                            if ($inDialog)
                                $inDialog .= ', '.$did['dialog_id'];
                            else
                                $inDialog = $did['dialog_id'];               
                        }    
                        if ($inDialog) {
                            $sql = 'SELECT one.dialog_id FROM dialogs_users one WHERE one.dialog_id IN('.$inDialog.') GROUP BY one.dialog_id HAVING COUNT(one.dialog_id)=2';
                            $connection=Yii::app()->db;
                            $command = $connection->createCommand($sql);
                            $row = $command->queryRow();
                        }
                        if ($row) { //check: user have dialog? if not - create DialogsUsers
                            $myDialog = DialogsUsers::model()->find(array('condition' => "t.dialog_id=:id AND user_id=".$user_id, 'params' => array(":id"=>$row['dialog_id'])));
                            $myDialog->add_time = $time;
                            $myDialog->save();
                            
                            if (!$myDialog) {
                                $newDialogUser = new DialogsUsers;
                                $newDialogUser->user_id = $user_id;
                                $newDialogUser->dialog_id = $row['dialog_id'];
                                $newDialogUser->add_time = $time;
                                $newDialogUser->save();       
                                unset($newDialogUser);
                            } else {
                                if ($myDialog->delete_time>0) {
                                    //DialogsMsgToUser::model()->deleteAll(array('condition' => "dialog_id=:id AND user_id=".$user_id, 'params' => array(":id"=>$row['dialog_id'])));
                                    $myDialog->delete_time = 0;
                                    $myDialog->delete_last_time = 0;
                                    $myDialog->save();
                                }
                            }
                            $ownDialog = DialogsUsers::model()->find(array('condition' => "t.dialog_id=:id AND user_id=".$ids[0], 'params' => array(":id"=>$row['dialog_id'])));
                            if (!$ownDialog) {
                                $newDialogUser = new DialogsUsers;
                                $newDialogUser->user_id = $ids[0];
                                $newDialogUser->dialog_id = $row['dialog_id'];
                                $newDialogUser->add_time = $time;
                                $newDialogUser->save();  
                                unset($newDialogUser);     
                            } else {
                                if ($ownDialog->delete_time>0) {
                                    //DialogsMsgToUser::model()->deleteAll(array('condition' => "dialog_id=:id AND user_id=".$ids[0], 'params' => array(":id"=>$row['dialog_id'])));
                                    $ownDialog->delete_time = 0;
                                    $ownDialog->save();
                                }
                            }
                        }
                    } else {
                        $ids[0] = '';
                    }
                }
                if ($ids[0]) {
                    if (!$row) {
                        $newDialog = new DialogsList;
                        $newDialog->type_id = '1';
                        $newDialog->add_time = $time;
                        $newDialog->user_id = $user_id;

                        if ($newDialog->save()) {

                            $dialog_id = $newDialog->id;

                            $newDialogUser = new DialogsUsers;
                            $newDialogUser->user_id = $user_id;
                            $newDialogUser->dialog_id = $dialog_id;
                            $newDialogUser->add_time = $time;
                            $newDialogUser->save();
                            unset($newDialogUser);

                            foreach ($ids as $id) {
                                
                                $regularId = Users::model()->find(
                                                        array(
                                                            'select' => 'id, login',
                                                            'condition' => "t.login=:id OR t.id=:id", 
                                                            'params' => array(":id"=>$id), 
                                                        ));
                                if ($regularId->id==$user_id)
                                    continue;
                                
                                if ($regularId) {
                                    
                                    $id = $regularId->id;
                                
                                    if (intval($id)==$user_id || !$id) 
                                        continue;
                                    $newDialogUser = new DialogsUsers;
                                    $newDialogUser->user_id = intval($id);
                                    $newDialogUser->dialog_id = $dialog_id;
                                    $newDialogUser->add_time = $time;
                                    $newDialogUser->save();
                                    unset($newDialogUser);
                                }
                            }
                            
                            if ($fromBook)
                                header( 'Location: /dialogs/detail/?id='.$dialog_id );
                            else
                                echo $dialog_id;

                        }
                    } else {
                        if ($fromBook)
                           header( 'Location: /dialogs/detail/?id='.$row['dialog_id'] );
                        else
                           echo $row['dialog_id'];
                    }
                } else {
                    echo 'error';
                }
            }
            
        }
        
    }
    /*
     * add new user $_GET['ids'] into dialog $_GET['dialog_id']
     */
    public function actionAdd() {
        
        $user_id = Yii::app()->user->id;
        $time = time();
        $dialog_id = intval($_GET['dialog_id']);
        $fromBook = '';
            if (isset($_GET['fromBook']))
                $fromBook = 1;
        if ($_GET['ids']) {
            
            $ids = explode(',', $_GET['ids']);
            
            if (count($ids)) {
                
                if ($ids[0]) {
    
                    foreach ($ids as $id) {
                        $id = intval($id);
                        if ($id) {
                            $regularId = Users::model()->find(
                                                    array(
                                                        'select' => 'id, login',
                                                        'condition' => "t.login='".$id."' OR t.id='".$id."'", 
                                                    ));
                            if ($regularId->id==$user_id)
                                continue;
                            if ($regularId) {
                                $id = $regularId->id;
                                $dialogId = DialogsList::model()->find(
                                                        array(
                                                            'condition' => "id='".$dialog_id."'",
                                                        ));
                                $added = 0;
                                if ($dialogId) {
                                    $dialogIdUser = DialogsUsers::model()->find(
                                                            array(
                                                                'condition' => "dialog_id='".$dialogId->id."' AND user_id='".$id."'",
                                                            ));
                                    if (!$dialogIdUser) {
                                        $dialogIdUser = new DialogsUsers;
                                        $dialogIdUser->user_id = intval($id);
                                        $dialogIdUser->dialog_id = $dialogId->id;
                                        $dialogIdUser->add_time = $time;
                                        if ($dialogIdUser->save()) {
                                            $added = 1;
                                        }
                                    } else {
                                        if ($dialogIdUser->delete_time>0) {
                                            $dialogIdUser->delete_time = 0;
                                            if ($dialogIdUser->save()) {
                                                $added = 1;
                                            }
                                        }
                                    }
                                    if ($added AND $dialogIdUser) {
                                        $dialogUserList = DialogsUsers::model()->findAll(
                                                            array(
                                                                'select' => 'user_id',
                                                                'condition' => "t.dialog_id=:dialog_id AND t.delete_time='0'", 
                                                                'params' => array(":dialog_id"=>$dialogId->id)
                                                            ));

                                        if ($dialogUserList) {

                                            $type = 'msg';
                                            $for = 'all';

                                            $msg = new DialogsMsg;
                                            $msg->text = '{system}addUser_'.$dialogIdUser->user_id;
                                            $msg->add_time = $time;
                                            $msg->user_id = $user_id;
                                            $msg->dialog_id = $dialogId->id;
                                            $msg->for = $for;
                                            if ($msg->save()) {
                                                foreach ($dialogUserList as $key => $dialogUser) {

                                                    $msgToUser = new DialogsMsgToUser;
                                                    $msgToUser->msg_id = $msg->id;
                                                    $msgToUser->dialog_id = $dialogId->id;
                                                    $msgToUser->user_id = $dialogUser->user_id;
                                                    if ($dialogUser->user_id==$user_id) 
                                                        $msgToUser->status = '1';
                                                    else
                                                        $msgToUser->status = '2';
                                                    
                                                    $msgToUser->add_time = $time;
                                                    $msgToUser->save();
                                                    unset($msgToUser);

                                                    $msgToComet = new DialogsComet;
                                                    $msgToComet->add_time = $time;
                                                    $msgToComet->type = $type;
                                                    $msgToComet->type_id = $msg->id;
                                                    $msgToComet->author_id = $user_id;
                                                    $msgToComet->user_id = $dialogUser->user_id;
                                                    $msgToComet->save();
                                                    unset($msgToComet);

                                                }
                                            }
                                        }
                                        unset($newDialogUser);
                                    }
                                }
                            }
                        }
                    }
                                    
                    if ($fromBook)
                        header( 'Location: /dialogs/detail/?id='.$dialog_id );
                    else
                        echo $dialog_id;
                } 
            }
            
        }
        
    }
    /*
     * dialog detail page
     */
    public function actionDetail() {
        $time = time();
        $user_id = Yii::app()->user->id;
        $id = '';
        if ($_GET)
            $id = intval($_GET['id']);
        
        if ($id AND $user_id) {
            $dialogUser = DialogsUsers::model()->find(
                                    array(
                                        'condition' => "t.user_id=:user_id AND t.dialog_id=".$id." AND t.delete_time='0'", 
                                        'params' => array(":user_id"=>$user_id), 
                                    ));
            if ($dialogUser) {
                $dialog = $dialogUser->dialog;
                
                
                
                if (!$dialogName=$dialogUser->name) {
                    if (!$dialogName = $dialog->name) {
                        $dialogName = $dialog->getName($dialog->id);
                    }
                } 
                
                $this->breadcrumbs[Yii::t('Front', 'Dialogs')] = array('/dialogs/');
                $this->breadcrumbs[Yii::t('Front', Yii::t('Front', $dialogName))] = '';
                    
                $msgToUser = '';
                $msgToUser = DialogsMsgToUser::model()->findAll(
                                                    array(
                                                        'condition' => "t.user_id=:user_id AND t.dialog_id=".$id,//." AND t.add_time>".$dialogUser->delete_last_time, 
                                                        'params' => array(":user_id"=>$user_id), 
                                                        'order' => 't.msg_id DESC', //t.add_time DESC
                                                        'group' => 't.msg_id',
                                                        'limit' => '10',
                                                        'offset' => '0'
                                                    ));
                
                $msgs = '';
                if ($msgToUser) {
                    foreach ($msgToUser as $key => $msgList) { 
                        if ($msgList->status!=1) {
                            //$msgList->status = 1;
                            //$msgList->save();
                            
                            
                            $dialogUsers = DialogsUsers::model()->findAll(
                                                    array(
                                                        'condition' => "t.user_id!=:user_id AND t.dialog_id=".$msgList->dialog_id, 
                                                        'params' => array(":user_id"=>$user_id), 
                                                    ));
                            if ($dialogUsers) {
                                foreach ($dialogUsers as $usr) {
                                    $toComet = new DialogsComet;
                                    $toComet->add_time = $time;
                                    $toComet->type = 'readMsg';
                                    $toComet->type_id = $msgList->msg_id;
                                    $toComet->author_id = $user_id;
                                    $toComet->user_id = $usr->user_id;
                                    $toComet->save();
                                    unset($toComet);
                                }
                            }
                        }
                        $msgs[$key]['msg'] = $msgList->msg->getOneMsg($msgList->msg->id, 'list');
                        $msgs[$key]['msg'] = $msgs[$key]['msg']['output'];
                    }
                }
                if ($msgs)
                    $msgs = array_reverse($msgs);
                
                $thsDialog['users'] = $dialog->allUsers();
                $thsDialog['usersActive'] = $dialog->allUsersActive();
                $thsDialog['dialog'] = $dialog;

                $this->render('detail', array(
                                            'user_id' => Yii::app()->user->id,
                                            'dialogName' => $dialogName,
                                            'msgs' => $msgs,
                                            'dialog' => $thsDialog
                                        ));
                
            } else {
                $this->actionIndex();                
            }
        } else {
            $this->actionIndex();
        }
    }

    /*
     * ajax push function
     */
    public function actionAjaxPush() {
        $user_id = intval(Yii::app()->user->id);
        $time = time();
        $dialog_id = intval($_POST['id']);//49;//
        $type = $_POST['type'];//'msg';//
        $content = $_POST['content'];//like array('for'=>'all', 'files' => '', 'cards' => '', 'text' => 'asd');//
        $text = str_replace('\n', '<br/>', str_replace('"', '&quot;', htmlspecialchars(strip_tags($content['text']))));
        $for = $content['for'];
        $files = $content['files'];
        $cards = $content['cards'];
        //var_dump($files);
        //return false;
        if ($type=='msg' AND intval($dialog_id)) {
            $time = time();
            

            $userDialog = DialogsUsers::model()->find(
                        array(
                            'select' => 'user_id',
                            'condition' => "t.dialog_id=:dialog_id AND t.delete_time='0' AND t.user_id=:user_id", 
                            'params' => array(":dialog_id"=>$dialog_id, ":user_id"=>$user_id)
                        ));  
            if (isset($userDialog)) {
                $msg = new DialogsMsg;
                $msg->text = $text;
                $msg->add_time = $time;
                $msg->user_id = $user_id;
                $msg->dialog_id = $dialog_id;
                if ($for=='me' || $for=='all') {
                    $msg->for = $for;
                } else {
                    $msg->for = 'group';
                }
                if ($msg->save()) {
                    $msg_id = $msg->id;
                    if ($cards) {
                        $this->addMsgCards($cards, $msg_id);
                    }
                    if ($for=='me') {
                        $dialogUserList = DialogsUsers::model()->findAll(
                                    array(
                                        'condition' => "t.dialog_id=:dialog_id AND t.user_id=".$user_id,// AND t.delete_time='0'", 
                                        'params' => array(":dialog_id"=>$dialog_id)
                                    ));
                    } else if ($for=='all' || !$for) {
                        $dialogUserList = DialogsUsers::model()->findAll(
                                    array(
                                        'condition' => "t.dialog_id=:dialog_id",// AND t.delete_time='0'", 
                                        'params' => array(":dialog_id"=>$dialog_id)
                                    ));
                    } else {
                        $dialogUserList = DialogsUsers::model()->findAll(
                                    array(
                                        'condition' => "t.dialog_id=:dialog_id AND t.user_id IN(".$for.", ".$user_id.")",
                                        'params' => array(":dialog_id"=>$dialog_id)
                                    ));
                    }
                    if ($dialogUserList) {
                        foreach ($dialogUserList as $key => $dialogUser) {
                            if (count($dialogUserList)<2) {
                                $dialogUser->delete_time = '0';
                                $dialogUser->save();
                            }
                            if ($dialogUser->delete_time=='0') {
                                $msgToUser = new DialogsMsgToUser;
                                $msgToUser->msg_id = $msg_id;
                                $msgToUser->dialog_id = $dialog_id;
                                $msgToUser->user_id = $dialogUser->user_id;
                                if ($dialogUser->user_id==$user_id) 
                                    $msgToUser->status = '1';
                                else
                                    $msgToUser->status = '2';
                                $msgToUser->add_time = $time;
                                if ($msgToUser->save()) {

                                    $msgToComet = new DialogsComet;
                                    $msgToComet->add_time = $time;
                                    $msgToComet->type = $type;
                                    $msgToComet->type_id = $msg_id;
                                    $msgToComet->author_id = $user_id;
                                    $msgToComet->user_id = $dialogUser->user_id;
                                    $msgToComet->save();

                                }
                                unset($msgToUser);
                            }
                        }
                    }
                    
                    $content = $msg->getOneMsg($msg->id, 'ajax');
                    $content = $content['output'];
                    echo 'putMessage("'.$msg->id.'","'.$msg->dialog_id.'","'.$content.'");{newLine}';
                    
                } else {
                    echo 'not send: not save';                
                }
            } else {
                echo 'not send: no dialog';                
            }            
        } elseif ($type=='writeMsg' AND intval($dialog_id)) { 
            
            $dialogUserList = DialogsUsers::model()->findAll(
                                array(
                                    'select' => 'user_id',
                                    'condition' => "t.dialog_id=:dialog_id AND t.delete_time='0' AND t.user_id!=".$user_id, 
                                    'params' => array(":dialog_id"=>$dialog_id)
                                ));
            
            if ($dialogUserList) {
                
                foreach ($dialogUserList as $key => $dialogUser) {

                    $msgToComet = new DialogsComet;
                    $msgToComet->add_time = $time;
                    $msgToComet->type = $type;
                    $msgToComet->type_id = $dialog_id;
                    $msgToComet->author_id = $user_id;
                    $msgToComet->user_id = $dialogUser->user_id;
                    $msgToComet->save();
                    unset($msgToComet);
                    
                }
                
            }

        } else {
            echo '0';            
        } 
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
