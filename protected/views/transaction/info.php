<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 02.09.14
 * Time: 18:52
 * @var Transactions $model
 */
?>

<div class="modal fade" id="addTranModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Linked transaction</h3>
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-block">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-sm-1" style="margin:5px 0 0 ">
                            Счет
                        </div>
                        <div class="col-lg-11 col-md-11col-sm-11">
                            <div class="select-custom account-select">
                            <span class="select-custom-label">
                            Виктор Купец
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            0185 2156 4657
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            10 000 EUR
                            </span>
                                <select name="" class=" select-invisible">
                                    <option value="">
                                        Виктор Купец
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        0185 2156 4657
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        10 000 EUR
                                    </option>
                                    <option value="">
                                        Виктор Купец
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        0185 2156 4657
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        10 000 EUR
                                    </option>
                                    <option value="">
                                        Виктор Купец
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        0185 2156 4657
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        10 000 EUR
                                    </option>
                                    <option value="">
                                        Виктор Купец
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        0185 2156 4657
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        10 000 EUR
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="transaction-table-overflow">
                    <table class="table">
                        <tr class="header_tr">
                            <td width="6%"></td>
                            <td width="20%">Date</td>
                            <td width="25%">Account</td>
                            <td width="25%" class="text-right">Value</td>
                            <td width="17%" class="text-right">Balance</td>
                            <td width="7%"></td>
                        </tr>
                        <tr>
                            <td width="6%"><label class="modal-galka-checkbox"><input type="checkbox"/></label></td>
                            <td width="20%">12.01.2014</td>
                            <td width="25%">
                                <strong class="holder">Viktor Kupets</strong><br>
                                <span class="account"> 0121 0101 2585 01541</span>
                            </td>
                            <td width="25%" class="text-right"><span class="sum-inc">+1 000 000</span> EUR</td>
                            <td width="17%" class="text-right">1 000</td>
                            <td width="7%"  style="overflow: visible!important">
                                <div class="contact-actions transaction-buttons-cont">
                                    <div class="btn-group">
                                        <a class="button menu" data-toggle="dropdown" href="#"></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="button edit" href="edit_contact.html"></a>
                                            </li>
                                            <li>
                                                <a class="button refresh" href="#"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="note-tr">
                            <td width="6%"></td>
                            <td colspan="5">
                                <div class="note-cont">
                                    Advertising giants Publicis and Omnicom announced in July that they were combining in
                                    <a class="more-link" href="#">More</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="6%"><label class="modal-galka-checkbox"><input type="checkbox"/></label></td>
                            <td width="20%">12.01.2014</td>
                            <td width="25%">
                                <strong class="holder">Viktor Kupets</strong><br>
                                <span class="account"> 0121 0101 2585 01541</span>
                            </td>
                            <td width="25%" class="text-right"><span class="sum-dec">+1 000 000</span> EUR</td>
                            <td width="17%" class="text-right">1 000 000</td>
                            <td width="7%"  style="overflow: visible!important">
                                <div class="contact-actions transaction-buttons-cont">
                                    <div class="btn-group">
                                        <a class="button menu" data-toggle="dropdown" href="#"></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="button edit" href="edit_contact.html"></a>
                                            </li>
                                            <li>
                                                <a class="button refresh" href="#"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="note-tr">
                            <td width="6%"></td>
                            <td colspan="5">
                                <div class="note-cont">
                                    Advertising giants Publicis and Omnicom announced in July that they were combining in
                                    <a class="more-link" href="#">More</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div><input class="rounded-buttons marg-right-15 submit pull-left" type="submit" value="Submit"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="editCommentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Memo</h3>
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    Memo <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
            </div>
            <div class="memo_edit"><textarea class="ckeditor"></textarea></div>
            <div><input class="rounded-buttons marg-right-15 submit pull-left" type="submit" value="Отправить"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="showFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Загрузка файлов</h3>
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    Файл <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="form-block">
                    <input class="add-input pull-left" type="text">
                    <a href="transfer_overview.html" class="rounded-buttons pull-right add-new">ADD NEW</a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table">
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="file-img-td">
                            <img src="img/jpg_img.png"/>
                        </td>
                        <td class="name_td">Check.jpg</td>
                        <td class="value_td">Выписка с банка</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button download" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="file-img-td">
                            <img src="img/docx_img.png"/>
                        </td>
                        <td class="name_td">Check.docx</td>
                        <td class="value_td">Выписка с банка</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button download" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="file-img-td">
                            <img src="img/csw_img.png"/>
                        </td>
                        <td class="name_td">Check.csw</td>
                        <td class="value_td">Выписка с банка</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button download" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="file-img-td">
                            <img src="img/pdf_img.png"/>
                        </td>
                        <td class="name_td">Check.pdf</td>
                        <td class="value_td">Выписка с банка</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button download" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="file-img-td">
                            <img src="img/pdf_img.png"/>
                        </td>
                        <td class="name_td">Check.pdf</td>
                        <td class="value_td">Выписка с банка</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button download" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Загрузка файлов</h3>
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    Файл <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="form-block">
                    <input class="add-input pull-left" type="text">
                    <a href="transfer_overview.html" class="rounded-buttons pull-right add-new">ADD NEW</a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table">
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="file-img-td">
                            <img src="img/jpg_img.png"/>
                        </td>
                        <td class="name_td">Check.jpg</td>
                        <td class="value_td"><input type="text" class="add-input long-input" value="Выписка с банка" /></td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="transaction-buttons-cont">
                                <a href="#" class="button ok"></a>
                                <a href="#" class="button remove"></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="file-img-td">
                            <img src="img/docx_img.png"/>
                        </td>
                        <td class="name_td">Check.docx</td>
                        <td class="value_td">Выписка с банка</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button download" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="file-img-td">
                            <img src="img/csw_img.png"/>
                        </td>
                        <td class="name_td">Check.csw</td>
                        <td class="value_td">Выписка с банка</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button download" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="file-img-td">
                            <img src="img/pdf_img.png"/>
                        </td>
                        <td class="name_td">Check.pdf</td>
                        <td class="value_td">Выписка с банка</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button download" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="file-img-td">
                            <img src="img/pdf_img.png"/>
                        </td>
                        <td class="name_td">Check.pdf</td>
                        <td class="value_td">Выписка с банка</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button download" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addReceiverModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Add receiver</h3>
        </div>
        <div class="top_text_block">
            Notice: authorization of 2nd person is required to finalize this transaction
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    Contacts <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="form-block">
                    <input class="add-input pull-left" type="text">
                    <a href="transfer_overview.html" class="rounded-buttons pull-right add-new">ADD NEW</a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table">
                    <tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox active"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td_two">Платежное имя <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span></td>
                        <td class="value_td_big" colspan="2"><input type="text" class="add-input long-input" value="Ivan Ivanov" /></td>
                    </tr>
                    <tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td_two">Имя и фамилия <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span></td>
                        <td class="value_td_small"><input type="text" class="add-input long-input" value="" placeholder="Впишите Ваше имя" /></td>
                        <td class="value_td_small"><input type="text" class="add-input long-input" value="" placeholder="Впишите Вашу фамилию" /></td>
                    </tr>
                    <tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td_two">Компания <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span></td>
                        <td class="value_td_big" colspan="2"><input type="text" class="add-input long-input" value="" placeholder="Впишите название компании" /></td>
                    </tr>
                </table>
            </div>
            <div class="submit_block"><input class="rounded-buttons marg-right-15 submit pull-left" type="submit" value="Add receiver"><input class="rounded-buttons cansel pull-left" type="submit" data-dismiss="modal" aria-hidden="true" value="Cancel"><div class="clearfix"></div></div>
        </div>
    </div>
