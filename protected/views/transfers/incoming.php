<div class="col-lg-9 col-md-9 col-sm-9" >
<div class="new-transfer xabina-form-container">
<div class="h1-header"><?= Yii::t('Front', 'Upload money') ?></div>
<div class="transfer-accordion xabina-accordion xabina-transfer-accordion" >
<div class="accordion-header"><a href="#" class="search-acc"><?= Yii::t('Front', 'Quick Upload') ?></a><span class="arr"></span></div>
<div class="upload-table accordion-content">
    <div class="transaction-table-header">
        <table class="transaction-header">
            <tr>
                <td width="24%">Способ</td>
                <td width="27%">Получатель</td>
                <td width="49%">Value</td>
            </tr>
        </table>
    </div>
    <div class="new-transfer-table">
        <table class="table">
            <tr>
                <td width="24%">
                    <div class="update-img-payment"><img src="img/payment.jpg" alt=""/></div>
                    <div class="grey">xxxx xxxx xxxx 01541</div>
                </td>
                <td width="27%">
                    <div class="update-name"><strong class="holder">Viktor Kupets</strong></div>
                    <div class="grey">0121 0101 2585 01541</div>
                </td>
                <td width="49%">
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button edit"></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"><div class="upload-price pull-left">1 000 000.00 EUR</div><a href="#" class="rounded-buttons upload pull-right select-pay">SELECT AND PAY</a></div>
                </td>
            </tr>
            <tr>
                <td width="23%">
                    <div class="update-img-payment"><img src="img/payment.jpg" alt=""/></div>
                    <div class="grey">xxxx xxxx xxxx 01541</div>
                </td>
                <td width="25%">
                    <div class="update-name"><strong class="holder">Viktor Kupets</strong></div>
                    <div class="grey">0121 0101 2585 01541</div>
                </td>
                <td width="50%">
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button edit"></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"><div class="upload-price pull-left">1 000 000.00 EUR</div><a href="#" class="rounded-buttons upload pull-right select-pay">SELECT AND PAY</a></div>
                </td>
            </tr>
            <tr>
                <td width="23%">
                    <div class="update-img-payment"><img src="img/payment.jpg" alt=""/></div>
                    <div class="grey">xxxx xxxx xxxx 01541</div>
                </td>
                <td width="25%">
                    <div class="update-name"><strong class="holder">Viktor Kupets</strong></div>
                    <div class="grey">0121 0101 2585 01541</div>
                </td>
                <td width="50%">
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button edit"></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"><div class="upload-price pull-left">1 000 000.00 EUR</div><a href="#" class="rounded-buttons upload pull-right select-pay">SELECT AND PAY</a></div>
                </td>
            </tr>
            <tr>
                <td width="23%">
                    <div class="update-img-payment"><img src="img/payment.jpg" alt=""/></div>
                    <div class="grey">xxxx xxxx xxxx 01541</div>
                </td>
                <td width="25%">
                    <div class="update-name"><strong class="holder">Viktor Kupets</strong></div>
                    <div class="grey">0121 0101 2585 01541</div>
                </td>
                <td width="50%">
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button edit"></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"><div class="upload-price pull-left">1 000 000.00 EUR</div><a href="#" class="rounded-buttons upload pull-right select-pay">SELECT AND PAY</a></div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="accordion-header"><a href="#" class="search-acc">Electronic methods</a><span class="arr"></span></div>
<div class="electronic-methods accordion-content">

    <div class="own-account-form xabina-form-container">
        <div class="form-header"><span>From</span></div>
        <div class="from-form">
            <div class="form-cell">
                <div class="amount">
                    <div class="lbl">Amount<span class="tooltip-icon" title="Add Your E-Mail that you will use to access online banking"></span></div>
                    <div class="input">
                        <input class="amount-sum" type="text">
                        <span class="delimitter">.</span>
                        <input class="amount-cent" type="text">
                        <div class="error-message" style="display: block;">
                            error!!!
                            <div class="error-message-arr"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-cell">
                <div class="currency">
                    <div class="lbl">Currency<span class="tooltip-icon" title="Add Your E-Mail that you will use to access online banking">
