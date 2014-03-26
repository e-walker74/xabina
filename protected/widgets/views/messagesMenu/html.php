<?$action = Yii::app()->controller->action ->id;?>
<table class="messages-menu-table">
    <tbody>
    <tr>
        <td width="20%">
        	<a class="menu-link<?=$action=='index' ? ' current' : ''?>" href="<?=Yii::app()->createUrl('/message') ?>/">
                <?= Yii::t('Front', 'Inbox'); ?>
            </a>
        </td>
        <td width="20%">
        	<a class="menu-link<?=$action=='outbox' ? ' current' : ''?>" href="<?=Yii::app()->createUrl('/message/outbox') ?>/">
                <?= Yii::t('Front', 'Outbox'); ?>
            </a>
        </td>
        <td width="20%">
        	<a class="menu-link<?=$action=='archive' ? ' current' : ''?>" href="<?=Yii::app()->createUrl('/message/archive') ?>/">
                <?= Yii::t('Front', 'Archive'); ?>
            </a>
        </td>
        <td width="20%">
       		<a class="menu-link<?=$action=='draft' ? ' current' : ''?>" href="<?=Yii::app()->createUrl('/message/draft') ?>/">
                <?= Yii::t('Front', 'Drafts'); ?>
            </a>
        </td>
        <td width="20%">
        	<a class="new-message-button" href="<?=Yii::app()->createUrl('/message/new') ?>/">
                <?= Yii::t('Front', 'New message'); ?>
            </a>
        </td>
    </tr>
    </tbody>
</table>