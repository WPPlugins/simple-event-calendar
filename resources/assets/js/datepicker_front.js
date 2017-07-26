'use strict';

/**
 * Event filter datepicker for day
 */
function gd_calendar_day_datepicker() {
    jQuery("#gd_calendar_day_event_filter").datepicker({
        firstDay: 1,
        changeMonth: true,
        changeYear: true,
        beforeShow: function() {
            jQuery(this).datepicker('widget').removeClass('hide-calendar-month');
            jQuery(this).datepicker('widget').removeClass('hide-calendar-year');
        },
        onClose: function(dateText, inst) {
            jQuery(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
            var date = jQuery(this).val();
            jQuery("#date_holder").val(date);
            gdCalendarFilterByEvent(date);
        }
    });
}

/**
 * Event filter datepicker for week
 */
function gd_calendar_week_datepicker() {
    jQuery("#gd_calendar_week_event_filter").datepicker({
        firstDay: 1,
        changeMonth: true,
        changeYear: true,
        beforeShow: function() {
            jQuery(this).datepicker('widget').removeClass('hide-calendar-month');
            jQuery(this).datepicker('widget').removeClass('hide-calendar-year');
        },
        onClose: function(dateText, inst) {
            jQuery(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
            var date = jQuery(this).val();
            jQuery("#date_holder").val(date);
            gdCalendarFilterByEvent(date,1);
        }
    });
}

/**
 * Event filter datepicker for month
 */
function gd_calendar_month_datepicker() {
    jQuery('#gd_calendar_month_event_filter').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm/yy',
        beforeShow: function() {
            jQuery(this).datepicker('widget').removeClass('hide-calendar-year');
            jQuery(this).datepicker('widget').addClass('hide-calendar-month');
        },
        onClose: function(dateText, inst) {
            jQuery(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            var date = jQuery(this).val();
            jQuery("#date_holder").val(date);
            gdCalendarFilterByEvent(date);
        }
    });
}

/**
 * Event filter ajax handler
 * @param selected_date
 */
function gdCalendarFilterByEvent(selected_date, week){
    var search = jQuery(".gd_calendar_search").val();
    var post_id = jQuery("#post_id").val();
    var data = {
        action: 'event_filter',
        nonce: gdCalendarEventFilterAjaxObj.filterNonce,
        date: selected_date,
        week: week,
        search: search,
        id: post_id
    }
    jQuery.ajax({
        url : gdCalendarEventFilterAjaxObj.ajaxUrl,
        type: 'post',
        data: data,
        dataType: 'text',
        beforeSend: function () {
            jQuery(".gd_calendar_wrapper").find(".gd_loading").css("visibility", "visible");
        }
    }).done(function(response) {
        jQuery("#gd_calendar").empty();
        jQuery("#gd_calendar").append(response);

        calendar_month_more_events();
        calendar_week_more_events();
        calendar_day_event_hover();
        calendar_month_event_hover();
        calendar_week_event_hover();
    }).always(function(){
        jQuery(".gd_calendar_wrapper").find(".gd_loading").css("visibility", "hidden");
    });
}

jQuery(document).ready(function () {

    gd_calendar_month_datepicker();

});