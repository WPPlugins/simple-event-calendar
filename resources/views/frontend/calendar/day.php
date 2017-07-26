<?php
/**
 * Calendar Day View
 * @var $day
 */

$hours = array('All-day','12 AM','1 AM','2 AM','3 AM','4 AM','5 AM','6 AM','7 AM','8 AM','9 AM','10 AM','11 AM','12 PM','1 PM','2 PM','3 PM','4 PM','5 PM','6 PM','7 PM','8 PM','9 PM','10 PM','11 PM');

if(isset($_POST['date']) && !empty($_POST['date'])){
    $date = sanitize_text_field($_POST['date']);
    $_day = sanitize_text_field(date("Y-m-d", strtotime($date)));
}
elseif (isset($_GET['datepicker_day']) && !empty($_GET['datepicker_day'])){
    $date = sanitize_text_field($_GET['datepicker_day']);
    $_day = sanitize_text_field(date("Y-m-d", strtotime($date)));
}
elseif (isset($_POST['more_events_date']) && !empty($_POST['more_events_date'])){
    $date = sanitize_text_field($_POST['more_events_date']);
    $_day = sanitize_text_field(date("Y-m-d", strtotime($date)));
}
elseif (isset($_POST['more_week_events_date']) && !empty($_POST['more_week_events_date'])){
    $date = sanitize_text_field($_POST['more_week_events_date']);
    $_day = sanitize_text_field(date("Y-m-d", strtotime($date)));
}
else{
    $_day = $day->get_current_date();
}

if(isset($_POST['search']) && !empty($_POST['search'])){
    $_GET['search'] = sanitize_text_field($_POST['search']);
}

$searched_events_id = '';
if(isset($_GET['search']) && !empty($_GET['search'])){
    $searched_events_id = array_map('absint', $day->get_searched_event());
    if(empty($day->get_searched_event())){
        ?>
        <div class="gd_calendar_message">
            <?php esc_html_e('No results found', 'gd-calendar'); ?>
        </div>
        <?php
    }
}

$hour_events = \GDCalendar\Helpers\CalendarBuilder::get_event_by_hour($_day);
?>
    <div class="gd_calendar_day_title"><?php echo date('l F j, ', strtotime($_day)); ?><span class="gd_calendar_today"><?php echo date('Y', strtotime($_day)); ?></span></div>
    <div class="gd_calendar_day_box">
        <table class="gd_calendar_list">
        <?php
            foreach ($hours as $hour){
                if($hour === '12 PM'){
                    $hour = 'noon';
                }
        ?>
            <tr>
                <td class="gd_calendar_hour"><?php echo $hour; ?></td>
                <?php
                $field_count = 5;
                $count = 0;
                $searched_events = array();
                $searched_hour_events = array();

                if(array_key_exists(strtolower($hour), $hour_events)){
                    if(!empty($searched_events_id)){
                        $searched_events[strtolower($hour)][] = array_intersect($hour_events[strtolower($hour)], $searched_events_id);
                        foreach ($searched_events as $key => $value){
                            foreach ($value as $val){
                                if(!empty($val)){
                                    $searched_hour_events[$key] = $val;
                                }
                            }
                        }
                        $current_hour_events = $searched_hour_events[strtolower($hour)];
                    }
                    elseif(!isset($_GET['search']) || empty($_GET['search'])){
                        $current_hour_events = $hour_events[strtolower($hour)];
                    }
                }
                $count = count($current_hour_events);
                $empty_count = $field_count - $count;
                if(empty($current_hour_events) || !array_key_exists(strtolower($hour), $hour_events)){
                    ?>
                    <td class="gd_calendar_first_column"></td>
                    <td></td><td></td><td></td>
                    <td class="gd_calendar_last_column"></td>
                    <?php
                }else{
                    $counter = 1;
                    foreach ($current_hour_events as $key => $event_id){
                        $get_event = new \GDCalendar\Models\PostTypes\Event($event_id);
                        $start_time = substr($get_event->get_start_date(), 11, 8);
                        $end_time = substr($get_event->get_end_date(), 11, 8);
                        $all_day = "";
                        if($start_time == "" || $end_time == ""){
                            $all_day = __('All day','gd-calendar');
                        }
                        $backgrounds = array("#f7921e", "#d1ebc7", "#bee6f6");
                        $backgrounds_key = array_rand($backgrounds);
                        $selected_background = $backgrounds[$backgrounds_key];
                        if($count === 1){
                            ?>
                            <td colspan="5" class="gd_calendar_hour_event" style="background-color: <?php echo $selected_background; ?>">
                                <p><?php echo esc_html($start_time) . $all_day ?></p>
                                <a class="gd_calendar_one_day_hover_link" href="<?php echo get_permalink($event_id); ?>"><?php echo get_the_title($event_id); ?></a>
                            </td>
                            <td class="gd_calendar_day_hover_box_wrapper">
                                <div class="gd_calendar_day_hover_box">
                                    <h3><?php echo get_the_title($event_id); ?></h3><p><?php echo $all_day; ?></p>
                                    <p><?php _e('Starts','gd-calendar'); echo ' ' . $get_event->get_start_date(); ?></p>
                                    <p><?php _e('Ends','gd-calendar'); echo ' ' . $get_event->get_end_date(); ?></p>
                                </div>
                            </td>
                            <?php
                        }else{
                            if($counter <= 5){
                                ?>
                                <td class="gd_calendar_hour_event" style="background-color: <?php echo $selected_background; ?>">
                                    <p><?php echo esc_html($start_time); ?></p>
                                    <a class="gd_calendar_more_day_hover_link" href="<?php echo get_permalink($event_id); ?>"><?php echo get_the_title($event_id); ?></a>
                                    <input class="start_event_hover" type="hidden" value="<?php _e('Starts','gd-calendar'); echo ' ' . $get_event->get_start_date(); ?>">
                                    <input class="end_event_hover" type="hidden" value="<?php _e('Ends','gd-calendar'); echo ' ' . $get_event->get_end_date(); ?>">
                                </td>
                                <?php
                                $counter++;
                            }
                        }
                    }
                    if( $count > 1 ){
                        for( $i=0; $i < $empty_count; $i++ ){
                            ?><td></td><?php
                        }
                        ?>
                        <td class="gd_calendar_day_hover_box_wrapper">
                            <div class="gd_calendar_day_hover_more_box"></div>
                        </td>
                        <?php
                    }
                }
            } ?>
            </tr>
        </table>
    </div>