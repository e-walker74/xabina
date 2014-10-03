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
    .dialogue-photo img {
        border: none;        
    }
    .dialogue-name a span {
        color: #8A8997;        
    }
    .dialogue-name a:hover span {
        color: #2A6496;        
    }
    .scroll-cont {         
        background: #F1F1F3;
    }
    .contacts-list-cont {
        max-height: 265px;
    }
    .selected-id-list .error-message {
        top: 45px;
        margin-top: -6px;
        width: 100%;
        z-index: 1000;
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
<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="h1-header"><?= Yii::t('Front', 'Dialogs'); ?></div><br/>      
        
    <div class="dialoques-table dialogues-content" id="dialogIndex">
        <div class="dialogues-title">
            Dialogues
        </div>
        <div class="dialogues-messages"  style="background: #f1f1f3">
        <div class="dialogues-header <?if ($dialogsHeader!=2) {?>opened<?}?>">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <ul class="selected-id-list list-unstyled">
                        <input name="newDialog" class="hide" value=""/>
                        <div class="clear"></div>
                        <div class="error-message">Search contacts for new dialog!<div class="error-message-arr"></div></div>
                    </ul>
                    <div class="contact-actions transaction-buttons-cont">
                        <a class="button search"  id="add_contact"  href="#"></a>

                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <a style="text-transform: none" class="add-new addNew rounded-buttons pull-right" href="#">
                    Add Contact
                    </a>
                </div>
                <div class="search-contact-dropdown search-contact-dialogues-all" id="search-dropdown">
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
                                            parentSelector: '.scroll-block'
                                    })
                            })
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="activation-arr-cont">
            <a href="#" class="activation-arr <?if ($dialogsHeader!=2) {?>opened<?}?>"></a>
        </div>
            <ul class="dialogues-all-list list-unstyled">
                <?php
                    if ($dialogs) {
                        foreach ($dialogs as $key => $dialog) {
                            $dialog['dialog'] -> getOneDialog();
                        }
                    }
                ?>      
            </ul>
        </div>
        <div class="dialogues-form">

        </div>
    </div>
</div>