</div>
<div class="modal fade" id="addCommentModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Подтверждение получения перевода</h3>
        </div>
        <div class="modal-body">
            <div class="messages-list-table-overflow no-all-border">
                <table class="table messages-list-table">
                    <tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox active"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td_three">E-mail <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span></td>
                        <td class="value_td_big" colspan="2"><input type="text" class="add-input long-input" value="Ivanov@gmail.com" /></td>
                    </tr>
                    <tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox active"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td_three">Телефон <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span></td>
                        <td class="value_td_big" colspan="2"><input type="text" class="add-input long-input" value="" placeholder="Впишите ваш номер телефона" /></td>
                    </tr>
                    <tr class="form-tr xabina-form-container top-border-visible no_hover">
                        <td class="new-checkbox-td"></td>
                        <td class="name_td_three vertical-align-top">Сообщение <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span></td>
                        <td class="value_td_big" colspan="2"><textarea class="ckeditor"></textarea><div class="confirm"><label class="modal-galka-checkbox"><input type="checkbox"/></label><span>Attach SWIFT confirmation</span></div></td>
                    </tr>
                    <tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td"></td>
                        <td class="name_td_three"></td>
                        <td class="value_td_big" colspan="2"><input class="rounded-buttons marg-right-15 submit pull-left" type="submit" value="Отправить"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="createContactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Create contact</h3>
        </div>
        <div class="modal-body">
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table">
                    <tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox active"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td_two">Платежное имя <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span></td>
                        <td class="value_td_big" colspan="2"><input type="text" class="add-input long-input" value="Ivan Ivanov" /></td>
                    </tr>
                    <tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td_two">Имя и фамилия <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span></td>
                        <td class="value_td_small"><input type="text" class="add-input long-input" value="" placeholder="Впишите Ваше имя" /></td>
                        <td class="value_td_small"><input type="text" class="add-input long-input" value="" placeholder="Впишите Вашу фамилию" /></td>
                    </tr>
                    <tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td_two">Компания <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span></td>
                        <td class="value_td_big" colspan="2"><input type="text" class="add-input long-input" value="" placeholder="Впишите название компании" /></td>
                    </tr>
                </table>
            </div>
            <div class="submit_block"><input class="rounded-buttons marg-right-15 submit pull-left" type="submit" value="Create contact"><input class="rounded-buttons cansel pull-left" type="submit" data-dismiss="modal" aria-hidden="true" value="Cancel"><div class="clearfix"></div></div>
        </div>
    </div>
