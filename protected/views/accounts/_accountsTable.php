<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 08.09.14
 * Time: 16:21
 * @var Accounts $accounts
 */
?>

<?php $this->widget('ExtGridView', array(
    'id'=>'accounts-grid',
    'dataProvider'=>$accounts->searchWithGroup(),
    'summaryText' => '',
//    'headerCssClass' => 'table-header',
    'itemsCssClass' => 'table xabina-table accounts-table right-button-clickable',
//		'rowHtmlOptionsExpression' => 'array("class" => "clickable-row", "data-url" => Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number)))',
    /*'htmlOptions' => array(
        'class' => 'table xabina-table',
    ),*/
    //'filter'=>$accounts,
    //'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('view').'/id/"+$.fn.yiiGridView.getSelection(id);}',
    //'cssFile'=>Yii::app()->getBaseUrl(true).'/css/styles-admin.css',
    'columns'=>array(
        array(
            'header' => Yii::t('Front', 'Account'),
            'value' => '"

                    ".$data->user->fullName." <br>
                    <span class=\"bold\">".chunk_split($data->number, 4)."</span> <br>
                    <span class=\"grey font-size-12\">Family</span>
                    <a href=\"".Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number))."\" class=\"right-click-shadow\"></a>

                "',
            'type' => 'html',
            'headerHtmlOptions' => array('style' => 'width: 28%'),
        ),
        array(
            'header' => Yii::t('Front', 'Type'),
            'value' => '"Платежный <br/>
            <span class=\"grey font-size-12\">".Yii::t("Front", "account_sub_type_" . $data->sub_type) ."</span><a href=\"".Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number))."\" class=\"right-click-shadow\"></a>"',
            'type' => 'html',
            'headerHtmlOptions' => array('style' => 'width: 16%'),
        ),
        array(
            'header' => Yii::t('Front', 'Balance'),
            'value' => '(($data->getGroupBalance() >= 0) ? "<span class=\"sum-inc\">".number_format($data->getGroupBalance(), 2, ".", " ")."</span>" : "<span class=\"sum-dec\">".number_format($data->getGroupBalance(), 2, ".", " ")."</span>").
                "<a href=\"".Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number))."\" class=\"right-click-shadow\"></a>"',
            'htmlOptions' => array('class' => 'text-right'),
            'headerHtmlOptions' => array('class' => 'text-right', 'style' => 'width: 19%'),
            'type' => 'html',
        ),
        array(
            'header' => Yii::t('Front', 'Currency'),
            'value' => '$data->currency->code.
                "<a href=\"".Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number))."\" class=\"right-click-shadow\"></a>"',
            'type' => 'html',
            'headerHtmlOptions' => array('style' => 'width: 17%'),
        ),
        array(
            'header' => Yii::t('Front', 'Status'),
            'value' => 'AccountService::getAccountStatusIcon($data->status) . (($data->is_master) ? " <span class=\"primary-button is-primary\"></span>" : " <a href=\"javaScript:\" onclick=\"Accounts.makeAccountPrimary(\'".Yii::app()->createUrl("/accounts/makePrimary")."\', ".$data->id.")\" class=\"primary-button m-primary\"></a>")',
            'type' => 'raw',
            'headerHtmlOptions' => array('style' => 'width: 13%'),
        ),
        array(
            'header' => '',
            'value' => '

				"<div class=\"contact-actions transaction-buttons-cont\">
                    <div class=\"btn-group\">
                        <a class=\"button menu\" data-toggle=\"dropdown\" href=\"#\"></a>
                        <ul class=\"dropdown-menu\">
                            <li>
                                <a class=\"button eye\" href=\"".Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number))."\"></a>
                            </li>
                            <li>
                                <a class=\"button edit\" href=\"".Yii::app()->createUrl("/accounts/management", array("url" => $data->number))."\"></a>
                            </li>
                            <li>
                                <a class=\"button chart\" href=\"".Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number))."\"></a>
                            </li>
                        </ul>
                    </div>
                </div>"',
            'htmlOptions' => array('class' => '', 'style' => 'overflow:visible!important;'),
            'type' => 'html',
            'headerHtmlOptions' => array('style' => 'width: 8%'),
        ),
    ),
)); ?>