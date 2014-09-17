<a href="#" data-toggle="dropdown" role="button"><?$count = $model->search()->getTotalItemCount();if($count){?><span><?= $count ?></span><?}?></a>
<div class="dropdown-menu notification-popup dialogues-popup" role="menu">
<div class="arrow_gray"></div>
<div class="popup-notify-select-cont">
    <div class="select-custom select-narrow ">
        <span class="select-custom-label">Notification Type</span>
        <select name="" class=" select-invisible country-select">
            <option value="">USD</option>
            <option value="">EUR</option>
            <option value="">RUB</option>
        </select>
    </div>
</div>


<div class="dialogues-content">
<div class="dialogues-list-cont">
<ul class="dialogues-popup-list list-unstyled">
<?php $this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_notif_view',
	'template'=>'{items}'
)); ?>
<li class="message-dialogues n-m info">
    <div class="header-cont">
        <div class="user-photo group-photo pull-left">
            <img src="../../images/dialogues_photo_xabina.png" alt="">
        </div>
        <div class="dialogue-info n-un pull-left">
            <div class="user-name  pull-left">Xabina advertisement</div>
            <div class="clearfix"></div>
            <div class="datetime n-dt">17.05.2014 16:00</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="content n-c">
        <span class="bold">Виктор Андреевич</span>, добро пожаловать!
        Lorem ipsum dolor sit amet, consectetuer adipiscing...
    </div>
    <a class="view-more" href="#">View more</a>
</li>
<li class="message-dialogues n-m info-b">
    <div class="header-cont">
        <div class="user-photo group-photo pull-left">
            <img src="../../images/dialogues_photo_xabina.png" alt="">
        </div>
        <div class="dialogue-info n-un pull-left">
            <div class="user-name  pull-left">Xabina advertisement</div>
            <div class="clearfix"></div>
            <div class="datetime n-dt">17.05.2014 16:00</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="content n-c">
        <span class="bold">Do you want going to New York?</span> <br/>
        Aenean commodo ligula eget dolor. <a class="violet-link" href="#">Read more</a>
    </div>
</li>
<li class="message-dialogues n-m danger">
    <div class="header-cont">
        <div class="user-photo group-photo pull-left">
            <img src="../../images/dialogues_photo_xabina.png" alt="">
        </div>
        <div class="dialogue-info n-un  pull-left">
            <div class="user-name pull-left">Administrator</div>
            <div class="delim pull-left">|</div>
            <div class="settings pull-left">Settings</div>
            <div class="clearfix"></div>
            <div class="datetime n-dt">17.05.2014 16:00</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="content n-c">
        To continue to use the bank, please
        <a class="violet-link" href="#">upload a new passport</a>
    </div>
</li>
<li class="message-dialogues n-m danger-b">
    <div class="header-cont">
        <div class="user-photo group-photo pull-left">
            <img src="../../images/dialogues_photo_xabina.png" alt="">
        </div>
        <div class="dialogue-info n-un pull-left">
            <div class="user-name  pull-left">Administrator</div>
            <div class="delim pull-left">|</div>
            <div class="settings pull-left">Settings</div>
            <div class="clearfix"></div>
            <div class="datetime n-dt">17.05.2014 16:00</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="content n-c">
        To continue to use the bank, please
        <a class="violet-link" href="#">upload a new passport</a>
    </div>
</li>