</span></div>
                    <div class="input">
                        <div class="select-custom currency-select">
                            <span class="select-custom-label">EUR</span>
                            <select name="" class=" select-invisible">
                                <option value="">USD</option>
                                <option value="">RUB</option>
                                <option value="">EUR</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-cell" style="float: right">
                <div class="account">
                    <div class="lbl">Account<span class="tooltip-icon" title="tooltip text"></span></div>
                    <div class="input">
                        <div class="select-custom currency-select">
                            <span class="select-custom-label">EUR</span>
                            <select name="" class=" select-invisible">
                                <option value="">USD</option>
                                <option value="">RUB</option>
                                <option value="">EUR</option>
                            </select>
                        </div>
                        <div class="error-message" style="display: block;">
                            error!!!
                            <div class="error-message-arr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-header"><span>To</span></div>
        <div class="update-about">
            <div class="field-lbl">
                Method
                <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
            </div>
        </div>

        <select class="selectpicker">
            <option value="" data-icon="icon-star">Favourite &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MasterCard &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; xxxx xxxx xxxx 0265</option>
            <option value="" data-icon="icon-star">Favourite &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MasterCard &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; xxxx xxxx xxxx 0265</option>
            <option value="" data-icon="icon-star">Favourite &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MasterCard &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; xxxx xxxx xxxx 0265</option>
            <option value=""> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Credit Card</option>
            <option value=""> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;iDeal</option>
        </select>
        <div class="details-accordion ">
            <div class="accordion-header"><a href="#">Details</a></div>

        </div>
        <div class="form-submit transfer-controls-cont col-lg-5 col-md-5 col-sm-5 none-padding-left none-padding-right">
            <div class="submit-button button-next pull-left">Sign and send</div>
            <div class="star-button pull-right">
            </div>
        </div>
    </div>
</div>
<div class="accordion-header"><a href="#" class="search-acc">Payment Request</a><span class="arr"></span></div>
<div class="payment-request accordion-content">
    <div class="electronic-methods">
        <div class="new-transfer-table own-account-form xabina-form-container">
            <div class="from-form">
                <div class="form-cell">
                    <div class="amount">
                        <div class="lbl">Amount<span class="tooltip-icon" title="" data-original-title="Add Your E-Mail that you will use to access online banking"></span></div>
                        <div class="input">
                            <input class="amount-sum" type="text">
                            <span class="delimitter">.</span>
                            <input class="amount-cent" type="text">
                            <div class="error-message" style="display: block;">
                                error!!!
                                <div class="error-message-arr"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-cell">
                    <div class="currency">
                        <div class="lbl">Currency<span class="tooltip-icon" title="" data-original-title="Add Your E-Mail that you will use to access online banking">
</span></div>
                        <div class="input">
                            <div class="select-custom currency-select">
                                <span class="select-custom-label">EUR</span>
                                <select name="" class=" select-invisible">
                                    <option value="">USD</option>
                                    <option value="">RUB</option>
                                    <option value="">EUR</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-cell" style="float: right">
                    <div class="account">
                        <div class="lbl">Account<span class="tooltip-icon" title="" data-original-title="tooltip text"></span></div>
                        <div class="input">
                            <div class="select-custom currency-select">
                                <span class="select-custom-label">EUR</span>
                                <select name="" class=" select-invisible">
                                    <option value="">USD</option>
                                    <option value="">RUB</option>
                                    <option value="">EUR</option>
                                </select>
                            </div>
                            <div class="error-message" style="display: block;">
                                error!!!
                                <div class="error-message-arr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field-lbl">
                Comments
                <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
            </div>
            <div class="field-input">
                <textarea name="" cols="30" rows="1"></textarea>
            </div>
            <div class="field-lbl">
                Receiver
                <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
            </div>
            <div class="col-lg-11 col-md-11 col-sm-11 none-padding-left">
                <div class="field-input">
                    <input type="text" class="input-text"/>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 none-padding-right">
                <div class="field-input">
                    <input type="submit" class="receiver-submit" value=""/>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-submit">
                <a href="#" class="rounded-buttons upload add-more ">ADD INVOISE</a><br><br>
                <div class="clearfix"></div>
            </div>

            <div class="details-accordion ">
                <div class="accordion-header"><a href="#">Details</a></div>
            </div>
            <div class="form-submit">
                <div class="submit-button button-next">Sign and send</div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>