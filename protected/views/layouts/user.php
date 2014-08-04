<!DOCTYPE html>
<html>
<head>
    <title>banking</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/fonts.css" />

    <link  rel="stylesheet/less" type="text/css" href="/css/style.less" />
    <link rel="stylesheet" href="/css/media.css" />
    <script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/less.min.js"></script>
    <script type="text/javascript" src="/js/scripts.js"></script>
    <script type="text/javascript" src="/js/jquery.currencyDropDown.js"></script>
</head>
<body>
<div class="main-bg" >
    <div class="wrapper">
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" clearfix">
                    <select name="" id="" class="language-select pull-left">
                        <option value="">Ru</option>
                        <option value="">En</option>
                    </select>

                    <div class="font-size-adjust-container pull-left">
                        Размер шрифта
                        <ul class="font-size-adjust   list-inline">
                            <li class="small-size" onclick="fontScale(1);">A</li>
                            <li class="medium-size" onclick="fontScale(1.25);">A</li>
                            <li class="large-size" onclick="fontScale(1.5);">A</li>
                        </ul>
                    </div>
                    <ul class="user-menu pull-right  list-inline">
                        <li class="user-personal"><a href="#"></a></li>
                        <li class="user-email"><a href="#"></a></li>
                        <li class="user-settings"><a href="#"></a></li>
                        <li class="user-logout"><a href="#"></a></li>
                    </ul>
                    <div class="user-greeting pull-right">Здравствуйте, <span>Виктор Андреевич!</span></div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="container" >
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <header>
                <div class="header-top clearfix">
                    <div class="account-status pull-left">Статус счета: <span>Требуется активация</span></div>
                    <div class="last-visit pull-right">Последний вход: 31.25.256.21, 12 января 2014 16:16 GMT +01:00</div>
                </div>
                <div class="header-middle clearfix">
                    <a href="/" class="logo pull-left"></a>
                    <ul class="header-links pull-right list-inline">
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Site map</a></li>
                        <li><a href="#">Language</a></li>
                        <li><a href="#">Cards</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Site map</a></li>
                    </ul>
                </div>
                <div class="header-bottom clearfix">
                    <ul class="top-menu pull-left list-unstyled">
                        <li class="current"><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Credits</a></li>
                        <li><a href="#">History</a></li>
                    </ul>
                    <div class="search-cont pull-right">
                        <input placeholder="Введите слово..." type="text" class="search-text"/>
                        <div class="search-submit"></div>
                    </div>
                </div>
            </header>
        </div>
    </div>
    <div class="row main-container">
        <div class="col-lg-3 col-md-3  col-sm-3 sidebar-container" >
            <div class="sidebar-shadow-container">
                <div class="sidebar-shadow"></div>
            <ul class="sidebar-menu list-unstyled">
                <li class="overview active"><a href="#">Overview</a></li>
                <li class="accounts"><a href="accounts.html">Accounts</a></li>
                <li class="payments"><a href="#">Payments</a></li>
                <li class="balance"><a href="#">Balance</a></li>
                <li class="credit"><a href="#">Credit</a></li>
                <li class="extra"><a href="#">Extra  Services</a></li>
            </ul>
            <ul class="sidebar-contacts list-unstyled">
                <li class="phones">
                    <div class="contact-ico"></div>
                    <div class="contact-text">
                    (912) 555-1234  <br>
                    (912) 567-8904
                    </div>
                </li>
                <li  class="address">
                    <div class="contact-ico"></div>
                    <div class="contact-text">
                    1600 Pennsylvania  <br>
                    Ave NW, Washington  <br>
                    DC 20500, USA
                    </div>
                </li>
                <li  class="emails">

                    <div class="contact-ico"></div>
                    <div class="contact-text">
                    hello@xabina.com   <br>
                    office@xabina.com
                    </div>
                </li>
            </ul>
            </div>

        </div>
        <div class="col-lg-9 col-md-9 col-sm-9" >
            <div class="h1-header">Мои счета</div>
            <div class="xabina-alert">
                Уважаемый, <span>Виктор Андреевич</span>, добро пожаловать! <br>
                Для того, чтобы начать работу со своим счетом, активируйте его, пожалуйста.
            </div>

            <div class="activate-account-button">Активировать счет</div>
            <div class="subheader">Счета</div>
            <table class="table xabina-table">
                <tr class="table-header">
                    <th>Номер счета <span class="sort_arr"></span></th>
                    <th>Вид</th>
                    <th>Владелец</th>
                    <th>Сумма <span class="sort_arr"></span></th>
                    <th>Валюта</th>
                </tr>
                <tr>
                    <td>0185 2156 4657</td>
                    <td>Основной</td>
                    <td>Виктор Купец</td>
                    <td>10 000</td>
                    <td class="currency-td"><div class="relative"><span class="currency_button">EUR</span></div></td>
                </tr>
                <tr>
                    <td>0185 2156 4657</td>
                    <td>Основной</td>
                    <td>Виктор Купец</td>
                    <td>10 000</td>
                    <td class="currency-td"><div class="relative"><span class="currency_button">EUR</span></div></td>
                </tr>
                <tr class="totals">
                    <td colspan="3" class="totals-lbl"><span>Общая сумма:</span></td>
                    <td>15 000</td>
                    <td class="currency-td"><div class="relative"><span class="currency_button">EUR</span></div></td>
                </tr>

            </table>
            <div class="subheader">Операции</div>
            <table class="table xabina-table">
                <tr class="table-header">
                    <th>Время</th>
                    <th>Операция</th>
                    <th>Номер счета</th>
                    <th>Сумма</th>
                    <th>Валюта</th>
                </tr>
                <tr>
                    <td>
                        12.01.2014 <br>
                        12:56
                    </td>
                    <td class="transaction-comment ">Зачисление перевода</td>
                    <td>0185 2156 4657</td>
                    <td><span class="sum-inc">+100</span></td>
                    <td class="currency-td"><div class="relative"><span class="currency_button">EUR</span></div></td>
                </tr>
                <tr>
                    <td>
                        12.01.2014 <br>
                        12:56
                    </td>
                    <td>
                        <div class="transaction-comment "></div>
                        Бонус от Xabina
                        новому клиенту
                    </td>
                    <td>0185 2156 4657</td>
                    <td><span class="sum-inc">+250</span></td>
                    <td class="currency-td"><div class="relative"><span class="currency_button">EUR</span></div></td>
                </tr>
                <tr>
                    <td>
                        12.01.2014 <br>
                        12:56
                    </td>
                    <td class="transaction-comment ">
                        Оплата товаров
                        в магазине book.com
                    </td>
                    <td>0185 2156 4657</td>
                    <td><span class="sum-dec">-250</span></td>
                    <td class="currency-td"><div class="relative"><span class="currency_button">EUR</span></div></td>
                </tr>

            </table>

            <div class="promo-container">
                    <div class="promo-banner with-img clearfix pull-left">
                        <img src="img/banner_img.png" class="pull-left hidden-xs hidden-sm" alt=""/>
                        <div class="pull-right banner-content">
                            <div class="banner-header">Промо-места</div>
                            <div class="banner-text">
                                Кредитные карты до 75 000$<br>
                                Выгодно. Оформи онлайн <br>заявку!
                            </div>
                        </div>

                    </div>


                    <div class="promo-banner without-img clearfix pull-right">
                        <div class=" banner-content">
                            <div class="banner-header">Промо-места</div>
                            <div class="banner-text">
                                Кредитные карты до 75 000$ <br>
                                Выгодно. Оформи онлайн <br> заявку!
                            </div>
                        </div>
                    </div>
            </div>
        </div>



    </div>
</div>
        <div class="footer-push"></div>
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class=" clearfix">
                        <div class="copyright pull-left">© 2014 Xabina</div>
                        <ul class="footer-menu pull-right list-inline">
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Site map</a></li>
                            <li><a href="#">Language</a></li>
                            <li><a href="#">Cards</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Site map</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </footer>
</div>
</body>
</html>