<li class="message-dialogues n-m success">
    <div class="header-cont">
        <div class="user-photo group-photo pull-left">
            <img src="../../images/dialogues_photo_xabina.png" alt="">
        </div>
        <div class="dialogue-info n-un pull-left">
            <div class="user-name pull-left">Administrator</div>
            <div class="delim pull-left">|</div>
            <div class="area pull-left">Invoicing</div>
            <div class="clearfix"></div>
            <div class="datetime n-dt">17.05.2014 16:00</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="content n-c">
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
        Aenean commodo ligula eget dolor. <a class="violet-link"
                                             href="#">Read more</a>
    </div>
    <div class="attachments-cont">
        <div class="files-many"></div>
        <div class="files-header">
            <a href="#" class="news-files-toggle  closed">
                <span>2 Files</span>
            </a>

            <div class="transaction-buttons-cont" style="margin: -3px 0 0">
                <a href="#" class="button download-mini"></a>
            </div>
        </div>
        <div class="clearfix"></div>
        <ul class="list-unstyled attachments-files-list" style="display: none">
            <li>
                Invoice.doc
                <div class="transaction-buttons-cont" style="margin: -3px 0 0">
                    <a href="#" class="button download-mini"></a>
                </div>
            </li>
            <li>
                Konstantin Konstantinovski Invoice.pdf
                <div class="transaction-buttons-cont" style="margin: -3px 0 0">
                    <a href="#" class="button download-mini"></a>
                </div>
            </li>
        </ul>
    </div>
</li>
<li class="message-dialogues n-m success-b">
    <div class="header-cont">
        <div class="user-photo group-photo pull-left">
            <img src="../../images/dialogues_photo_xabina.png" alt="">
        </div>
        <div class="dialogue-info n-un pull-left">
            <div class="user-name pull-left">Administrator</div>
            <div class="delim pull-left">|</div>
            <div class="area pull-left">Invoicing</div>
            <div class="clearfix"></div>
            <div class="datetime n-dt">17.05.2014 16:00</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="content n-c">
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
        Aenean commodo ligula eget dolor. <a class="violet-link"
                                             href="#">Read more</a>
    </div>
    <div class="attachments-cont">
        <div class="files-many"></div>
        <div class="files-header">
            <a href="#" class="news-files-toggle  closed">
                <span>2 Files</span>
            </a>

            <div class="transaction-buttons-cont" style="margin: -3px 0 0">
                <a href="#" class="button download-mini"></a>
            </div>
        </div>
        <div class="clearfix"></div>
        <ul class="list-unstyled attachments-files-list" style="display: none">
            <li>
                Invoice.doc
                <div class="transaction-buttons-cont" style="margin: -3px 0 0">
                    <a href="#" class="button download-mini"></a>
                </div>
            </li>
            <li>

                Konstantin Konstantinovski Invoice.pdf

                <div class="transaction-buttons-cont" style="margin: -3px 0 0">
                    <a href="#" class="button download-mini"></a>
                </div>
            </li>
        </ul>
    </div>
</li>
<li class="message-dialogues n-m warn">
    <div class="header-cont">
        <div class="user-photo group-photo pull-left">
            <img src="../../images/dialogues_photo_xabina.png" alt="">
        </div>
        <div class="dialogue-info n-un pull-left">
            <div class="user-name pull-left">Administrator</div>
            <div class="delim pull-left">|</div>
            <div class="area pull-left">Invoicing</div>
            <div class="clearfix"></div>
            <div class="datetime n-dt">17.05.2014 16:00</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="content n-c">
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
        Aenean commodo ligula eget dolor. <a class="violet-link"
                                             href="#">Read more</a>
    </div>
    <div class="mark-as-read-cont">
        <a class="invert-button yellow pull-right" href="#">Mark as read</a>
    </div>
</li>
<li class="message-dialogues n-m warn-b">
    <div class="header-cont">
        <div class="user-photo group-photo pull-left">
            <img src="../../images/dialogues_photo_xabina.png" alt="">
        </div>
        <div class="dialogue-info n-un pull-left">
            <div class="user-name pull-left">Administrator</div>
            <div class="delim pull-left">|</div>
            <div class="area pull-left">Invoicing</div>
            <div class="clearfix"></div>
            <div class="datetime n-dt">17.05.2014 16:00</div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="content n-c">
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
        Aenean commodo ligula eget dolor. <a class="violet-link"
                                             href="#">Read more</a>
    </div>
    <div class="mark-as-read-cont">
        <a class="invert-button yellow pull-right" href="#">Mark as read</a>
    </div>
</li>

</ul>
</div>

</div>
<a href="/banking/notifications" class="notification-all">See all notification</a>
</div>