</div>
<div class="modal fade" id="addLinkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Link payment</h3>
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    Contacts <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="form-block">
                    <input class="add-input pull-left" type="text">
                    <a href="transfer_overview.html" class="rounded-buttons pull-right add-new">ADD NEW</a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="account-search-results-cont with-alphabet ">
                <ul class="alphabet list-unstyled">
                    <li class="active"><a href="#">0-9</a></li>
                    <li class="active"><a href="#">a</a></li>
                    <li><a href="#">b</a></li>
                    <li><a href="#">c</a></li>
                    <li class="inactive"><a href="#">d</a></li>
                    <li><a href="#">e</a></li>
                    <li><a href="#">f</a></li>
                    <li><a href="#">g</a></li>
                    <li><a href="#">h</a></li>
                    <li><a href="#">i</a></li>
                    <li><a href="#">j</a></li>
                    <li><a href="#">k</a></li>
                    <li><a href="#">l</a></li>
                    <li><a href="#">m</a></li>
                    <li><a href="#">n</a></li>
                    <li class="inactive"><a href="#">o</a></li>
                    <li><a href="#">p</a></li>
                    <li class="inactive"><a href="#">q</a></li>
                    <li><a href="#">r</a></li>
                    <li><a href="#">s</a></li>
                    <li class="inactive"><a href="#">t</a></li>
                    <li><a href="#">u</a></li>
                    <li><a href="#">v</a></li>
                    <li><a href="#">w</a></li>
                    <li class="inactive"><a href="#">x</a></li>
                    <li><a href="#">y</a></li>
                    <li><a href="#">z</a></li>
                    <li><a href="#">#</a></li>
                </ul>
                <div class="letter-block">
                    <div class="letter-header">A</div>
                    <ul class="search-results-list list-unstyled">
                        <li>
                            <div class="bg-color">
                                <div class="cont_check_block"><label class="modal-galka-checkbox"><input type="checkbox"/></label></div>
                                <div class="account-photo pull-left">
                                    <img src="img/account_no_photo.png" alt="">
                                </div>
                                <div class="account-data pull-left">
                                    <div class="account-name">Anet</div>
                                    <div class="account-info">Name First Name (Company Name)</div>
                                </div>
                                <div class="transaction-buttons-cont book">
                                    <a href="#" class="book_button open"></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <ul class="pay-list list-unstyled">
                                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
                                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
                                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
                            </ul>
                        </li>
                        <li>
                            <div class="bg-color">
                                <div class="cont_check_block"><label class="modal-galka-checkbox"><input type="checkbox"/></label></div>
                                <div class="account-photo pull-left">
                                    <img src="img/account_no_photo.png" alt="">
                                </div>
                                <div class="account-data pull-left">
                                    <div class="account-name">Anet</div>
                                    <div class="account-info">Name First Name (Company Name)</div>
                                </div>
                                <div class="transaction-buttons-cont book">
                                    <a href="#" class="book_button"></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <ul class="pay-list list-unstyled" style="display: none;">
                                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
                                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
                                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
                            </ul>
                        </li>
                        <li>
                            <div class="bg-color">
                                <div class="cont_check_block"><label class="modal-galka-checkbox"><input type="checkbox"/></label></div>
                                <div class="account-photo pull-left">
                                    <img src="img/account_no_photo.png" alt="">
                                </div>
                                <div class="account-data pull-left">
                                    <div class="account-name">Anet</div>
                                    <div class="account-info">Name First Name (Company Name)</div>
                                </div>
                                <div class="transaction-buttons-cont book">
                                    <a href="#" class="book_button"></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <ul class="pay-list list-unstyled" style="display: none;">
                                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
                                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
                                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="submit_block"><input class="rounded-buttons submit pull-left" type="submit" value="Link payment"><div class="clearfix"></div></div>
        </div>
    </div>
</div>
<div class="modal fade" id="addTwoBuhModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Добавление бухгалтерского счета</h3>
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    Бухгалтерский счет <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="form-block">
                    <input class="add-input pull-left" type="text">
                    <a href="transfer_overview.html" class="rounded-buttons pull-right add-new">ADD NEW</a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table">
                    <tr class="add-tr xabina-form-container">
                        <td class="new-checkbox-td"></td>
                        <td class="name_td" style="overflow: visible!important;">
                            <div class="form-lbl margin-left">
                                Cчет <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                            </div>
                            <div class="margin-left">
                                <input type="text" class="add-input short-input" value="" />
                            </div>
                        </td>
                        <td class="value_td">
                            <div class="form-lbl">
                                Description <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                            </div>
                            <div>
                                <input type="text" class="add-input long-input" value="" />
                            </div>
                        </td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="transaction-buttons-cont">
                                <a href="#" class="button ok"></a>
                                <a href="#" class="button remove"></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="submit_block"><input class="rounded-buttons submit pull-left" type="submit" value="Submit"><div class="clearfix"></div></div>
        </div>
    </div>
</div>
<div class="modal fade" id="editBuhModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Добавление бухгалтерского счета</h3>
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    Бухгалтерский счет <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="form-block">
                    <input class="add-input pull-left" type="text">
                    <a href="transfer_overview.html" class="rounded-buttons pull-right add-new">ADD NEW</a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table">
                    <tr class="add-tr xabina-form-container">
                        <td class="new-checkbox-td"></td>
                        <td class="name_td" style="overflow: visible!important;">
                            <div class="form-lbl margin-left">
                                Cчет <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                            </div>
                            <div class="margin-left">
                                <input type="text" class="add-input short-input" value="Account" />
                            </div>
                        </td>
                        <td class="value_td">
                            <div class="form-lbl">
                                Description <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                            </div>
                            <div>
                                <input type="text" class="add-input long-input" value="NL**ABNA0000000000" />
                            </div>
                        </td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="transaction-buttons-cont">
                                <a href="#" class="button ok"></a>
                                <a href="#" class="button remove"></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="submit_block"><input class="rounded-buttons submit pull-left" type="submit" value="Submit"><div class="clearfix"></div></div>
        </div>
    </div>
</div>
<div class="modal fade" id="addBuhModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Добавление бухгалтерского счета</h3>
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    Бухгалтерский счет <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="form-block">
                    <input class="add-input pull-left" type="text">
                    <a href="transfer_overview.html" class="rounded-buttons pull-right add-new">ADD NEW</a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table">
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td">Account</td>
                        <td class="value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="submit_block"><input class="rounded-buttons submit pull-left" type="submit" value="Submit"><div class="clearfix"></div></div>
        </div>
    </div>
