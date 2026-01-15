/*
 * Main JavaScript file - bundled by Webpack Encore
 */
"use strict";

// CSS imports
import './styles/app.css';
import 'flatpickr/dist/flatpickr.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';

// JS imports
import $ from 'jquery';
import flatpickr from "flatpickr";
import { Portuguese } from 'flatpickr/dist/l10n/pt.js';
import Swal from 'sweetalert2';
import '@fortawesome/fontawesome-free/js/all.min.js';

$(function(){
    initSidebarMenuActive()
    initAuditExtraFiltersManager()
    initSelect2()
    initFlatpickr()
    initTooltips()
    initConfirmAction()
})

function initSidebarMenuActive(){
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

function initFlatpickr(){
    const defaultConfig = {
        enableTime: false,
        dateFormat: "d/m/Y",
        locale: Portuguese,
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

function initTooltips(){
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
}

function initConfirmAction(){
    $('.confirm-action').click(function(e){
        e.preventDefault();

        const data_title = $(this).data('title');
        const data_message = $(this).data('message');
        const data_url = $(this).data('url');

        Swal.fire({
            title: data_title||"Tem certeza?",
            text: data_message||"Talvez você não consiga reverter isso.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sim, tenho certeza!",
            cancelButtonText: "Não, cancelar.",
            reverseButtons: true,
            preConfirm: async () => {
                try {
                    const response = await fetch(data_url);

                    if (!response.ok) {
                        return Swal.showValidationMessage(response.statusText);
                    }
                } catch (error) {
                    console.error(error)
                    Swal.showValidationMessage(`Ocorreu um erro durante a solicitação.`);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Sucesso!",
                    text: "Operação realizado com sucesso.",
                    icon: "success",
                    willClose: () => {
                        window.location.reload();
                    }
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire({
                    title: "Falha",
                    text: "Ocorreu um erro durante sua solicitação.",
                    icon: "error"
                });
            }
        });
    })
}