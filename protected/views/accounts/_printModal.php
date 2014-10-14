<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 02.10.14
 * Time: 1:53
 * @var Transactions $model
 */ ?>
<div class="modal fade" id="downloadFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog xabina-modal">
        <form action="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $model->url)) ?>">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="/css/layout/account/img/close.png"></button>
            <h3><?= Yii::t('Transactions', 'Print file') ?></h3>
        </div>
        <div class="note-row ">
            <?= Yii::t('Transactions', 'Select the sections that will be included in the transcript.') ?>
        </div>
        <div class="downloads-options-cont " style="display: none">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="checkbox-custom narrow-17">
                        <label class="checked">
                            <input name="option[]" value="all" type="checkbox" checked="checked">
                        </label>
                    </div>
                    <?= Yii::t('Transactions', 'All') ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">

                    <div class="checkbox-custom narrow-17">
                        <label class="">
                            <input name="option[]" value="phone" type="checkbox">
                        </label>
                    </div>
                    <?= Yii::t('Transactions', 'Phone') ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="checkbox-custom narrow-17">
                        <label class="">
                            <input name="option[]" value="instm" type="checkbox">
                        </label>
                    </div>
                    <?= Yii::t('Transactions', 'Instant Messager') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="checkbox-custom narrow-17">
                        <label class="">
                            <input name="option[]" value="personal" type="checkbox">
                        </label>
                    </div>
                    <?= Yii::t('Transactions', 'Personal info') ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">

                    <div class="checkbox-custom narrow-17">
                        <label class="">
                            <input name="option[]" value="address" type="checkbox">
                        </label>
                    </div>
                    <?= Yii::t('Transactions', 'Address') ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="checkbox-custom narrow-17">
                        <label class="">
                            <input name="option[]" value="payment" type="checkbox">
                        </label>
                    </div>
                    <?= Yii::t('Transactions', 'Payment method') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="checkbox-custom narrow-17">
                        <label class="">
                            <input name="option[]" value="email" type="checkbox">
                        </label>
                    </div>
                    <?= Yii::t('Transactions', 'E-mail') ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">

                    <div class="checkbox-custom narrow-17">
                        <label class="">
                            <input name="option[]" value="socials" type="checkbox">
                        </label>
                    </div>
                    <?= Yii::t('Transactions', 'Sotial Networks') ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="checkbox-custom narrow-17">
                        <label class="">
                            <input name="option[]" value="account" type="checkbox">
                        </label>
                    </div>
                    <?= Yii::t('Transactions', 'Account') ?>
                </div>
            </div>
        </div>
        <div class="modal-submit-cont upload">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
<!--                    <input class="rounded-buttons print" onclick="return window.print();" type="button" value="--><?//= Yii::t('Transactions', 'Print') ?><!--">-->
                    <input class="rounded-buttons print" name="exportType" type="submit" value="<?= Yii::t('Transactions', 'Print') ?>">
                </div>
<!--                <div class="col-lg-4 col-md-4 col-sm-4 relative">-->
<!--                    <input class="rounded-buttons mail-violet" data-toggle="dropdown" type="button" value="E-Mail">-->
<!--                    <div class="dropdown-menu formats-dropdown transaction-buttons-cont">-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-6 col-md-6 col-sm-6 format-cell">-->
<!--                                <a class="button jpg" href="#"></a> &mdash; jpg-->
<!--                            </div>-->
<!--                            <div class="col-lg-6 col-md-6 col-sm-6 format-cell">-->
<!--                                <a class="button csv" href="#"></a> &mdash; csv-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-6 col-md-6 col-sm-6 format-cell">-->
<!--                                <a class="button doc" href="#"></a> &mdash; doc-->
<!--                            </div>-->
<!--                            <div class="col-lg-6 col-md-6 col-sm-6 format-cell">-->
<!--                                <a class="button pdf" href="#"></a> &mdash; pdf-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="col-lg-6 col-md-6 col-sm-6 relative">
                    <input class="rounded-buttons download" type="button" data-toggle="dropdown"  value="Download">
                    <div class="dropdown-menu formats-dropdown transaction-buttons-cont">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 format-cell">
<!--                                <a class="button csv" href="#"></a> &mdash; csv-->
                                <input type="submit" class="button csv" name="exportType" value="csv" style="color: transparent;"/>
                                <a href="javaScript:void(0)" onclick="$(this).prev().click()">&mdash; csv</a>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 format-cell">
                                <!--                                <a class="button pdf" href="#"></a> &mdash; pdf-->
                                <input type="submit" class="button pdf" name="exportType" value="pdf" style="color: transparent;"/>
                                <a href="javaScript:void(0)" onclick="$(this).prev().click()">&mdash; pdf</a>
                            </div>
                        </div>
                        <div class="row">
<!--                            <div class="col-lg-6 col-md-6 col-sm-6 format-cell">-->
<!--                                <a class="button doc" href="#"></a> &mdash; doc-->
<!--                            </div>-->
<!--                            <div class="col-lg-6 col-md-6 col-sm-6 format-cell">-->
<!--                                <a class="button jpg" href="#"></a> &mdash; jpg-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
    $('.note-row').on('click', function(){
        $(this).toggleClass('open').next().slideToggle();
    })
</script>
<?php Yii::app()->clientScript->registerScript('checkoxes', "$('.downloads-options-cont input[value=all]').change(function(){
        if($(this).prop('checked')){
            $('.downloads-options-cont input:not([value=all])').attr('checked', true).closest('label').addClass('checked')
        } else {
            $('.downloads-options-cont input:not([value=all])').attr('checked', false).closest('label').removeClass('checked')
        }
    })", CClientScript::POS_END); ?>