</div>
<div class="modal fade" id="addTwoTagModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="xabina-modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
        <h3 id="myModalLabel">Добавление тегов</h3>
    </div>
    <div class="modal-body">
        <div class="xabina-form-container">
            <div class="form-lbl">
                Tag <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
            </div>
            <div class="form-block">
                <input class="add-input pull-left" type="text">
                <a href="transfer_overview.html" class="rounded-buttons pull-right add-new">ADD NEW</a>
                <div class="clearfix">/div>
                </div>
            </div>
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table">
                    <tr class="add-tr xabina-form-container">
                        <td class="new-checkbox-td"></td>
                        <td class="tag_name_td" style="overflow: visible!important;">
                            <div class="form-lbl margin-left">
                                Tag <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                            </div>
                            <div class="margin-left">
                                <input type="text" class="add-input short-input" value="" />
                            </div>
                        </td>
                        <td class="tag_value_td">
                            <div class="form-lbl">
                                Description <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                            </div>
                            <div>
                                <input type="text" class="add-input long-input" value="" />
                            </div>
                        </td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="transaction-buttons-cont">
                                <a href="#" class="button ok"></a>
                                <a href="#" class="button remove"></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox active"><input type="checkbox"/></label>
                        </td>
                        <td class="tag_name_td">Account</td>
                        <td class="tag_value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="tag_name_td">Account</td>
                        <td class="tag_value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="submit_block"><input class="rounded-buttons submit pull-left" type="submit" value="Submit"><div class="clearfix"></div></div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="editTagModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Добавление тегов</h3>
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    Tag <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="form-block">
                    <input class="add-input pull-left" type="text">
                    <a href="transfer_overview.html" class="rounded-buttons pull-right add-new">ADD NEW</a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table">
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox active"><input type="checkbox"/></label>
                        </td>
                        <td class="tag_name_td"><input type="text" class="add-input short-input" value="Account" /></td>
                        <td class="tag_value_td"><input type="text" class="add-input long-input" value="NL**ABNA0000000000" /></td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="transaction-buttons-cont">
                                <a href="#" class="button ok"></a>
                                <a href="#" class="button remove"></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="tag_name_td">Account</td>
                        <td class="tag_value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="submit_block"><input class="rounded-buttons submit pull-left" type="submit" value="Submit"><div class="clearfix"></div></div>
        </div>
    </div>
</div>
<div class="modal fade" id="addTagModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Добавление тегов</h3>
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    Tag <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="form-block">
                    <input class="add-input pull-left" type="text">
                    <a href="transfer_overview.html" class="rounded-buttons pull-right add-new">ADD NEW</a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table">
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox active"><input type="checkbox"/></label>
                        </td>
                        <td class="tag_name_td">Account</td>
                        <td class="tag_value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox"><input type="checkbox"/></label>
                        </td>
                        <td class="tag_name_td">Account</td>
                        <td class="tag_value_td">NL**ABNA0000000000</td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="contact-actions transaction-buttons-cont">
                                <div class="btn-group">
                                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="#"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" href="#"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="submit_block"><input class="rounded-buttons submit pull-left" type="submit" value="Submit"><div class="clearfix"></div></div>
        </div>
    </div>
</div>


<div class="col-lg-9 col-md-9 col-sm-9">
<div class="edit-tabs contact-tabs">
<ul class="list-unstyled">
    <li style="width: 31%"><a href="#tab1">Transaction Overview</a></li>
    <li style="width: 23%"><a href="#tab2">Dialogues</a></li>
    <li style="width: 23%"><a href="#tab3">Drive</a></li>
    <li style="width: 23%"><a href="#tab4">Memo</a></li>
