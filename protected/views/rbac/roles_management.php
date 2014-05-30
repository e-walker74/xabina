<div class="col-lg-9 col-md-9 col-sm-9">
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
                <div class="show-users ui-accordion ui-widget ui-helper-reset" role="tablist">
                    <div class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-corner-all ui-accordion-icons" role="tab" id="ui-accordion-6-header-0" aria-controls="ui-accordion-6-panel-0" aria-selected="false" aria-expanded="false" tabindex="0"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><a href="#">Show users</a></div>
                    <div class="users-content ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" id="ui-accordion-6-panel-0" aria-labelledby="ui-accordion-6-header-0" role="tabpanel" aria-hidden="true" style="display: none;">
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
                <div class="details-accordion show-users ui-accordion ui-widget ui-helper-reset" role="tablist">
                    <div class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-accordion-icons" role="tab" id="ui-accordion-1-header-0" aria-controls="ui-accordion-1-panel-0" aria-selected="true" aria-expanded="true" tabindex="0"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><a href="#">Show user</a></div>
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
                <div class="details-accordion show-users ui-accordion ui-widget ui-helper-reset" role="tablist">
                    <div class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-accordion-icons" role="tab" id="ui-accordion-2-header-0" aria-controls="ui-accordion-2-panel-0" aria-selected="true" aria-expanded="true" tabindex="0"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><a href="#">Show users</a></div>
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
                <div class="details-accordion show-users ui-accordion ui-widget ui-helper-reset" role="tablist">
                    <div class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-accordion-icons" role="tab" id="ui-accordion-3-header-0" aria-controls="ui-accordion-3-panel-0" aria-selected="true" aria-expanded="true" tabindex="0"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><a href="#">Show users</a></div>
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
                <div class="details-accordion show-users ui-accordion ui-widget ui-helper-reset" role="tablist">
                    <div class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-accordion-icons" role="tab" id="ui-accordion-4-header-0" aria-controls="ui-accordion-4-panel-0" aria-selected="true" aria-expanded="true" tabindex="0"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><a href="#">Show user</a></div>
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
                <div class="details-accordion show-users ui-accordion ui-widget ui-helper-reset" role="tablist">
                    <div class="accordion-header ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-accordion-icons" role="tab" id="ui-accordion-5-header-0" aria-controls="ui-accordion-5-panel-0" aria-selected="true" aria-expanded="true" tabindex="0"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><a href="#">Show users</a></div>
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