<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="breadcrumbs-cont">
        <a class="breadcrumbs" href="#">Home</a>
        <a class="breadcrumbs prev" href="#">Settings</a>
        <a class="breadcrumbs" href="#">Role Management</a>
    </div>
    <div class="xabina-form-container">
        <div class="h1-header">Role Management</div>
        <div class="h4"><b>My role</b></div>
        <table class="table xabina-table">
            <tbody><tr class="table-header">
                <th width="45%">Role</th>
                <th width="40%">Used by</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <td>
                    <b>Стандарт для партнеров</b>
                </td>
                <td>
                    3 users <br>
                    <div class="show-users">
                        <div class="accordion-header"><a href="#">Show users</a></div>
                        <div class="users-content">
                            <a href="#">Name user №1</a><br>
                            <a href="#">Name user №2</a><br>
                            <a href="#">Name user №3</a><br>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="transaction-buttons-cont">
                        <a class="button edit" href="#"></a>
                        <a class="button delete" href="#"></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Для клиентов</b>
                </td>
                <td>
                    1 user <br>
                    <div class="details-accordion show-users">
                        <div class="accordion-header"><a href="#">Show user</a></div>
                    </div>
                </td>

                <td>
                    <div class="transaction-buttons-cont">
                        <a class="button edit" href="#"></a>
                        <a class="button delete" href="#"></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Минимальные возможности</b>
                </td>
                <td>
                    2 users <br>
                    <div class="details-accordion show-users">
                        <div class="accordion-header"><a href="#">Show users</a></div>
                    </div>
                </td>

                <td>
                    <div class="transaction-buttons-cont">
                        <a class="button edit" href="#"></a>
                        <a class="button delete" href="#"></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Стандарт для партнеров</b>
                </td>
                <td>
                    3 users <br>
                    <div class="details-accordion show-users">
                        <div class="accordion-header"><a href="#">Show users</a></div>
                    </div>
                </td>

                <td>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Для клиентов</b>
                </td>
                <td>
                    1 user <br>
                    <div class="details-accordion show-users">
                        <div class="accordion-header"><a href="#">Show user</a></div>
                    </div>
                </td>

                <td>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Минимальные возможности</b>
                </td>
                <td>
                    2 users <br>
                    <div class="details-accordion show-users">
                        <div class="accordion-header"><a href="#">Show users</a></div>
                    </div>
                </td>

                <td>
                </td>
            </tr>
            </tbody></table>
        <div class="form-submit">
            <a href="<?=Yii::app()->createUrl("/settings/roles/add") ?>" class="rounded-buttons upload add-more">ADD NEW ROLE</a>
        </div>
    </div>
</div>