</ul>
<div class="clearfix"></div>
<div class="one_tab" id="tab1">
    <table class="xabina-table-upload transaction-table-cont">
        <tr class="header-tr">
            <td>
                Transaction #548963258745215
                <div class="transaction-buttons-cont">
                    <div class="btn-group">
                        <a class="button menu" data-toggle="dropdown" href="#"></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="button send" href="#"></a>
                            </li>
                            <li>
                                <a class="button i" href="#"></a>
                            </li>
                            <li>
                                <a class="button upload" href="#"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
        <tr class="form-tr">
            <td>
                <div class="transaction-info-cont new_transaction">
                    <table class="transaction-info-table table new_transaction_table">
                        <tr>
                            <td class="name" width="20%">Date</td>
                            <td width="70%">12.01.2014</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="name">Sender</td>
                            <td class="normal-line">John Doe<br/>xxxx xxxx 0987 / PayPal / Type info</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="name">Receiver</td>
                            <td class="normal-line">
                                John Doe<br/>xxxx xxxx 0987
                            </td>
                            <td>
                                <div class="new_tran_but"><a href="#createContactModal" role="button" data-toggle="modal" class="button book"></a></div>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">Value</td>
                            <td><span class="green_text">+200</span> EUR</td>
                            <td>
                                <div class="new_tran_but">
													<span class="drdn-cont">
														<a href="#" class="button portmone" data-toggle="dropdown"></a>
														<div class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list" role="menu">
                                                            <div class="arr"></div>
                                                            <div class="content-dropdown">
                                                                <div class="drop_title">
                                                                    Валюта
                                                                    <a class="close-dropdown"></a>
                                                                </div>
                                                                <div class="drop_bg_block">
                                                                    Выберите валюту, в которой хотите получить перевод.
                                                                </div>
                                                                <div class="drop_main_block">
                                                                    <div class="select-custom account-select">
                                                                        <span class="select-custom-label">EUR</span>
                                                                        <select name="" class=" select-invisible">
                                                                            <option value="">
                                                                                EUR
                                                                            </option>
                                                                            <option value="">
                                                                                RUB
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="drop_dop_text">
                                                                        <span class="bold_text">100 000 EUR = 4 000 000 RUB</span>
                                                                        по курсу 1EUR:1.4 USD НБ
                                                                        на 28.08.2014
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
													</span>
                                </div>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="name">Description</td>
                            <td>Advertising giants Publicis and Omnicom announced</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="name">Status</td>
                            <td><span class="tran_status ok">- Approved</span></td>
                            <td></td>
                        </tr>
                        <tr class="bg_tr">
                            <td class="name">Memo</td>
                            <td>
                                <span class="small-text"><a href="#addCommentModal" role="button" data-toggle="modal" role="button" data-toggle="modal">Вы можете добавить комментарий к этой транзакции</a></span>
                            </td>
                            <td>
                                <div class="new_tran_but"><a href="#addCommentModal" role="button" data-toggle="modal" class="trans_button cep"></a></div>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                        <tr class="bg_tr">
                            <td class="name">Linked Category</td>
                            <td>
                                <span class="small-text"><a href="#addLinkModal" role="button" data-toggle="modal" role="button" data-toggle="modal">Вы можете залинковать категорию к этой транзакции</a></span>
                            </td>
                            <td>
                                <div class="new_tran_but"><a class="trans_button cep" href="#addLinkModal" role="button" data-toggle="modal" role="button" data-toggle="modal" ></a></div>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                        <tr class="bg_tr">
                            <td class="name">Linked Contact</td>
                            <td>
                                <span class="small-text"><a href="#addLinkModal" role="button" data-toggle="modal" role="button" data-toggle="modal">Вы можете залинковать контакт к этой транзакции</a></span>
                            </td>
                            <td>
                                <div class="new_tran_but"><a class="trans_button cep" href="#addLinkModal" role="button" data-toggle="modal" role="button" data-toggle="modal" ></a></div>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                        <tr class="bg_tr">
                            <td class="name">Linked Transactions</td>
                            <td>
                                <span class="small-text"><a href="#addBuhModal" role="button" data-toggle="modal" role="button" data-toggle="modal">Вы можете залинковать транзакцию к этой транзакции</a></span>
                            </td>
                            <td>
                                <div class="new_tran_but"><a href="#addBuhModal" role="button" data-toggle="modal" class="trans_button sharp"></a></div>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                        <tr class="bg_tr">
                            <td class="name">Tags</td>
                            <td>
                                <span class="small-text"><a href="#addTagModal" role="button" data-toggle="modal" role="button" data-toggle="modal">Вы можете добавить несколько тегов к этой транзакции</a></span>
                            </td>
                            <td>
                                <div class="new_tran_but"><a href="#addTagModal" role="button" data-toggle="modal" class="trans_button pen"></a></div>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                        <tr class="bg_tr">
                            <td class="name">Linked Files</td>
                            <td>
                                <span class="small-text"><a href="#showFileModal" role="button" data-toggle="modal" role="button" data-toggle="modal">Вы можете добавить файл к этой транзакции</a></span>
                            </td>
                            <td>
                                <div class="new_tran_but"><a href="#showFileModal" role="button" data-toggle="modal" class="trans_button files"></a></div>
                                <div class="clearfix"></div>
                            </td>
                        </tr>
                        <tfoot class="hide-tr" style="display: none;">
                        <tr>
                            <td class="name">Value</td>
                            <td><span class="green_text">+200</span> EUR</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="name">Value</td>
                            <td><span class="green_text">+200</span> EUR</td>
                            <td></td>
                        </tr>
                        <tr >
                            <td class="name">Value</td>
                            <td><span class="green_text">+200</span> EUR</td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <a class="table-arrow">SHOW MORE<span></span></a>
</div>
<div class="one_tab" id="tab2">
<table class="xabina-table-upload transaction-table-cont">
<tr class="header-tr">
    <td>
        Indepland - Details overschrijving
        <div class="transaction-buttons-cont">
            <div class="btn-group">
                <a class="button menu" data-toggle="dropdown" href="#"></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="button send" href="#"></a>
                    </li>
                    <li>
                        <a class="button i" href="#"></a>
                    </li>
                    <li>
                        <a class="button upload" href="#"></a>
                    </li>
                </ul>
            </div>
        </div>
    </td>
</tr>
<tr class="form-tr">
<td>
<div class="transaction-info-cont new_transaction">
<table class="transaction-info-table table new_transaction_table">
<tr>
    <td class="name" width="20%">Date</td>
    <td width="70%">12.01.2014</td>
    <td></td>
</tr>
<tr>
    <td class="name">Sender</td>
    <td class="normal-line">John Doe<br/>xxxx xxxx 0987 / PayPal / Type info</td>
    <td></td>
</tr>
<tr>
    <td class="name">Receiver</td>
    <td class="normal-line">
        John Doe<br/>xxxx xxxx 0987
    </td>
    <td>
        <div class="new_tran_but"><a href="#createContactModal" role="button" data-toggle="modal" class="button book"></a></div>
        <div class="clearfix"></div>
    </td>
</tr>
<tr>
    <td class="name">Value</td>
    <td><span class="green_text">+200</span> EUR</td>
    <td>
        <div class="new_tran_but">
													<span class="drdn-cont">
														<a href="#" class="button portmone" data-toggle="dropdown"></a>
														<div class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list" role="menu">
                                                            <div class="arr"></div>
                                                            <div class="content-dropdown">
                                                                <div class="drop_title">
                                                                    Валюта
                                                                    <a class="close-dropdown"></a>
                                                                </div>
                                                                <div class="drop_bg_block">
                                                                    Выберите валюту, в которой хотите получить перевод.
                                                                </div>
                                                                <div class="drop_main_block">
                                                                    <div class="select-custom account-select">
                                                                        <span class="select-custom-label">EUR</span>
                                                                        <select name="" class=" select-invisible">
                                                                            <option value="">
                                                                                EUR
                                                                            </option>
                                                                            <option value="">
                                                                                RUB
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="drop_dop_text">
                                                                        <span class="bold_text">100 000 EUR = 4 000 000 RUB</span>
                                                                        по курсу 1EUR:1.4 USD НБ
                                                                        на 28.08.2014
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
													</span>
        </div>
        <div class="clearfix"></div>
    </td>
