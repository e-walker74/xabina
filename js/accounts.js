/**
 * Created by ekazak on 08.09.14.
 */

Accounts = {
    init: function () {
        $('.sidebar-toggle').on('click', function (e) {
            $(this).parents('.module-container').toggleClass('minimize');
        });

        setTimeout(function () {
            $('.module-sidebar').each(function (i, el) {
                $(el).height($(el).next('.module-content').height())
            });
        }, 50);


        $('.filter-block').on('click', '.filter-header', function () {
            $(this).toggleClass('closed').next('.filter-content').slideToggle();
        });

        $('.pop_up_input_wrap input').keydown(function (e) {
            if (e.keyCode != 8)
                $(this).next('.clear_text_box').show();
            else {
                if ($(this).val().length == 1)
                    $(this).next('.clear_text_box').hide();
            }
        });

        $('.pop_up_input_wrap .clear_text_box').click(function () {
            $(this).parent().find("input").val("");
            $(this).hide();
            $('.pop_up_input_wrap input').keyup()
            return false;
        });

        if ($('.calendar-input-2').length)
            $(".calendar-input-2").datepicker({
                showOn: "button",
                buttonImage: 'img/calendar_ico.png',
                buttonImageOnly: true
            });

        $('.slide-toggler').on('click', function () {
            $(this).toggleClass('open').parents('li').find('.details').slideToggle();
            return false;
        })

        $('body').on('click', '.accounts-list li.clickable-row',function (e) {
            return Accounts.balancePage(e)
        }).on('keyup', '.module-search-panel input.search', function (e) {
            Accounts.search(e, this)
        }).on('hover', '.btn-gr', function () {
            $(this).toggleClass('open');
        })

        Accounts.tagToSearch()
        Accounts.bindCheckboxesChange()
        Accounts.filterRows()
    },
    makeAccountPrimary: function (url, id, link) {
//        backgroundBlack()
        if(link) {
            link = $(link)
            link.closest('table').find('.primary-button.is-primary').hide()
            link.closest('table').find('.primary-button.m-primary').show()
            link.closest('div').find('.primary-button').toggle()
        }
        $.ajax(
            {
                data: {id: id },
                type: 'POST',
                dataType: 'json',
                url: url,
                success: function (response) {
                    if (response.success) {
                        if ($('#accounts-list').length == 0) {
                            $('#tab2').html(response.html)
                        }
                        successNotify('Payment', response.message)
                        bindHoverBtnGroups()
                    }
                },
                complete: function () {
//                    dellBackgroundBlack()
                }
            }
        );
    },
    balancePage: function (event) {
        if (event.target.localName != "a"
            && $(event.target).closest('a').length == 0
            && event.target.localName != "input"
            && event.target.localName != "label") {

            window.location = "" + $(event.target).closest('li').attr('data-url')
        }
    },
    search: function (e, input) {
        var value = $(input).val()
        value = value.replace(/\s+/g, '')
        if (value) {
            var block = $('ul.accounts-list')
            block.find('li.account-item').hide()
            block.find('li.totals').hide()

            var rows = block.find(".search-text-hear")

            rows.each(function () {
                if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) != -1) {
                    $(this).closest('li.account-item').show()
                }
            })

//            block.find(".drive-search-text")
//            block.find(".drive-search-text:contains('" + value + "')").closest('li.drive-file-row').show();
        } else {
            $('ul.accounts-list li').show()
        }
    },
    tagToSearch: function () {
        $('#tags-select-dropdown .drop_tags_ul li').on('click', function () {
            var tag = $(this)
            var input = $('.module-search-panel input.search')

//            if(input.val().length == 0){
            input.val(tag.html())
//            } else {
//                input.val(input.val() + ' ' + tag.html())
//            }
            input.keyup()
            tag.closest('.open').removeClass('open')
            $('.pop_up_input_wrap input').next('.clear_text_box').show()
        })
    },
    checkAll: function (checkbox) {
        if ($(checkbox).prop('checked')) {
            $('.row-checkbox').attr('checked', true).parent().addClass('checked')
            Accounts.showHideControls()
        } else {
            $('.row-checkbox').attr('checked', false).parent().removeClass('checked')
            Accounts.showHideControls(true)
        }
    },
    bindCheckboxesChange: function () {
        $('body').on('change', '.row-checkbox', function (e) {
            if ($('.row-checkbox:not(:checked)').length == 0) {
                $('.summary-checkbox').attr('checked', true).parent().addClass('checked')
            } else {
                $('.summary-checkbox').attr('checked', false).parent().removeClass('checked')
                Accounts.showHideControls()
            }

            if ($('.row-checkbox:checked').length == 0) {
                Accounts.showHideControls(true)
            }
            e.stopPropagation()
            return false;
        })
    },
    showHideControls: function (hide) {
        if (hide) {
            $('.controls').hide()
        } else {
            $('.controls').show()
        }
    },
    controlsButtonClick: function (button) {
        window.location = $(button).attr('href') + '?' + $('.window-content form').serialize()
        return false;
    },
    filterRows: function () {
        $('body').on('change', '.filter-content .filter-value', function () {
            var list = $('ul.accounts-list')
            var rowsData = list.find('.row-filter-data')
            list.find('li').show()
            $('.filter-content .filter-value').each(function () {
                var filterValue = $(this).val()
                if (filterValue.length > 0) {
                    rowsData.each(function () {
                        if ($(this).text().indexOf(filterValue) == -1) {
                            $(this).closest('li.account-item').hide()
                            list.find('.totals').hide()
                        }
                    })
                }
            })
        })
//        $('.row-filter-data')
//
//        var block = $('ul.accounts-list')
//        block.find('li.account-item').hide()
//
//        var rows = block.find(".search-text-hear")
//
//        rows.each(function () {
//            if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) != -1) {
//                $(this).closest('li.account-item').show()
//            }
//        })
    },
    sort: function(link, sort, default_sort){
        var link = $(link)
        if(!default_sort){
            default_sort = 'asc'
        }
        $('li a').removeClass('selected')
        // if need to show sort text in dropdown
//        var parent = link.closest('.sort-f')
//        if(parent.length != 0){
//            parent.find('.sort-drdn-cont').html(link.html())
//        } else {
//            $('.header .sort-drdn-cont').html($('.header .sort-drdn-cont').attr('data-default'))
//        }
        if(sort){
            $('.sort.desc').removeClass('desc')
            $('.sort.asc').removeClass('asc')
            link.addClass(sort)
            link.addClass('selected')
        } else {
            if(link.hasClass('asc')){
                $('.sort.desc').removeClass('desc')
                $('.sort.asc').removeClass('asc')
                link.addClass('desc')
                sort = 'desc'
            } else if(link.hasClass('desc')) {
                $('.sort.desc').removeClass('desc')
                $('.sort.asc').removeClass('asc')
                link.addClass('asc')
                sort = 'asc'
            } else {
                $('.sort.desc').removeClass('desc')
                $('.sort.asc').removeClass('asc')
                link.addClass(default_sort)
                sort = default_sort

            }
        }



        $.ajax(
            {
                data: {sort: link.attr('data-sort-field') + '.' + sort},
                type: 'GET',
                dataType: 'JSON',
                success: function (response) {
                    if (response.success) {
                        $('#accounts-list').html(response.html)
                        $('.filter-content .filter-value option').attr('selected', false)
                        $('.filter-content .filter-value option:first').attr('selected', true)
                        setAllSelectedValues()
                    }
                }
            }
        );
    }
}

$(function () {
    Accounts.init()
})