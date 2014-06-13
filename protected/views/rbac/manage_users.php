<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 13.06.14
 * Time: 1:26
 * #parse("RbacController.php")
 */

?>

<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="breadcrumbs-cont">
        <a class="breadcrumbs" href="#">Home</a>
        <a class="breadcrumbs prev" href="#">Settings</a>
        <a class="breadcrumbs " href="#">User Management</a>
    </div>
    <div class="h1-header">User Management</div>
    <div class="account-selection">
        <span class="select-lbl">Счет</span>
        <div class="select-custom account-select">
    <span class="select-custom-label">
                        Виктор Купец


                        0185 2156 4657


                        10 000 EUR
                    </span>
            <select name="" class=" select-invisible">
                <option value="">
                    Виктор Купец


                    0185 2156 4657


                    10 000 EUR
                </option>
                <option value="">
                    Виктор Купец


                    0185 2156 4657


                    10 000 EUR
                </option>
                <option value="">
                    Виктор Купец


                    0185 2156 4657


                    10 000 EUR
                </option>
                <option value="">
                    Виктор Купец


                    0185 2156 4657


                    10 000 EUR
                </option>
            </select>
        </div>
        <a href="#" class="refresh-button"></a>
    </div>
    <div class="xabina-form-container">
        <table class="table xabina-table user-management-table">
            <tr class="table-header">
                <th style="width: 29%">User</th>
                <th style="width: 13%">ID</th>
                <th style="width: 20%">Status</th>
                <th style="width: 20%">Role</th>
                <th style="width: 18%"></th>
            </tr>
            <tr>
                <td><span class="primary">Viktor Kupets</span></td>
                <td>2154</td>
                <td><span class="approved">Accepted</span></td>
                <td>Стандарт</td>
                <td >
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button edit"></a>
                        <a href="#" class="button delete"></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td><span class="primary">Viktor Kupets</span></td>
                <td></td>
                <td><span class="pending">Pending</span></td>
                <td>Бухгалтер</td>
                <td >
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button edit"></a>
                        <a href="#" class="button delete"></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td><span class="primary">Viktor Kupets</span></td>
                <td></td>
                <td><span class="rejected">Declined</span></td>
                <td>Бухгалтер</td>
                <td >
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button edit"></a>
                        <a href="#" class="button delete"></a>
                    </div>
                </td>
            </tr>

        </table>
        <div class="form-submit">
            <a href="#" class="rounded-buttons upload add-more">Add New User</a>
        </div>
        <div class="clearfix"></div>
    </div>

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