</tr>
<tr>
    <td class="name">Description</td>
    <td>Advertising giants Publicis and Omnicom announced</td>
    <td></td>
</tr>
<tr>
    <td class="name">Status</td>
    <td>
        <span class="tran_status">- Approved</span>
												<span class="comment drdn-cont">
													<a href="#" class="transaction_comment margin-left active" data-toggle="dropdown"></a>
													<div class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list" role="menu">
                                                        <div class="arr"></div>
                                                        <div class="content-dropdown">
                                                            <div class="drop_title">
                                                                Комментарий
                                                                <a class="edit-dropdown"></a>
                                                                <a class="close-dropdown"></a>
                                                            </div>
                                                            <div class="casual_text">
                                                                Advertising giants Publicis and Omnicom announced
                                                            </div>
                                                        </div>
                                                    </div>
												</span>
    </td>
    <td></td>
</tr>
<tr class="bg_tr">
    <td class="name">Memo</td>
    <td colspan="2">
        <div class="attachments-cont">
            The new group will join a string of international <a href="#" class="news-files-toggle closed"><span>Show more</span></a>
            <div class="attachments-files-list" style="display: none;">
                The new group will join a string of international
                The new group will join a string of international
                The new group will join a string of international
            </div>
            <div class="transaction-buttons-cont absolute">
                <div class="btn-group">
                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="button edit" href="#"></a>
                        </li>
                        <li>
                            <a class="button delete" href="#"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </td>
</tr>
<tr class="bg_tr">
    <td class="name">Linked Category</td>
    <td colspan="2">
        <div class="attachments-cont">
            <div class="category-many"></div>
            <div class="files-header">
                <a href="#" class="news-category-toggle"><span>2 category</span></a>
            </div>
            <div class="clearfix"></div>
            <ul class="list-unstyled attachment-list attachments-category-list">
                <li>
                    <div class="attach_name">
                        <div class="account-data pull-left">
                            <div class="account-name">Расходы на детей</div>
                            <div class="account-info">9090</div>
                        </div>
                    </div>
                    <div class="attach_edit_block">
                        <span class="change_dropdown">Category</span>
                        <div class="select-custom account-select" style="display: none;">
                            <span class="select-custom-label">EUR</span>
                            <select name="" class=" select-invisible">
                                <option value="">
                                    EUR
                                </option>
                                <option value="">
                                    RUB
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="attach_comment_block">
																<span class="comment drdn-cont">
																	<a href="#" class="transaction_comment" data-toggle="dropdown"></a>
																	<div class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list" role="menu">
                                                                        <div class="arr"></div>
                                                                        <div class="content-dropdown">
                                                                            <div class="drop_title">
                                                                                Комментарий
                                                                                <a class="close-dropdown"></a>
                                                                            </div>
                                                                            <div class="drop_bg_block">
                                                                                Вы можете добавить здесь свой комментарий
                                                                            </div>
                                                                            <div class="drop_main_block">
                                                                                <textarea></textarea>
                                                                                <div class="drop_dop_text">
                                                                                    <input class="rounded-buttons submit pull-left" type="submit" value="ADD COMMENT">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
																</span>
                    </div>
                    <div class="attach_del_block"><a class="del_a"></a></div>
                    <div class="clearfix"></div>
                </li>
                <li>
                    <div class="attach_name">
                        <div class="account-data pull-left">
                            <div class="account-name">Расходы на детей</div>
                            <div class="account-info">9090</div>
                        </div>
                    </div>
                    <div class="attach_edit_block">
                        <span class="change_dropdown">Category</span>
                        <div class="select-custom account-select" style="display: none;">
                            <span class="select-custom-label">EUR</span>
                            <select name="" class=" select-invisible">
                                <option value="">
                                    EUR
                                </option>
                                <option value="">
                                    RUB
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="attach_comment_block">
																<span class="comment drdn-cont">
																	<a href="#" class="transaction_comment" data-toggle="dropdown"></a>
																	<div class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list" role="menu">
                                                                        <div class="arr"></div>
                                                                        <div class="content-dropdown">
                                                                            <div class="drop_title">
                                                                                Комментарий
                                                                                <a class="close-dropdown"></a>
                                                                            </div>
                                                                            <div class="drop_bg_block">
                                                                                Вы можете добавить здесь свой комментарий
                                                                            </div>
                                                                            <div class="drop_main_block">
                                                                                <textarea></textarea>
                                                                                <div class="drop_dop_text">
                                                                                    <input class="rounded-buttons submit pull-left" type="submit" value="ADD COMMENT">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
																</span>
                    </div>
                    <div class="attach_del_block"><a class="del_a"></a></div>
                    <div class="clearfix"></div>
                </li>
            </ul>
            <div class="transaction-buttons-cont absolute">
                <div class="btn-group">
                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="button eye" href="#"></a>
                        </li>
                        <li>
                            <a class="button delete" href="#"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </td>
