<script>
    $(document).ready(function(){
        $('.xabina-accordion').accordion({
            heightStyle: "content",
            active: false,
            collapsible: true
        }); 
        $('.details-accordion').accordion({
            heightStyle: "content",
            active: 0,
            collapsible: true
        });
    });
</script>
<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="h1-header">Add a new role</div>
    <div class="role-form xabina-form-container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="field-lbl">
                    Role Name
                    <span class="tooltip-icon" title="Add Your mobile phone in an international format (e.g. +3100000000)"></span>
                </div>
                <div class="field-input">
                    <input  class="input-text jquery-live-validation-on input-error" type="text">
                    <span class="validation-icon" style="display: inline;"></span>
                    <div class="error-message" style="display: block;">
                        Mobile Phone is incorrect
                        <div class="error-message-arr"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
                <div class="field-lbl">
                    Base role
                    <span class="tooltip-icon" title="Country: (Choose the country from the drop-down menu)"></span>
                </div>
                <div class="field-input">
                    <div class="select-custom">
                        <span class="select-custom-label">Выберите </span>
                        <select name="country" class="country-select select-invisible">
                            <option value="">Выберите</option>
                            <option value="1">США</option>
                            <option value="2">Бельгия</option>
                            <option value="3">Нидерланды</option>
                            <option value="4">Люксембург</option>
                        </select>
                    </div>
                    <div class="error-message" style="display: block;">error  <div class="error-message-arr"></div></div>
                </div>
            </div>
        </div>
        <?php $this->widget('AccessRightsTree', array('rightsTree' => $rightsTree));?>
        <?php /*
        <div class="xabina-accordion transfer-accordion xabina-narrow-accordion" >
            <?php foreach ($rightsTree as $topRight):?>
            <div class="accordion-header">
                <a href="#" class="search-acc"><?php echo $topRight['name']?></a>
                <span class="arr"></span>
            </div>
            <div class="accordion-content ">
            </div>
            <?php endforeach;?>
        </div>*/?>
        
    </div>
</div>