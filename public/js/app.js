$(function(){
    initSidebarStatusActive()
    dropdownMenuOverflow()
    initAuditExtraFiltersManager()
    initSelect2()
    initFlatpickr()
})

function initSidebarStatusActive(){
    const links = $('#sidebar').find('li > a')

    for(const link of links){
        //If the menu link is the same as the current path
        if (window.location.pathname === $(link).attr('href')){
            const is_submenu = $(link).parent().parent().parent().parent().hasClass('nav-item')
            if (is_submenu){
                $(link).addClass('text-success');
                $(link).parent().parent().parent().parent().addClass('active');
                document.querySelector('li.nav-item.active a[data-bs-toggle="collapse"]').click()
            } else {
                $(link).parent().addClass('active');
            }
        }
    }
}

function dropdownMenuOverflow() {
    const btnDropdown = $('table > tbody > tr > td > div.dropdown > button')
    btnDropdown.click(function (){
        if ($('table > tbody > tr > td > div.dropdown > button ~ .show').length === 0) {
            $('table').parent().addClass('table-responsive')
        } else {
            $('table').parent().removeClass('table-responsive')
        }
    })
}

function initFlatpickr(){
    const defaultConfig = {
        enableTime: false,
        dateFormat: "d/m/Y",
        locale: "pt",
        allowInput: true,
    }

    flatpickr(".flatpickr_timed", {...defaultConfig, enableTime: true, dateFormat: "d/m/Y H:i"});
    flatpickr(".flatpickr", defaultConfig);
}

function initAuditExtraFiltersManager(){
    const audit_extra_filters_box = $('#audit-extra-filters')
    const selects_inputs = audit_extra_filters_box.find('select, input')
    const btn_extra_filters = $('#btn-extra-filters')
    let is_filter_applied = false;

    for (const select of selects_inputs){
        if($(select).val().length > 0) {
            is_filter_applied = true
            break
        }
    }

    //Filters are applied
    //AND
    //Filters aren't default in current page (Query string means that the form GET was submitted)
    if (is_filter_applied && window.location.search.length > 0) {
        audit_extra_filters_box.slideDown(200)
    } else {
        audit_extra_filters_box.slideUp(200)
    }

    btn_extra_filters.click(function(){
        audit_extra_filters_box.slideToggle(200)
    })
}

function initSelect2(){
    $('.select2').select2({})
}