</tr>
<tr class="bg_tr">
    <td class="name">Linked Contact</td>
    <td colspan="2">
        <div class="attachments-cont">
            <div class="contacts-many"></div>
            <div class="files-header">
                <a href="#" class="news-contacts-toggle"><span>2 contacts</span></a>
            </div>
            <div class="clearfix"></div>
            <ul class="list-unstyled attachment-list attachments-contacts-list">
                <li>
                    <div class="attach_name">
                        <div class="account-data pull-left">
                            <div class="account-name">John Doe</div>
                            <div class="account-info">info</div>
                        </div>
                    </div>
                    <div class="attach_edit_block">
                        <span class="change_dropdown">Personal</span>
                        <div class="select-custom account-select" style="display: none;">
                            <span class="select-custom-label">EUR</span>
                            <select name="" class=" select-invisible">
                                <option value="">
                                    EUR
                                </option>
                                <option value="">
                                    RUB
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="attach_comment_block">
																<span class="comment drdn-cont">
																	<a href="#" class="transaction_comment" data-toggle="dropdown"></a>
																	<div class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list" role="menu">
                                                                        <div class="arr"></div>
                                                                        <div class="content-dropdown">
                                                                            <div class="drop_title">
                                                                                Комментарий
                                                                                <a class="close-dropdown"></a>
                                                                            </div>
                                                                            <div class="drop_bg_block">
                                                                                Вы можете добавить здесь свой комментарий
                                                                            </div>
                                                                            <div class="drop_main_block">
                                                                                <textarea></textarea>
                                                                                <div class="drop_dop_text">
                                                                                    <input class="rounded-buttons submit pull-left" type="submit" value="ADD COMMENT">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
																</span>
                    </div>
                    <div class="attach_del_block"><a class="del_a"></a></div>
                    <div class="clearfix"></div>
                </li>
                <li>
                    <div class="attach_name">
                        <div class="account-data pull-left">
                            <div class="account-name">John Doe</div>
                            <div class="account-info">info</div>
                        </div>
                    </div>
                    <div class="attach_edit_block">
                        <span class="change_dropdown">Personal</span>
                        <div class="select-custom account-select" style="display: none;">
                            <span class="select-custom-label">EUR</span>
                            <select name="" class=" select-invisible">
                                <option value="">
                                    EUR
                                </option>
                                <option value="">
                                    RUB
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="attach_comment_block">
																<span class="comment drdn-cont">
																	<a href="#" class="transaction_comment" data-toggle="dropdown"></a>
																	<div class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list" role="menu">
                                                                        <div class="arr"></div>
                                                                        <div class="content-dropdown">
                                                                            <div class="drop_title">
                                                                                Комментарий
                                                                                <a class="close-dropdown"></a>
                                                                            </div>
                                                                            <div class="drop_bg_block">
                                                                                Вы можете добавить здесь свой комментарий
                                                                            </div>
                                                                            <div class="drop_main_block">
                                                                                <textarea></textarea>
                                                                                <div class="drop_dop_text">
                                                                                    <input class="rounded-buttons submit pull-left" type="submit" value="ADD COMMENT">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
																</span>
                    </div>
                    <div class="attach_del_block"><a class="del_a"></a></div>
                    <div class="clearfix"></div>
                </li>
            </ul>
            <div class="transaction-buttons-cont absolute">
                <div class="btn-group">
                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="button eye" href="#"></a>
                        </li>
                        <li>
                            <a class="button delete" href="#"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </td>
</tr>
<tr class="bg_tr">
    <td class="name">Linked Transactions</td>
    <td colspan="2">
        <div class="attachments-cont">
            <div class="transaction-many"></div>
            <div class="files-header">
                <a href="#" class="news-transaction-toggle"><span>2 transactions</span></a>
            </div>
            <div class="clearfix"></div>
            <ul class="list-unstyled attachment-list attachments-transaction-list">
                <li>
                    <div class="attach_name">
                        <div class="account-data pull-left">
                            <div class="account-name">John Doe</div>
                            <div class="account-info">#9090</div>
                        </div>
                    </div>
                    <div class="attach_edit_block">
                        <span class="change_dropdown">Category</span>
                        <div class="select-custom account-select" style="display: none;">
                            <span class="select-custom-label">EUR</span>
                            <select name="" class=" select-invisible">
                                <option value="">
                                    EUR
                                </option>
                                <option value="">
                                    RUB
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="attach_comment_block">
																<span class="comment drdn-cont">
																	<a href="#" class="transaction_comment" data-toggle="dropdown"></a>
																	<div class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list" role="menu">
                                                                        <div class="arr"></div>
                                                                        <div class="content-dropdown">
                                                                            <div class="drop_title">
                                                                                Комментарий
                                                                                <a class="close-dropdown"></a>
                                                                            </div>
                                                                            <div class="drop_bg_block">
                                                                                Вы можете добавить здесь свой комментарий
                                                                            </div>
                                                                            <div class="drop_main_block">
                                                                                <textarea></textarea>
                                                                                <div class="drop_dop_text">
                                                                                    <input class="rounded-buttons submit pull-left" type="submit" value="ADD COMMENT">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
																</span>
                    </div>
                    <div class="attach_del_block"><a class="del_a"></a></div>
                    <div class="clearfix"></div>
                </li>
                <li>
                    <div class="attach_name">
                        <div class="account-data pull-left">
                            <div class="account-name">John Doe</div>
                            <div class="account-info">#9090</div>
                        </div>
                    </div>
                    <div class="attach_edit_block">
                        <span class="change_dropdown" style="display: none;">Category</span>
                        <div class="select-custom account-select">
                            <span class="select-custom-label">EUR</span>
                            <select name="" class=" select-invisible">
                                <option value="">
                                    EUR
                                </option>
                                <option value="">
                                    RUB
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="attach_comment_block">
																<span class="comment drdn-cont">
																	<a href="#" class="transaction_comment active" data-toggle="dropdown"></a>
																	<div class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list" role="menu">
                                                                        <div class="arr"></div>
                                                                        <div class="content-dropdown">
                                                                            <div class="drop_title">
                                                                                Комментарий
                                                                                <a class="edit-dropdown"></a>
                                                                                <a class="close-dropdown"></a>
                                                                            </div>
                                                                            <div class="casual_text">
                                                                                Advertising giants Publicis and Omnicom announced
                                                                            </div>
                                                                        </div>
                                                                    </div>
																</span>
                    </div>
                    <div class="attach_del_block"><a class="del_a"></a></div>
                    <div class="clearfix"></div>
                </li>
            </ul>
            <div class="transaction-buttons-cont absolute">
                <div class="btn-group">
                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="button edit" href="#editBuhModal" role="button" data-toggle="modal"></a>
                        </li>
                        <li>
                            <a class="button delete" href="#addTwoBuhModal" role="button" data-toggle="modal"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </td>
