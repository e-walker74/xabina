<?php
/* @var $this DialogsController */
?>
<script type="text/javascript" src="/js/comet.js"></script>

<style>
    ul.selected-id-list {
        min-height: 33px;        
    }
    .dialogue-photo img,
    .interlocutor-photo img,
    .user-photo img {
        position: relative;
        border: 1px solid #BDBDC5;
        border-radius: 5px;
    }
    .dialogues-header .user-name span {
        color: #8A8997;        
    }   
    .scroll-cont {         
        background: #F1F1F3;
    }
    .contacts-list-cont {
        max-height: 300px;
    }
    .selected-id-list .error-message {
        top: 45px;
        margin-top: -6px;
        width: 100%;
        z-index: 1000;
    }
    .zindex {
        z-index: 10001;
    }
    .dialogues-content .search-contact-dropdown .contact-actions.transaction-buttons-cont {
        float: right;        
    }
    <?php
    $dialogsHeader = '';
    if (isset(Yii::app()->request->cookies['dialogsHeader']))
        $dialogsHeader = Yii::app()->request->cookies['dialogsHeader']->value;
    if ($dialogsHeader!=2) {?>
        .dialoques-table .dialogues-header.opened {
            display: block;        
        }
    <?php }?>
</style>
<div class="col-lg-9 col-md-9 col-sm-9 dialogDetail" id="dialogDetail_<?php echo $dialog['dialog']->id;?>">
            <div class="dialoques-table dialogues-content">
            <div class="dialogues-messages" >
            <div class="dialogues-header <?if ($dialogsHeader!=2) {?>opened<?}?>">
                <div class="row" style="margin: 0">
                    <div class="col-lg-5 col-md-5 col-sm-5" style="padding: 0 5px 0 0">

                        <div class="user-photo">
                            
                                <?php
                                    if (count($dialog['users'])) {
                                        $photos = array();
                                        $cssClass = 'err';
                                        foreach ($dialog['users'] as $user) {
                                            if (($user->id!=$user_id OR count($dialog['users'])>2) AND $user->photo) {
                                                if (substr_count($user->photo, '/images/'))
                                                    $photos[] = $user->photo; 
                                                else
                                                    $photos[] = '/images/users/'.$user->id.'/'.$user->photo;                                    
                                            } elseif (($user->id!=$user_id OR count($dialog['users'])>2) AND !$user->photo) {
                                                $photos[] = '/images/dialogues_nophoto.png';     
                                            }
                                            
                                            if (count($dialog['users'])>1 AND $cssClass!='ok' AND $user->id!=$user_id) {
                                                $userInDialog = DialogsUsers::model()->findAll(array('condition' => "user_id='".$user->id."' AND delete_time='0' AND dialog_id='".$dialog['dialog']->id."'")); 
                                                if ($user->id!=$user_id AND $cssClass!='ok' AND $userInDialog) {
                                                    $activityState = Yii::app()->user->getActivityStatus($user->login); 
                                                    if ($cssClass!='ok') {
                                                        if ($activityState == Users::USER_ACTIVITY_STATUS_ONLINE){
                                                            $cssClass = 'ok';
                                                        } elseif ($activityState == Users::USER_ACTIVITY_STATUS_BUSY) {
                                                            $cssClass = 'time';
                                                        } else {
                                                            $cssClass = 'err';
                                                        }
                                                    }
                                                }    
                                            }
                                        }
                                        if (count($photos)==1) {
                                            echo '<img src="'.$photos[0].'" width="37px" height="37px" alt=""/>';                        
                                        } elseif (count($photos)<1) {   
                                            echo '<img src="/images/dialogues_nophoto.png" width="36px" height="36px" alt=""/>';     
                                        } else {
                                            $iph = 0;
                                            $imgs = '';
                                            foreach ($photos as $photo) {
                                                if (count($photos)>1) {
                                                    $imgs .= '<img class="gr-m" src="'.$photo.'" alt=""/>';      
                                                } else {
                                                    $iph++;
                                                    echo '<img src="'.$photo.'" width="37px" height="37px" alt=""/>';     
                                                }
                                            }  
                                            if ($iph<4) {
                                                for ($i=$iph;$i<4;$i++) 
                                                    $imgs .= '<img class="gr-m" src="/images/dialogues_group_photo.png" alt=""/>';
                                            }
                                            if ($imgs) {
                                                echo '<div class="group-photo-cont">';
                                                echo $imgs;
                                                echo '</div>';
                                            }
                                        }
                                    }
                                ?>                            
                            <?php
                                if (count($dialog['users'])>1) { 
                                    echo '<span class="ico '.$cssClass.'"></span>';
                                }
                            ?>
                        </div>
                        <div class="user-name">
                            <?php 
                                if (count($dialog['users'])<2) {
                                    echo '<span>'.$dialogName.'<span/>';
                                } else {
                                    if ($dialogName) {
                                        echo $dialogName;
                                    } else {
                                        if (count($dialog['users']>1)) { 
                                            $i = 0;
                                            foreach ($dialog['users'] as $user) {
                                                if ($i>0) echo ', ';
                                                echo ($user->first_name ? $user->first_name.' ' : '').($user->last_name ? $user->last_name : '');
                                                $i++;
                                            }
                                        } elseif (count($dialog['users'])) {
                                            echo ($dialog['users'][0]->first_name ? $dialog['users'][0]->first_name.' ' : '').($dialog['users'][0]->last_name ? $dialog['users'][0]->last_name : '');                                  
                                        }
                                    }
                                }
                            ?>
                        </div>
                        <div class="user-actions">
                                <?php
                                    if (count($dialog['users'])>2) {// AND $dialog['dialog']->user_id==$user_id) {
                                ?>
                                    <a href="#" class="button-mini arr-grey" data-toggle="dropdown" ></a>
                                    <ul class="dropdown-menu contact-select-dropdown list-unstyled" role="menu" >
                                        <li class="arr"></li>
                                        <?php
                                            if (count($dialog['usersActive'])<2)
                                                echo '<li>...</li>';
                                            foreach ($dialog['users'] as $user) {
                                                if ($user_id==$user->id)
                                                    continue;
                                                
                                            $sql = 'SELECT delete_time FROM dialogs_users WHERE user_id='.$user->id.' AND dialog_id='.$dialog['dialog']->id.'';
                                            $connection=Yii::app()->db;
                                            $command = $connection->createCommand($sql);
                                            $delete_time = $command->queryAll();

                                            if ($delete_time[0]['delete_time']!='0')
                                                continue; 
                                        ?>
                                                <li class="clearfix">
                                                    <div class="img-cont">
                                                        <?php
                                                            $photoSmall = '';
                                                            if ($user->photo) {
                                                                if (substr_count($user->photo, '/images/'))
                                                                    $photoSmall = $user->photo; 
                                                                else
                                                                    $photoSmall = '/images/users/'.$user->id.'/'.$user->photo;  
                                                            } else {
                                                                $photoSmall = '/images/dialogues_nophoto.png';
                                                            }
                                                        ?>
                                                        <img src="<?=$photoSmall?>" alt="">
                                                        <?
                                                            $cssClass = 'err';
                                                            if ($user->id!=$user_id) {
                                                                $activityState = Yii::app()->user->getActivityStatus($user->login); 
                                                                if ($cssClass!='ok') {
                                                                    if ($activityState == Users::USER_ACTIVITY_STATUS_ONLINE){
                                                                        $cssClass = 'ok';
                                                                    } elseif ($activityState == Users::USER_ACTIVITY_STATUS_BUSY) {
                                                                        $cssClass = 'time';
                                                                    } else {
                                                                        $cssClass = 'err';
                                                                    }
                                                                }
                                                            } 
                                                        ?>
                                                        <span class="ico <?=$cssClass?>"></span>
                                                    </div>
                                                    <div class="contact-name">
                                                        <?php
                                                            echo ($user->first_name ? $user->first_name.' ' : '').($user->last_name ? $user->last_name : '');
                                                        ?>
                                                    </div>
                                                    <div class="transaction-buttons-cont">
                                                        <a href="/dialogs/delUser?id=<?=$dialog['dialog']->id?>&user_id=<?=$user->id?>" class="button remove-mini delUser" onClick="delUserFromDialog($(this));return false;"></a>
                                                    </div>
                                                </li>
                                        <?php
                                            }
                                        ?>    
                                    </ul>
                                <?php
                                    }
                                ?>  
                            <a  href="#" class="button-mini plus-green" id="add_contact"></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7" style="padding: 0 0 0 5px">
                        <div class="row select-cont" >
                            <div class="col-lg-6 col-md-6 col-sm-6" style="padding: 0 0 0 5px">
                                <div class="select-custom select-narrow select-only">
                                    <span class="select-custom-label">Outgoung payments</span>
                                    <select name="" class="select-invisible country-select type_msg_show" onChange="showMeMsgs();">
                                        <option value="all" selected="selected">Show all</option>
                                        <!--<option value="att">Only attachments</option>-->
                                        <option value="inc">Incoming messages</option>
                                        <option value="out">Outgoing messages</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5" style="padding: 0 5px 0 5px">
                                <div class="select-custom select-narrow select-dialogues ">
                                    <span class="select-custom-label">Outgoung payments</span>
                                    <select name="" class="select-invisible country-select color_msg_show" onChange="showMeMsgs();">
                                        <option value="all" selected="selected">All category</option>
                                        <option value="blue">Blue category</option>
                                        <option value="green">Green category</option>
                                        <option value="red">Red category</option>
                                        <option value="yellow">Yellow category</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1" style="padding: 0 0 0 5px">
                                <a class="cloud-button" href="#"></a>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="search-contact-dropdown" id="search-dropdown">
                    
                <div class="col-lg-9 col-md-9 col-sm-9 zindex">
                    <ul class="selected-id-list list-unstyled">
                        <input name="addDialog" class="hide" value=""/>
                        <div class="clear"></div>
                        <div class="error-message">Search contacts for new dialog!<div class="error-message-arr"></div></div>
                    </ul>
                    <div class="contact-actions transaction-buttons-cont">
                        <a class="button search"  id="add_contact"  href="#"></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <a style="text-transform: none" class="add-new addMore rounded-buttons pull-right" href="#">
                    Add Contact
                    </a>
                </div>
                    <div class="popup-contacts-list">
                        <div class="arr"></div>
                        <div class="search-bar">
                            <input type="text" class="search-list-input" id="linkName"/>
                        </div>
                        <div class="scroll-cont">
                                <?php Widget::create('ContactListWidget', 'ContactListWidget', array('type' => 'contactList'))->html() ?>
                        </div>
                        <script>
                                $(document).ready(function(){
                                        $('.contact-search-but').searchContactButtonByName({
                                                inputSelectorForName : '#linkName',
                                                searchLineSelector: '#linkName',
                                                parentSelector: '.popup-contacts-list .scroll-block'
                                        })
                                })
                        </script>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="activation-arr-cont">
                <a href="#" class="activation-arr <?if ($dialogsHeader!=2) {?>opened<?}?>"></a>
            </div>
            <div class="dialogues-list-cont" id="dialogues-list-cont">
            <div class="dialogues-loading hide"></div>
            <ul class="dialogues-list list-unstyled">
            <?php
                if ($msgs) {
                    foreach ($msgs as $key => $msg) { 
                        echo $msg['msg'];
                    }
                }
            ?>    
            </ul>
            </div>
            <div class="comments-form-cont xabina-form-narrow">
                <div class="form-cell">
                    <div class="form-lbl">
                        Comments
                        <span class="tooltip-icon" title="tooltip text"></span>
                       
                            <span class="drdn-cont" >
                                <a class="comments-plus" href="#" data-toggle="dropdown"></a>
                                <ul class="dropdown-menu contact-select-dropdown comments-actions-dropdown list-unstyled" role="menu" >
                                    <li class="arr"></li>
                                    <li class="clearfix">
                                        <a href="#" class="action btnAddFile" onClick="newSendFile();return false;">Отправить файл</a>
                                    </li>
                                    <li class="clearfix">
                                        <a href="#" class="action btnAddContact" onClick="newSendContact();return false;"> Отправить контакты</a>
                                    </li>
                                    <?/*
                                    <li class="clearfix">
                                        <a href="#" class="action ">Отправить видео-сообщение</a>
                                    </li>
                                    <li class="clearfix">
                                        <a href="#" class="action ">Добавить абонентов</a>
                                    </li>
                                    */?>
                                </ul>
                            </span>
                        <? if (count($dialog['users'])>2){?>
                            <span class="drdn-cont viewSettings" style="margin:  0 0 0 10px" >
                                <a href="#" class="button-mini planet" data-toggle="dropdown"></a>
                                <ul class="dropdown-menu group-footer-select-dropdown contact-select-dropdown list-actions-dropdown list-unstyled" role="menu" >
                                    <li class="arr"></li>
                                    <li class="clearfix">
                                        <div class="group-footer-h">
                                            <div class="with-ico planet active">
                                                <span>Доступно всем</span>
                                            </div>
                                            <div class="with-ico lock">
                                                <span>Только мне</span>
                                            </div>
                                            <div class="with-ico group">
                                                <span>Группе</span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                        foreach ($dialog['users'] as $user) { 
                                            if ($user->id==$user_id)
                                                continue;
                                    ?>
                                            <li class="clearfix withIdFor">
                                                <span class="action gr-a ">
                                                    <div class="checkbox-custom mini ">
                                                        <label>
                                                            <input type="checkbox" class="<?=$user->id?>">
                                                        </label>
                                                    </div>
                                                    <?=($user->first_name ? $user->first_name.' ' : '').($user->last_name ? $user->last_name : '')?>
                                                </span>
                                            </li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </span>
                        <?}?>
                        <div class="activity-status pull-right">
                            <?php
                                $activityState = Yii::app()->user->getActivityStatus($user_id); 
                                if ($activityState == Users::USER_ACTIVITY_STATUS_ONLINE){
                                    $cssClassMy = 'ok';
                                    $cssClassMyPic = 'validation_status_ok.png';
                                    $cssClassMyVal = 1;
                                } elseif ($activityState == Users::USER_ACTIVITY_STATUS_BUSY) {
                                    $cssClassMy = 'time';
                                    $cssClassMyPic = 'time_ico.png';
                                    $cssClassMyVal = 2;
                                } else {
                                    $cssClassMy = 'err';
                                    $cssClassMyPic = 'validation_status_er.png';
                                    $cssClassMyVal = 0;
                                }
                            ?>
                            В сети
                            <div class="select-custom-activity-cont">
                                <div class="select-img">
                                    <div class="select-custom-activity" data-toggle="dropdown">
                                                    <span class="lbl selected-img">
                                                        <img src="/images/<?=$cssClassMyPic?>" alt=""/>
                                                    </span>
                                        <input type="hidden" value="<?=$cssClassMyVal?>" />
                                    </div>
                                    <ul class="dropdown-menu status-dropdown img-dropdown" role="menu">
                                        <li>
                                            <a href="#" data-id="1">
                                                <img src="/images/validation_status_ok.png" alt=""/>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-id="2">
                                                <img src="/images/time_ico.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-id="0">
                                                <img src="/images/validation_status_er.png" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-input">
                        <form action="#" name="msgSendForm" enctype="multipart/form-data">
                            <input name="dialogId" value="<?php echo $dialog['dialog']->id;?>" class="hide">
                            <div class="custom-input pull-left">
                               <textarea class="custom-textarea-input" id="msgTextarea" placeholder="Text here..."></textarea>
                                <div class="upload-file hide">   
                                    <div class="sendFileForm">
                                        <span></span>
                                        <input type="file" name="sendFile[]" onchange="addNewSendFile();"  multiple="true">
                                        <div class="transaction-buttons-cont btnRemoveDownFile">
                                            <a href="#" class="button remove-mini-grey" onClick="deleteSendFile($(this));return false;"></a>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                               <div class="sendContact hide">
                                    <div class="search-bar">
                                        <div class="btnClosSendContact" onClick="newSendContactHide();"></div>
                                        <input type="text" class="search-list-input" id="linkNameSec"/>
                                    </div>
                                    <div class="scroll-cont">
                                        <?php Widget::create('ContactListWidget', 'ContactListWidget', array('type' => 'ContactListForSend'))->html() ?>  
                                    </div>
                                    <script>
                                            $(document).ready(function(){
                                                    $('.contact-search-but').searchContactButtonByName({
                                                            inputSelectorForName : '#linkNameSec',
                                                            searchLineSelector: '#linkNameSec',
                                                            parentSelector: '.sendContact .scroll-block'
                                                    })
                                            })
                                    </script>                                                             
                               </div>
                            </div>
                            <input type="submit" value="Sent" class="xabina-submit right send pull-right" id="msgSend" style="margin: 0"/>
                        </form>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>


            </div>
            <div class="dialogues-form">

            </div>
            </div>
   
        <div class="xabina-form-container">
            <div class="form-submit">
                <div class="submit-button button-back" onclick="window.location = '/dialogs/'">Back</div>
            </div>
        </div>
    </div>