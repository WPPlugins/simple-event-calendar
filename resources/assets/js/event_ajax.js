"use strict";

jQuery( document ).ready(function() {

    /**
     * Event add new venue and organizer
     */

    jQuery(".add_new").on('click', function () {
        jQuery(this).hide();
        jQuery(this).closest('.event_block').siblings('.event_block_edit').show();
        jQuery(this).siblings('.event_back').css('display', 'block');
        return false;
    });

    jQuery('.event_back').on('click', function () {
        backReset();
        return false;
    });

    /**
     * Event save venue ajax handler
     */

    jQuery("#create_new_venue").click(function () {
        var data = {
            action: 'event_save_venue',
            nonce: gdCalendarEventAjaxObj.gdNonceSave,
            title: jQuery("#venue_name").val(),
            address: jQuery("#address").val(),
            latitude: jQuery("#latitude").val(),
            longitude: jQuery("#longitude").val()
        };
        jQuery.ajax({
            url: gdCalendarEventAjaxObj.ajaxUrl,
            type: 'post',
            data: data,
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 0) {
                return false;
            }
            jQuery("#event_venue").append(jQuery('<option>', {
                value: response.id,
                text: response.title,
                selected: 'selected'
            }));
            emptyVenueFields();
            backReset();
        });
    });

    /**
     * Event save organizer ajax handler
     */

    jQuery('#create_new_organizer').on('click', function () {
        var data = {
            action: 'event_save_organizer',
            nonce: gdCalendarEventAjaxObj.gdNonceSaveOrg,
            title: jQuery('#organizer_name').val(),
            organized_by: jQuery('#organized_by').val(),
            organizer_address: jQuery('#organizer_address').val(),
            phone: jQuery('#phone').val(),
            website: jQuery('#website').val(),
            organizer_email: jQuery('#organizer_email').val(),

        };
        jQuery.ajax({
            url: gdCalendarEventAjaxObj.ajaxUrl,
            data: data,
            type: 'post',
            dataType: 'json'
        }).done(function (response) {
            if(response.status === 0){
                return false;
            }
            jQuery("#event_organizer").append(jQuery('<option>', {
                value: response.id,
                text: response.title,
                selected: 'selected'
            }));
            emptyOrganizerFields();
            backReset();
        });
    });

    /**
     * Reset and Empty Fields
     */

    function backReset() {
        jQuery(".event_back").hide();
        jQuery(".add_new").show();
        jQuery(".event_block_edit").hide();
    }

    function emptyVenueFields() {
        jQuery("#venue_name").val('');
        jQuery("#address").val('');
        jQuery("#latitude").val('');
        jQuery("#longitude").val('');
    }

    function emptyOrganizerFields() {
        jQuery("#organizer_name").val('');
        jQuery('#organized_by').val('');
        jQuery("#organizer_address").val('');
        jQuery("#phone").val('');
        jQuery("#website").val('');
        jQuery("#organizer_email").val('');
    }
    
    /**
     * Error for empty Venue Name
     */
    var new_venue = jQuery("#create_new_venue"),
        venue_name = jQuery("#venue_name"),
        error_name = jQuery(".error-name"),
        new_organizer = jQuery("#create_new_organizer"),
        organizer_name = jQuery("#organizer_name"),
        error_name_org = jQuery(".error-name-org");

    new_venue.click(function () {
        if(venue_name.val() == "") {
            error_name.removeClass('hide');
            return false;
        }
    });

    venue_name.on('blur', function () {
        if(jQuery(this).val() != "") {
            error_name.addClass('hide');
        }
    });

    /**
     * Error for empty Organizer Name
     */

    new_organizer.on('click', function () {
        if(organizer_name.val() == ''){
            error_name_org.removeClass('hide');
            return false;
        }
    });

    organizer_name.on('blur', function () {
       if(jQuery(this).val() != ""){
           error_name_org.addClass('hide');
           return false;
       }
    });
});