</tr>
<tr class="bg_tr">
    <td class="name">Tags</td>
    <td colspan="2">
        <div class="attachments-cont">
            <div class="files-header">
                <a href="#" class="news-tags-toggle"><span>3 tags</span></a>
            </div>
            <div class="clearfix"></div>
            <ul class="list-unstyled attachment-list attachments-tags-list">
                <li>
                    <div class="attach_name">bank</div>
                    <div class="attach_del_block"><a class="del_a"></a></div>
                    <div class="clearfix"></div>
                </li>
                <li>
                    <div class="attach_name">account</div>
                    <div class="attach_del_block"><a class="del_a"></a></div>
                    <div class="clearfix"></div>
                </li>
                <li>
                    <div class="attach_name">Xabina</div>
                    <div class="attach_del_block"><a class="del_a"></a></div>
                    <div class="clearfix"></div>
                </li>
            </ul>
            <div class="transaction-buttons-cont absolute">
                <div class="btn-group">
                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="button edit" href="#editTagModal" role="button" data-toggle="modal"></a>
                        </li>
                        <li>
                            <a class="button delete" href="#addTwoTagModal" role="button" data-toggle="modal"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </td>
</tr>
<tr class="bg_tr">
    <td class="name">Files</td>
    <td colspan="2">
        <div class="attachments-cont">
            <div class="files-many"></div>
            <div class="files-header">
                <a href="#" class="news-files-toggle"><span>2 Files</span></a>
            </div>
            <div class="clearfix"></div>
            <ul class="list-unstyled attachment-list attachments-files-list">
                <li>
                    <div class="attach_name">Invoice.doc</div>
                    <div class="attach_edit_block">
                        <span class="change_dropdown">Personal</span>
                        <div class="select-custom account-select" style="display: none;">
                            <span class="select-custom-label">EUR</span>
                            <select name="" class=" select-invisible">
                                <option value="">
                                    EUR
                                </option>
                                <option value="">
                                    RUB
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="attach_comment_block">
																<span class="comment drdn-cont">
																	<a href="#" class="transaction_comment" data-toggle="dropdown"></a>
																	<div class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list" role="menu">
                                                                        <div class="arr"></div>
                                                                        <div class="content-dropdown">
                                                                            <div class="drop_title">
                                                                                Комментарий
                                                                                <a class="close-dropdown"></a>
                                                                            </div>
                                                                            <div class="drop_bg_block">
                                                                                Вы можете добавить здесь свой комментарий
                                                                            </div>
                                                                            <div class="drop_main_block">
                                                                                <textarea></textarea>
                                                                                <div class="drop_dop_text">
                                                                                    <input class="rounded-buttons submit pull-left" type="submit" value="ADD COMMENT">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
																</span>
                    </div>
                    <div class="attach_del_block"><a class="del_a"></a></div>
                    <div class="clearfix"></div>
                </li>
                <li>
                    <div class="attach_name">Konstantin ...pdf</div>
                    <div class="attach_edit_block">
                        <span class="change_dropdown">Personal</span>
                        <div class="select-custom account-select" style="display: none;">
                            <span class="select-custom-label">EUR</span>
                            <select name="" class=" select-invisible">
                                <option value="">
                                    EUR
                                </option>
                                <option value="">
                                    RUB
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="attach_comment_block">
																<span class="comment drdn-cont">
																	<a href="#" class="transaction_comment" data-toggle="dropdown"></a>
																	<div class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list" role="menu">
                                                                        <div class="arr"></div>
                                                                        <div class="content-dropdown">
                                                                            <div class="drop_title">
                                                                                Комментарий
                                                                                <a class="close-dropdown"></a>
                                                                            </div>
                                                                            <div class="drop_bg_block">
                                                                                Вы можете добавить здесь свой комментарий
                                                                            </div>
                                                                            <div class="drop_main_block">
                                                                                <textarea></textarea>
                                                                                <div class="drop_dop_text">
                                                                                    <input class="rounded-buttons submit pull-left" type="submit" value="ADD COMMENT">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
																</span>
                    </div>
                    <div class="attach_del_block"><a class="del_a"></a></div>
                    <div class="clearfix"></div>
                </li>
            </ul>
            <div class="transaction-buttons-cont absolute">
                <div class="btn-group">
                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="button edit" href="#editFileModal" role="button" data-toggle="modal"></a>
                        </li>
                        <li>
                            <a class="button delete" href="#"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="clearfix"></div>
    </td>
</tr>
</table>
</div>
</td>
</tr>
</table>
</div>
<div id="tab3">
</div>
<div id="tab4">
</div>
<div class="submit-button button-back" onclick="window.location = 'personal_account_new.html'">Back</div>
</div>
</div>